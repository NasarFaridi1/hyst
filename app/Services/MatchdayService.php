<?php

namespace App\Services;

use App\Models\FantasyChallenge;
use App\Models\FantasyGame;
use App\Models\FantasyGameEvent;
use App\Models\FantasyTeam;
use App\Models\MatchdayCampaign;
use App\Models\Notification;
use App\Models\Order;
use App\Models\OrderUnlockEntitlement;
use App\Models\PlayerAccessShare;
use App\Models\PlayerCatalogue;
use App\Models\PlayerCopy;
use App\Models\PlayerTransfer;
use App\Models\PlayerUnlockHistory;
use App\Models\TeamPlayerSelection;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class MatchdayService
{
    /**
     * Safely evaluate an order when it reaches completed / delivered status
     * and issue a player-choice entitlement if eligible.
     */
    public function processOrderCompletion(Order $order): ?OrderUnlockEntitlement
    {
        if (!$order->user_id) {
            return null;
        }

        $campaign = MatchdayCampaign::active()->first();
        if (!$campaign) {
            return null;
        }

        $orderTotal = (float) ($order->total_amount ?? 0);
        if ($orderTotal < (float) $campaign->min_order_amount) {
            return null;
        }

        // Idempotency check: prevent duplicate entitlement for same order and campaign
        $existing = OrderUnlockEntitlement::where('order_id', $order->id)
            ->where('campaign_id', $campaign->id)
            ->first();

        if ($existing) {
            return $existing;
        }

        $expiry = $campaign->entitlement_expiry_days > 0
            ? now()->addDays($campaign->entitlement_expiry_days)
            : null;

        $entitlement = OrderUnlockEntitlement::create([
            'order_id'          => $order->id,
            'user_id'           => $order->user_id,
            'campaign_id'       => $campaign->id,
            'total_choices'     => $campaign->choices_per_order,
            'choices_remaining' => $campaign->choices_per_order,
            'status'            => 'pending',
            'expires_at'        => $expiry,
        ]);

        // Create in-app notification if notifications table exists
        try {
            Notification::create([
                'user_id'        => $order->user_id,
                'order_id'       => $order->id,
                'type'           => 'matchday_unlock',
                'title'          => '⚽ England Player Pick Unlocked!',
                'message'        => 'Your order #' . $order->id . ' has unlocked a free England footballer pick in Hyst Fantasy XI!',
                'reference_type' => 'order_unlock_entitlements',
                'reference_id'   => $entitlement->id,
                'is_read'        => 0,
            ]);
        } catch (\Throwable $e) {
            Log::warning('Matchday notification creation skipped: ' . $e->getMessage());
        }

        Log::info('MATCHDAY: Player pick entitlement issued', [
            'order_id'       => $order->id,
            'user_id'        => $order->user_id,
            'entitlement_id' => $entitlement->id,
        ]);

        return $entitlement;
    }

    /**
     * Get pending entitlements for a user.
     */
    public function getPendingEntitlements(int $userId)
    {
        return OrderUnlockEntitlement::with('campaign', 'order')
            ->where('user_id', $userId)
            ->available()
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Get catalogue with indication of whether user already owns each player.
     */
    public function getCatalogueWithOwnership(int $userId, ?string $position = null)
    {
        $ownedCatalogueIds = PlayerCopy::where('current_owner_id', $userId)
            ->where('status', 'active')
            ->pluck('catalogue_id')
            ->toArray();

        $query = PlayerCatalogue::active();

        if ($position && in_array(strtoupper($position), ['GK', 'DEF', 'MID', 'FWD'])) {
            $query->where('position', strtoupper($position));
        }

        $players = $query->orderBy('overall_rating', 'desc')->get();

        return $players->map(function ($player) use ($ownedCatalogueIds) {
            $player->is_owned = in_array($player->id, $ownedCatalogueIds);
            return $player;
        });
    }

    /**
     * Customer actively claims a chosen player from the catalogue.
     */
    public function claimPlayerChoice(int $userId, int $entitlementId, int $catalogueId): array
    {
        return DB::transaction(function () use ($userId, $entitlementId, $catalogueId) {
            $entitlement = OrderUnlockEntitlement::where('id', $entitlementId)
                ->where('user_id', $userId)
                ->lockForUpdate()
                ->first();

            if (!$entitlement) {
                return ['success' => false, 'message' => 'Entitlement not found.'];
            }

            if ($entitlement->status !== 'pending' || $entitlement->choices_remaining <= 0) {
                return ['success' => false, 'message' => 'This entitlement has already been redeemed or expired.'];
            }

            if ($entitlement->expires_at && $entitlement->expires_at->isPast()) {
                $entitlement->update(['status' => 'expired']);
                return ['success' => false, 'message' => 'This entitlement has expired.'];
            }

            $player = PlayerCatalogue::active()->find($catalogueId);
            if (!$player) {
                return ['success' => false, 'message' => 'Player not found in active catalogue.'];
            }

            // Customer squad uniqueness rule: Check if already owns this player
            $alreadyOwns = PlayerCopy::where('current_owner_id', $userId)
                ->where('catalogue_id', $catalogueId)
                ->where('status', 'active')
                ->exists();

            if ($alreadyOwns) {
                return ['success' => false, 'message' => 'You already have ' . $player->name . ' in your squad collection!'];
            }

            // Mint new digital player card copy
            $playerCopy = PlayerCopy::create([
                'card_uuid'             => (string) Str::uuid(),
                'catalogue_id'          => $player->id,
                'original_owner_id'     => $userId,
                'current_owner_id'      => $userId,
                'source_order_id'       => $entitlement->order_id,
                'source_entitlement_id' => $entitlement->id,
                'acquisition_type'      => 'order_unlock',
                'is_locked'             => false,
                'status'                => 'active',
            ]);

            // Record audit trail
            PlayerUnlockHistory::create([
                'entitlement_id' => $entitlement->id,
                'user_id'        => $userId,
                'player_copy_id' => $playerCopy->id,
                'catalogue_id'   => $player->id,
                'selected_at'    => now(),
            ]);

            // Decrement remaining choices
            $remaining = $entitlement->choices_remaining - 1;
            $newStatus = ($remaining <= 0) ? 'redeemed' : 'pending';

            $entitlement->update([
                'choices_remaining' => $remaining,
                'status'            => $newStatus,
            ]);

            return [
                'success'     => true,
                'message'     => 'Congratulations! ' . $player->name . ' has joined your England squad!',
                'player'      => $player,
                'player_copy' => $playerCopy,
            ];
        });
    }

    /**
     * Get customer's player collection (Owned, Gifted, Shared).
     */
    public function getCustomerCollection(int $userId, ?string $position = null, string $filter = 'all')
    {
        // 1. Direct Owned Copies (Self-unlocked or received as gift)
        $copiesQuery = PlayerCopy::with('catalogue')
            ->where('current_owner_id', $userId)
            ->where('status', 'active');

        if ($position && in_array(strtoupper($position), ['GK', 'DEF', 'MID', 'FWD'])) {
            $copiesQuery->whereHas('catalogue', function ($q) use ($position) {
                $q->where('position', strtoupper($position));
            });
        }

        if ($filter === 'gifted') {
            $copiesQuery->where('acquisition_type', 'gift_received');
        } elseif ($filter === 'owned') {
            $copiesQuery->where('acquisition_type', '!=', 'gift_received');
        }

        $myCopies = $copiesQuery->get();

        // 2. Shared copies (borrowed from friends)
        $sharedCopies = collect();
        if ($filter === 'all' || $filter === 'shared') {
            $activeShares = PlayerAccessShare::with(['playerCopy.catalogue', 'owner'])
                ->where('borrower_id', $userId)
                ->active()
                ->get();

            $sharedCopies = $activeShares->map(function ($share) {
                $copy = $share->playerCopy;
                if ($copy) {
                    $copy->is_shared = true;
                    $copy->share_record = $share;
                }
                return $copy;
            })->filter();

            if ($position) {
                $sharedCopies = $sharedCopies->filter(function ($copy) use ($position) {
                    return $copy->catalogue && $copy->catalogue->position === strtoupper($position);
                });
            }
        }

        return [
            'owned'  => $myCopies->where('acquisition_type', '!=', 'gift_received'),
            'gifted' => $myCopies->where('acquisition_type', 'gift_received'),
            'shared' => $sharedCopies,
            'all'    => $myCopies->merge($sharedCopies),
        ];
    }

    /**
     * Gift player copy to another customer (ownership transfer).
     */
    public function giftPlayer(int $senderId, string $recipientIdentifier, int $playerCopyId, ?string $message = null): array
    {
        $playerCopy = PlayerCopy::with('catalogue')
            ->where('id', $playerCopyId)
            ->where('current_owner_id', $senderId)
            ->where('status', 'active')
            ->first();

        if (!$playerCopy) {
            return ['success' => false, 'message' => 'Player card not found or you do not own it.'];
        }

        // Find recipient user by email or ID or phone
        $recipient = User::where('id', $recipientIdentifier)
            ->orWhere('email', $recipientIdentifier)
            ->first();

        if (!$recipient) {
            return ['success' => false, 'message' => 'Recipient customer was not found on Hyst. Please check email address.'];
        }

        if ($recipient->id === $senderId) {
            return ['success' => false, 'message' => 'You cannot gift a player to yourself!'];
        }

        // Check if recipient already owns this catalogue player
        $recipientAlreadyHas = PlayerCopy::where('current_owner_id', $recipient->id)
            ->where('catalogue_id', $playerCopy->catalogue_id)
            ->where('status', 'active')
            ->exists();

        if ($recipientAlreadyHas) {
            return ['success' => false, 'message' => $recipient->name . ' already has ' . $playerCopy->catalogue->name . ' in their squad!'];
        }

        DB::transaction(function () use ($playerCopy, $senderId, $recipient, $message) {
            // Transfer ownership
            $playerCopy->update([
                'current_owner_id' => $recipient->id,
                'acquisition_type' => 'gift_received',
            ]);

            // Log transfer
            PlayerTransfer::create([
                'player_copy_id' => $playerCopy->id,
                'sender_id'      => $senderId,
                'recipient_id'   => $recipient->id,
                'status'         => 'accepted',
                'message'        => $message,
                'created_at'     => now(),
                'responded_at'   => now(),
            ]);

            // Notify recipient
            try {
                Notification::create([
                    'user_id'        => $recipient->id,
                    'type'           => 'matchday_gift',
                    'title'          => '🎁 Footballer Gift Received!',
                    'message'        => auth()->user()->name . ' gifted you ' . $playerCopy->catalogue->name . ' for your England XI squad!',
                    'reference_type' => 'player_copies',
                    'reference_id'   => $playerCopy->id,
                    'is_read'        => 0,
                ]);
            } catch (\Throwable $e) {
                // Ignore notification error
            }
        });

        return ['success' => true, 'message' => 'Player ' . $playerCopy->catalogue->name . ' successfully gifted to ' . $recipient->name . '!'];
    }

    /**
     * Share temporary access to a player without losing ownership.
     */
    public function sharePlayer(int $ownerId, string $borrowerIdentifier, int $playerCopyId, int $durationDays = 7): array
    {
        $playerCopy = PlayerCopy::with('catalogue')
            ->where('id', $playerCopyId)
            ->where('current_owner_id', $ownerId)
            ->where('status', 'active')
            ->first();

        if (!$playerCopy) {
            return ['success' => false, 'message' => 'Player card not found or you do not own it.'];
        }

        $borrower = User::where('id', $borrowerIdentifier)
            ->orWhere('email', $borrowerIdentifier)
            ->first();

        if (!$borrower) {
            return ['success' => false, 'message' => 'Friend not found on Hyst.'];
        }

        if ($borrower->id === $ownerId) {
            return ['success' => false, 'message' => 'You cannot share with yourself.'];
        }

        PlayerAccessShare::updateOrCreate(
            [
                'player_copy_id' => $playerCopy->id,
                'owner_id'       => $ownerId,
                'borrower_id'    => $borrower->id,
            ],
            [
                'status'     => 'active',
                'expires_at' => now()->addDays($durationDays),
            ]
        );

        return ['success' => true, 'message' => 'Successfully shared ' . $playerCopy->catalogue->name . ' with ' . $borrower->name . ' for ' . $durationDays . ' days!'];
    }

    /**
     * Get or build user's England Fantasy XI Team.
     */
    public function getUserTeam(int $userId): ?FantasyTeam
    {
        return FantasyTeam::with(['selections.playerCopy.catalogue', 'captain.catalogue'])
            ->where('user_id', $userId)
            ->where('is_active', 1)
            ->first();
    }

    /**
     * Save England Fantasy XI Team with formation validation and strength calculation.
     */
    public function saveFantasyTeam(int $userId, string $teamName, string $formation, array $positionAssignments, ?int $captainCopyId): array
    {
        if (!in_array($formation, ['4-3-3', '4-4-2', '3-5-2'])) {
            $formation = '4-3-3';
        }

        // Validate that user owns or has active shared access to all chosen player copies
        $copyIds = array_filter(array_values($positionAssignments));
        if (count($copyIds) < 11) {
            return ['success' => false, 'message' => 'Your England XI team must have exactly 11 players selected!'];
        }

        if (count(array_unique($copyIds)) !== count($copyIds)) {
            return ['success' => false, 'message' => 'Duplicate players detected. Each slot must be a unique player.'];
        }

        // Fetch all selected player copies
        $playerCopies = PlayerCopy::with('catalogue')
            ->whereIn('id', $copyIds)
            ->where('status', 'active')
            ->get()
            ->keyBy('id');

        // Check ownership or active share for every copy
        $sharedIds = PlayerAccessShare::where('borrower_id', $userId)
            ->active()
            ->pluck('player_copy_id')
            ->toArray();

        $totalStrength = 0;
        foreach ($copyIds as $cid) {
            $copy = $playerCopies->get($cid);
            if (!$copy) {
                return ['success' => false, 'message' => 'One or more selected players are no longer available.'];
            }

            $isOwner = ($copy->current_owner_id === $userId);
            $isShared = in_array($cid, $sharedIds);

            if (!$isOwner && !$isShared) {
                return ['success' => false, 'message' => 'You do not have permission to use player: ' . ($copy->catalogue->name ?? 'Unknown')];
            }

            $rating = $copy->catalogue->overall_rating ?? 75;
            if ($captainCopyId && $cid == $captainCopyId) {
                $rating += 5; // Captain boost
            }
            $totalStrength += $rating;
        }

        $avgStrength = (int) round($totalStrength / 11);

        $team = DB::transaction(function () use ($userId, $teamName, $formation, $captainCopyId, $avgStrength, $positionAssignments, $sharedIds) {
            $team = FantasyTeam::updateOrCreate(
                ['user_id' => $userId, 'is_active' => 1],
                [
                    'name'                   => $teamName ?: 'My England XI',
                    'formation'              => $formation,
                    'captain_player_copy_id' => $captainCopyId,
                    'total_strength'         => $avgStrength,
                ]
            );

            // Clear previous selections and save new slots
            TeamPlayerSelection::where('team_id', $team->id)->delete();

            foreach ($positionAssignments as $slot => $copyId) {
                if ($copyId) {
                    TeamPlayerSelection::create([
                        'team_id'        => $team->id,
                        'player_copy_id' => $copyId,
                        'pitch_position' => $slot,
                        'is_shared'      => in_array($copyId, $sharedIds),
                        'created_at'     => now(),
                    ]);
                }
            }

            return $team;
        });

        return [
            'success' => true,
            'message' => 'Your England Fantasy XI squad has been successfully saved! Team Rating: ' . $avgStrength,
            'team'    => $team,
        ];
    }

    /**
     * Create 1v1 Friend Challenge.
     */
    public function createChallenge(int $challengerId, string $defenderIdentifier, int $teamId): array
    {
        $defender = User::where('id', $defenderIdentifier)
            ->orWhere('email', $defenderIdentifier)
            ->first();

        if (!$defender) {
            return ['success' => false, 'message' => 'Opponent not found on Hyst.'];
        }

        if ($defender->id === $challengerId) {
            return ['success' => false, 'message' => 'You cannot challenge yourself!'];
        }

        $challengerTeam = FantasyTeam::where('id', $teamId)
            ->where('user_id', $challengerId)
            ->first();

        if (!$challengerTeam) {
            return ['success' => false, 'message' => 'Please save your England XI team first before challenging.'];
        }

        $challenge = FantasyChallenge::create([
            'challenger_id'      => $challengerId,
            'defender_id'        => $defender->id,
            'challenger_team_id' => $challengerTeam->id,
            'status'             => 'pending',
            'expires_at'         => now()->addDays(3),
        ]);

        return ['success' => true, 'message' => 'Challenge sent to ' . $defender->name . '! Match will begin once accepted.', 'challenge' => $challenge];
    }

    /**
     * Accept Challenge and Run Transparent Match Simulation Engine.
     */
    public function playMatch(int $challengeId, int $defenderId, int $defenderTeamId): array
    {
        $challenge = FantasyChallenge::with(['challenger', 'defender', 'challengerTeam'])
            ->where('id', $challengeId)
            ->where('defender_id', $defenderId)
            ->where('status', 'pending')
            ->first();

        if (!$challenge) {
            return ['success' => false, 'message' => 'Challenge not found or already completed.'];
        }

        $defenderTeam = FantasyTeam::where('id', $defenderTeamId)
            ->where('user_id', $defenderId)
            ->first();

        if (!$defenderTeam) {
            return ['success' => false, 'message' => 'Please choose a valid team to play with.'];
        }

        // Execute Transparent Sector Calculation Engine
        $game = DB::transaction(function () use ($challenge, $defenderTeam) {
            $challengerTeam = $challenge->challengerTeam;

            // Load player stats for both squads
            $cSelections = TeamPlayerSelection::with('playerCopy.catalogue')->where('team_id', $challengerTeam->id)->get();
            $dSelections = TeamPlayerSelection::with('playerCopy.catalogue')->where('team_id', $defenderTeam->id)->get();

            // Aggregate Sector Attributes: Attack, Midfield, Defence, GK
            $cStats = $this->aggregateSectorStats($cSelections);
            $dStats = $this->aggregateSectorStats($dSelections);

            $cScore = 0;
            $dScore = 0;
            $events = [];

            // Midfield Battle: Determines chances created (3 to 6 per team)
            $midDelta = $cStats['midfield'] - $dStats['midfield'];
            $cChances = max(2, min(6, 4 + (int) round($midDelta / 15)));
            $dChances = max(2, min(6, 4 - (int) round($midDelta / 15)));

            // Simulation of Match Minutes
            $minutes = [14, 28, 39, 52, 68, 77, 86, 90];
            shuffle($minutes);

            // Challenger chances
            for ($i = 0; $i < $cChances; $i++) {
                $min = array_pop($minutes) ?? rand(10, 89);
                $attPlayer = $cStats['attackers']->random() ?? null;
                $defGk = $dStats['gk_name'] ?? 'Goalkeeper';

                $shotPower = ($attPlayer ? $attPlayer->catalogue->stat_attack : 75) + rand(-10, 10);
                $gkSaveAbility = $dStats['gk'] + rand(-5, 8);

                if ($shotPower > $gkSaveAbility) {
                    $cScore++;
                    $events[] = [
                        'minute'      => $min,
                        'event_type'  => 'goal',
                        'actor_name'  => $attPlayer ? $attPlayer->catalogue->name : 'Challenger Striker',
                        'description' => ($attPlayer ? $attPlayer->catalogue->name : 'Forward') . ' slots a clinical strike past ' . $defGk . '!',
                    ];
                } else {
                    $events[] = [
                        'minute'      => $min,
                        'event_type'  => 'save',
                        'actor_name'  => $defGk,
                        'description' => $defGk . ' pulls off a brilliant diving save to deny ' . ($attPlayer ? $attPlayer->catalogue->name : 'an attack') . '!',
                    ];
                }
            }

            // Defender chances
            for ($i = 0; $i < $dChances; $i++) {
                $min = array_pop($minutes) ?? rand(10, 89);
                $attPlayer = $dStats['attackers']->random() ?? null;
                $cDefGk = $cStats['gk_name'] ?? 'Goalkeeper';

                $shotPower = ($attPlayer ? $attPlayer->catalogue->stat_attack : 75) + rand(-10, 10);
                $gkSaveAbility = $cStats['gk'] + rand(-5, 8);

                if ($shotPower > $gkSaveAbility) {
                    $dScore++;
                    $events[] = [
                        'minute'      => $min,
                        'event_type'  => 'goal',
                        'actor_name'  => $attPlayer ? $attPlayer->catalogue->name : 'Striker',
                        'description' => ($attPlayer ? $attPlayer->catalogue->name : 'Striker') . ' hammers a top-corner finish past ' . $cDefGk . '!',
                    ];
                } else {
                    $events[] = [
                        'minute'      => $min,
                        'event_type'  => 'save',
                        'actor_name'  => $cDefGk,
                        'description' => $cDefGk . ' makes an acrobatic reflex stop!',
                    ];
                }
            }

            // Determine Winner
            $winnerId = null;
            if ($cScore > $dScore) {
                $winnerId = $challenge->challenger_id;
            } elseif ($dScore > $cScore) {
                $winnerId = $challenge->defender_id;
            }

            // Save Game Record
            $game = FantasyGame::create([
                'challenge_id'       => $challenge->id,
                'challenger_id'      => $challenge->challenger_id,
                'defender_id'        => $challenge->defender_id,
                'challenger_team_id' => $challengerTeam->id,
                'defender_team_id'   => $defenderTeam->id,
                'challenger_score'   => $cScore,
                'defender_score'     => $dScore,
                'winner_id'          => $winnerId,
                'match_summary'      => [
                    'challenger_stats' => ['att' => $cStats['attack'], 'mid' => $cStats['midfield'], 'def' => $cStats['defence'], 'gk' => $cStats['gk']],
                    'defender_stats'   => ['att' => $dStats['attack'], 'mid' => $dStats['midfield'], 'def' => $dStats['defence'], 'gk' => $dStats['gk']],
                ],
                'played_at'          => now(),
            ]);

            // Save Timeline Events
            usort($events, fn($a, $b) => $a['minute'] <=> $b['minute']);
            foreach ($events as $ev) {
                FantasyGameEvent::create([
                    'game_id'     => $game->id,
                    'minute'      => $ev['minute'],
                    'event_type'  => $ev['event_type'],
                    'actor_name'  => $ev['actor_name'],
                    'description' => $ev['description'],
                    'created_at'  => now(),
                ]);
            }

            // Update Challenge Status
            $challenge->update([
                'defender_team_id' => $defenderTeam->id,
                'status'           => 'completed',
            ]);

            return $game;
        });

        return [
            'success' => true,
            'message' => 'Match finished! Final Score: ' . $game->challenger_score . ' - ' . $game->defender_score,
            'game_id' => $game->id,
        ];
    }

    private function aggregateSectorStats($selections): array
    {
        $attSum = 0;
        $midSum = 0;
        $defSum = 0;
        $gkStat = 75;
        $gkName = 'Goalkeeper';
        $attackers = collect();

        foreach ($selections as $sel) {
            $cat = $sel->playerCopy->catalogue ?? null;
            if (!$cat) continue;

            if ($cat->position === 'GK') {
                $gkStat = $cat->stat_goalkeeping ?: 80;
                $gkName = $cat->name;
            } elseif ($cat->position === 'DEF') {
                $defSum += $cat->stat_defence;
            } elseif ($cat->position === 'MID') {
                $midSum += $cat->stat_midfield;
                $attackers->push($sel->playerCopy);
            } elseif ($cat->position === 'FWD') {
                $attSum += $cat->stat_attack;
                $attackers->push($sel->playerCopy);
            }
        }

        return [
            'attack'    => (int) round($attSum ?: 70),
            'midfield'  => (int) round($midSum ?: 70),
            'defence'   => (int) round($defSum ?: 70),
            'gk'        => $gkStat,
            'gk_name'   => $gkName,
            'attackers' => $attackers->isNotEmpty() ? $attackers : collect(),
        ];
    }
}
