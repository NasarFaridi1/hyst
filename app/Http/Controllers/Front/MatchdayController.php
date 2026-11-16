<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\FantasyChallenge;
use App\Models\FantasyGame;
use App\Models\FantasyTeam;
use App\Models\MatchdayCampaign;
use App\Models\OrderUnlockEntitlement;
use App\Models\PlayerCatalogue;
use App\Models\PlayerCopy;
use App\Models\User;
use App\Services\MatchdayService;
use Illuminate\Http\Request;

class MatchdayController extends Controller
{
    protected $matchdayService;

    public function __construct(MatchdayService $matchdayService)
    {
        $this->matchdayService = $matchdayService;
    }

    /**
     * Matchday Hub / Overview
     */
    public function index(Request $request)
    {
        savePageVisit($request, 'Hyst Fantasy XI Hub');
        $user = auth()->user();

        $campaign = MatchdayCampaign::active()->first();
        $pendingEntitlements = $this->matchdayService->getPendingEntitlements($user->id);
        $totalPicksRemaining = $pendingEntitlements->sum('choices_remaining');

        $collection = $this->matchdayService->getCustomerCollection($user->id);
        $ownedCount = $collection['all']->count();

        $team = $this->matchdayService->getUserTeam($user->id);

        $pendingChallengesCount = FantasyChallenge::where('defender_id', $user->id)
            ->where('status', 'pending')
            ->count();

        $recentGames = FantasyGame::with(['challenger', 'defender', 'challengerTeam', 'defenderTeam'])
            ->where(function ($q) use ($user) {
                $q->where('challenger_id', $user->id)->orWhere('defender_id', $user->id);
            })
            ->orderBy('played_at', 'desc')
            ->take(5)
            ->get();

        return view('front.matchday.index', compact(
            'campaign',
            'pendingEntitlements',
            'totalPicksRemaining',
            'ownedCount',
            'team',
            'pendingChallengesCount',
            'recentGames'
        ));
    }

    /**
     * Player Unlock & Selection Catalogue
     */
    public function unlock(Request $request)
    {
        savePageVisit($request, 'Hyst Fantasy XI - Player Unlock');
        $user = auth()->user();

        $pendingEntitlements = $this->matchdayService->getPendingEntitlements($user->id);
        $activeEntitlement = $pendingEntitlements->first();

        $position = $request->query('position');
        $players = $this->matchdayService->getCatalogueWithOwnership($user->id, $position);

        return view('front.matchday.unlock', compact('pendingEntitlements', 'activeEntitlement', 'players', 'position'));
    }

    /**
     * Submit Player Selection
     */
    public function claimPlayer(Request $request)
    {
        $request->validate([
            'entitlement_id' => 'required|integer',
            'catalogue_id'   => 'required|integer',
        ]);

        $res = $this->matchdayService->claimPlayerChoice(
            auth()->id(),
            (int) $request->entitlement_id,
            (int) $request->catalogue_id
        );

        if (!$res['success']) {
            return back()->with('error', $res['message']);
        }

        return redirect()->route('matchday.collection')->with('success', $res['message']);
    }

    /**
     * Customer Collection (My Players)
     */
    public function collection(Request $request)
    {
        savePageVisit($request, 'Hyst Fantasy XI - My Collection');
        $user = auth()->user();

        $position = $request->query('position');
        $filter = $request->query('filter', 'all');

        $collection = $this->matchdayService->getCustomerCollection($user->id, $position, $filter);

        return view('front.matchday.collection', compact('collection', 'position', 'filter'));
    }

    /**
     * Gift Player Card to a Friend
     */
    public function gift(Request $request)
    {
        $request->validate([
            'player_copy_id'       => 'required|integer',
            'recipient_identifier' => 'required|string',
            'message'              => 'nullable|string|max:200',
        ]);

        $res = $this->matchdayService->giftPlayer(
            auth()->id(),
            trim($request->recipient_identifier),
            (int) $request->player_copy_id,
            $request->message
        );

        if (!$res['success']) {
            return back()->with('error', $res['message']);
        }

        return back()->with('success', $res['message']);
    }

    /**
     * Share Temporary Access with a Friend
     */
    public function share(Request $request)
    {
        $request->validate([
            'player_copy_id'      => 'required|integer',
            'borrower_identifier' => 'required|string',
            'duration_days'       => 'nullable|integer|min:1|max:30',
        ]);

        $res = $this->matchdayService->sharePlayer(
            auth()->id(),
            trim($request->borrower_identifier),
            (int) $request->player_copy_id,
            (int) ($request->duration_days ?: 7)
        );

        if (!$res['success']) {
            return back()->with('error', $res['message']);
        }

        return back()->with('success', $res['message']);
    }

    /**
     * Build England Fantasy XI Pitch & Formation
     */
    public function team(Request $request)
    {
        savePageVisit($request, 'Hyst Fantasy XI - Team Builder');
        $user = auth()->user();

        $team = $this->matchdayService->getUserTeam($user->id);
        $collection = $this->matchdayService->getCustomerCollection($user->id);

        $existingSlots = [];
        if ($team) {
            foreach ($team->selections as $sel) {
                $existingSlots[$sel->pitch_position] = $sel->player_copy_id;
            }
        }

        return view('front.matchday.team', compact('team', 'collection', 'existingSlots'));
    }

    /**
     * Save Team Lineup
     */
    public function saveTeam(Request $request)
    {
        $request->validate([
            'name'       => 'nullable|string|max:60',
            'formation'  => 'required|string|in:4-3-3,4-4-2,3-5-2',
            'captain_id' => 'nullable|integer',
            'positions'  => 'required|array',
        ]);

        $res = $this->matchdayService->saveFantasyTeam(
            auth()->id(),
            $request->name ?: 'My England XI',
            $request->formation,
            $request->positions,
            $request->captain_id ? (int) $request->captain_id : null
        );

        if (!$res['success']) {
            return back()->with('error', $res['message']);
        }

        return redirect()->route('matchday.team')->with('success', $res['message']);
    }

    /**
     * Friend Challenges & Match History
     */
    public function challenges(Request $request)
    {
        savePageVisit($request, 'Hyst Fantasy XI - Challenges');
        $user = auth()->user();

        $myTeam = $this->matchdayService->getUserTeam($user->id);

        $incomingChallenges = FantasyChallenge::with(['challenger', 'challengerTeam'])
            ->where('defender_id', $user->id)
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();

        $outgoingChallenges = FantasyChallenge::with(['defender', 'challengerTeam'])
            ->where('challenger_id', $user->id)
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();

        $recentGames = FantasyGame::with(['challenger', 'defender', 'challengerTeam', 'defenderTeam', 'winner'])
            ->where(function ($q) use ($user) {
                $q->where('challenger_id', $user->id)->orWhere('defender_id', $user->id);
            })
            ->orderBy('played_at', 'desc')
            ->paginate(10);

        return view('front.matchday.challenges', compact('myTeam', 'incomingChallenges', 'outgoingChallenges', 'recentGames'));
    }

    /**
     * Send Challenge to a Friend
     */
    public function createChallenge(Request $request)
    {
        $request->validate([
            'defender_identifier' => 'required|string',
            'team_id'             => 'required|integer',
        ]);

        $res = $this->matchdayService->createChallenge(
            auth()->id(),
            trim($request->defender_identifier),
            (int) $request->team_id
        );

        if (!$res['success']) {
            return back()->with('error', $res['message']);
        }

        return back()->with('success', $res['message']);
    }

    /**
     * Play / Accept Challenge
     */
    public function playChallenge(Request $request, $id)
    {
        $request->validate([
            'team_id' => 'required|integer',
        ]);

        $res = $this->matchdayService->playMatch(
            (int) $id,
            auth()->id(),
            (int) $request->team_id
        );

        if (!$res['success']) {
            return back()->with('error', $res['message']);
        }

        return redirect()->route('matchday.match-result', ['id' => $res['game_id']])
            ->with('success', $res['message']);
    }

    /**
     * Match Report & Event Breakdown
     */
    public function matchResult($id)
    {
        $game = FantasyGame::with(['challenger', 'defender', 'challengerTeam', 'defenderTeam', 'winner', 'events'])
            ->findOrFail($id);

        return view('front.matchday.match-result', compact('game'));
    }

    /**
     * Leaderboard & £500 Prize Tracker
     */
    public function leaderboard()
    {
        $topManagers = User::select('users.id', 'users.name')
            ->join('fantasy_games', function ($join) {
                $join->on('users.id', '=', 'fantasy_games.winner_id');
            })
            ->selectRaw('COUNT(fantasy_games.id) as wins')
            ->selectRaw('COUNT(fantasy_games.id) * 3 as points')
            ->groupBy('users.id', 'users.name')
            ->orderBy('points', 'desc')
            ->take(20)
            ->get();

        return view('front.matchday.leaderboard', compact('topManagers'));
    }
}
