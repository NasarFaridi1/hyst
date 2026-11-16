<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PlayerCatalogue;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MatchdayPlayerController extends Controller
{
    /**
     * Display a paginated listing of players with filters.
     */
    public function index(Request $request)
    {
        $query = PlayerCatalogue::query();

        // Search by name, display name, or club
        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('display_name', 'like', "%{$search}%")
                  ->orWhere('club_name', 'like', "%{$search}%");
            });
        }

        // Filter by position
        if ($request->filled('position')) {
            $query->where('position', $request->position);
        }

        // Filter by rarity
        if ($request->filled('rarity')) {
            $query->where('rarity', $request->rarity);
        }

        // Filter by status
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', 1);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', 0);
            }
        }

        // Sorting
        $sort = $request->get('sort', 'rating_desc');
        switch ($sort) {
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            case 'rating_asc':
                $query->orderBy('overall_rating', 'asc');
                break;
            case 'newest':
                $query->latest();
                break;
            case 'rating_desc':
            default:
                $query->orderBy('overall_rating', 'desc');
                break;
        }

        $players = $query->paginate(15)->withQueryString();

        // Quick aggregate statistics
        $stats = [
            'total' => PlayerCatalogue::count(),
            'active' => PlayerCatalogue::where('is_active', 1)->count(),
            'gk' => PlayerCatalogue::where('position', 'GK')->count(),
            'def' => PlayerCatalogue::where('position', 'DEF')->count(),
            'mid' => PlayerCatalogue::where('position', 'MID')->count(),
            'fwd' => PlayerCatalogue::where('position', 'FWD')->count(),
            'avg_rating' => round(PlayerCatalogue::avg('overall_rating') ?? 0, 1),
        ];

        return view('admin.matchday.players.index', compact('players', 'stats'));
    }

    /**
     * Show the form for creating a new player.
     */
    public function create()
    {
        return view('admin.matchday.players.create');
    }

    /**
     * Store a newly created player.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:150',
            'display_name' => 'nullable|string|max:150',
            'club_name' => 'required|string|max:150',
            'position' => 'required|in:GK,DEF,MID,FWD',
            'sub_position' => 'nullable|string|max:50',
            'nationality' => 'nullable|string|max:100',
            'rarity' => 'required|in:common,rare,epic,legendary',
            'overall_rating' => 'required|integer|min:40|max:99',
            'stat_attack' => 'required|integer|min:0|max:99',
            'stat_defence' => 'required|integer|min:0|max:99',
            'stat_midfield' => 'required|integer|min:0|max:99',
            'stat_goalkeeping' => 'required|integer|min:0|max:99',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:5120',
            'avatar_url' => 'nullable|string|max:255',
            'is_active' => 'nullable|boolean',
        ]);

        $avatarUrl = $request->input('avatar_url');

        // Handle uploaded image file
        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $dir = public_path('images/players');
            if (!file_exists($dir)) {
                mkdir($dir, 0755, true);
            }
            $filename = Str::slug($request->name) . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move($dir, $filename);
            $avatarUrl = 'images/players/' . $filename;
        }

        PlayerCatalogue::create([
            'name' => trim($request->name),
            'display_name' => trim($request->display_name ?: $request->name),
            'club_name' => trim($request->club_name),
            'position' => $request->position,
            'sub_position' => $request->sub_position ? trim($request->sub_position) : null,
            'nationality' => $request->nationality ? trim($request->nationality) : 'England',
            'avatar_url' => $avatarUrl,
            'rarity' => $request->rarity,
            'overall_rating' => (int) $request->overall_rating,
            'stat_attack' => (int) $request->stat_attack,
            'stat_defence' => (int) $request->stat_defence,
            'stat_midfield' => (int) $request->stat_midfield,
            'stat_goalkeeping' => (int) $request->stat_goalkeeping,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);

        return redirect()->route('admin.matchday.players.index')
            ->with('success', "Player \"{$request->name}\" added successfully to the squad catalogue!");
    }

    /**
     * Show the form for editing the specified player.
     */
    public function edit($id)
    {
        $player = PlayerCatalogue::findOrFail($id);
        return view('admin.matchday.players.edit', compact('player'));
    }

    /**
     * Update the specified player.
     */
    public function update(Request $request, $id)
    {
        $player = PlayerCatalogue::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:150',
            'display_name' => 'nullable|string|max:150',
            'club_name' => 'required|string|max:150',
            'position' => 'required|in:GK,DEF,MID,FWD',
            'sub_position' => 'nullable|string|max:50',
            'nationality' => 'nullable|string|max:100',
            'rarity' => 'required|in:common,rare,epic,legendary',
            'overall_rating' => 'required|integer|min:40|max:99',
            'stat_attack' => 'required|integer|min:0|max:99',
            'stat_defence' => 'required|integer|min:0|max:99',
            'stat_midfield' => 'required|integer|min:0|max:99',
            'stat_goalkeeping' => 'required|integer|min:0|max:99',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:5120',
            'avatar_url' => 'nullable|string|max:255',
            'is_active' => 'nullable|boolean',
        ]);

        $avatarUrl = $request->input('avatar_url') ?: $player->avatar_url;

        // If a new image file is uploaded
        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $dir = public_path('images/players');
            if (!file_exists($dir)) {
                mkdir($dir, 0755, true);
            }
            $filename = Str::slug($request->name) . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move($dir, $filename);

            // Optional: delete old local file if present
            if ($player->avatar_url && !str_starts_with($player->avatar_url, 'http') && file_exists(public_path($player->avatar_url))) {
                @unlink(public_path($player->avatar_url));
            }

            $avatarUrl = 'images/players/' . $filename;
        }

        $player->update([
            'name' => trim($request->name),
            'display_name' => trim($request->display_name ?: $request->name),
            'club_name' => trim($request->club_name),
            'position' => $request->position,
            'sub_position' => $request->sub_position ? trim($request->sub_position) : null,
            'nationality' => $request->nationality ? trim($request->nationality) : 'England',
            'avatar_url' => $avatarUrl,
            'rarity' => $request->rarity,
            'overall_rating' => (int) $request->overall_rating,
            'stat_attack' => (int) $request->stat_attack,
            'stat_defence' => (int) $request->stat_defence,
            'stat_midfield' => (int) $request->stat_midfield,
            'stat_goalkeeping' => (int) $request->stat_goalkeeping,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);

        return redirect()->route('admin.matchday.players.index')
            ->with('success', "Player \"{$player->name}\" updated successfully!");
    }

    /**
     * Remove the specified player.
     */
    public function destroy($id)
    {
        $player = PlayerCatalogue::findOrFail($id);
        $name = $player->name;

        // Delete local image file if stored
        if ($player->avatar_url && !str_starts_with($player->avatar_url, 'http') && file_exists(public_path($player->avatar_url))) {
            @unlink(public_path($player->avatar_url));
        }

        $player->delete();

        return redirect()->route('admin.matchday.players.index')
            ->with('success', "Player \"{$name}\" removed from catalogue.");
    }

    /**
     * Quick status toggle (Active / Inactive).
     */
    public function toggleStatus($id)
    {
        $player = PlayerCatalogue::findOrFail($id);
        $player->is_active = !$player->is_active;
        $player->save();

        $statusText = $player->is_active ? 'activated' : 'deactivated';
        return redirect()->back()->with('success', "Player \"{$player->name}\" is now {$statusText}.");
    }

    /**
     * Seed or sync default England 23-man squad with photos and ratings.
     */
    public function seedDefaults()
    {
        $squad = [
            // Goalkeepers
            ['name' => 'Jordan Pickford', 'display_name' => 'Pickford', 'pos' => 'GK', 'sub' => 'Goalkeeper', 'club' => 'Everton', 'ovr' => 84, 'att' => 15, 'mid' => 45, 'def' => 84, 'gk' => 86, 'rarity' => 'rare', 'img' => 'https://resources.premierleague.com/premierleague/photos/players/250x250/p111234.png'],
            ['name' => 'Aaron Ramsdale', 'display_name' => 'Ramsdale', 'pos' => 'GK', 'sub' => 'Goalkeeper', 'club' => 'Southampton', 'ovr' => 81, 'att' => 12, 'mid' => 40, 'def' => 81, 'gk' => 82, 'rarity' => 'common', 'img' => 'https://resources.premierleague.com/premierleague/photos/players/250x250/p225321.png'],
            ['name' => 'Dean Henderson', 'display_name' => 'Henderson', 'pos' => 'GK', 'sub' => 'Goalkeeper', 'club' => 'Crystal Palace', 'ovr' => 80, 'att' => 10, 'mid' => 38, 'def' => 80, 'gk' => 81, 'rarity' => 'common', 'img' => 'https://resources.premierleague.com/premierleague/photos/players/250x250/p172649.png'],

            // Defenders
            ['name' => 'Kyle Walker', 'display_name' => 'Walker', 'pos' => 'DEF', 'sub' => 'Right Back', 'club' => 'Manchester City', 'ovr' => 84, 'att' => 68, 'mid' => 75, 'def' => 84, 'gk' => 15, 'rarity' => 'rare', 'img' => 'https://resources.premierleague.com/premierleague/photos/players/250x250/p58621.png'],
            ['name' => 'John Stones', 'display_name' => 'Stones', 'pos' => 'DEF', 'sub' => 'Centre Back', 'club' => 'Manchester City', 'ovr' => 86, 'att' => 64, 'mid' => 80, 'def' => 87, 'gk' => 14, 'rarity' => 'rare', 'img' => 'https://resources.premierleague.com/premierleague/photos/players/250x250/p97299.png'],
            ['name' => 'Marc Guéhi', 'display_name' => 'Guéhi', 'pos' => 'DEF', 'sub' => 'Centre Back', 'club' => 'Crystal Palace', 'ovr' => 83, 'att' => 45, 'mid' => 70, 'def' => 84, 'gk' => 12, 'rarity' => 'common', 'img' => 'https://resources.premierleague.com/premierleague/photos/players/250x250/p209036.png'],
            ['name' => 'Kieran Trippier', 'display_name' => 'Trippier', 'pos' => 'DEF', 'sub' => 'Full Back', 'club' => 'Newcastle United', 'ovr' => 83, 'att' => 74, 'mid' => 81, 'def' => 81, 'gk' => 10, 'rarity' => 'common', 'img' => 'https://resources.premierleague.com/premierleague/photos/players/250x250/p77794.png'],
            ['name' => 'Trent Alexander-Arnold', 'display_name' => 'Alexander-Arnold', 'pos' => 'DEF', 'sub' => 'Right Back / Wing Back', 'club' => 'Liverpool', 'ovr' => 87, 'att' => 80, 'mid' => 88, 'def' => 80, 'gk' => 12, 'rarity' => 'epic', 'img' => 'https://resources.premierleague.com/premierleague/photos/players/250x250/p169187.png'],
            ['name' => 'Ezri Konsa', 'display_name' => 'Konsa', 'pos' => 'DEF', 'sub' => 'Centre Back', 'club' => 'Aston Villa', 'ovr' => 82, 'att' => 40, 'mid' => 68, 'def' => 83, 'gk' => 10, 'rarity' => 'common', 'img' => 'https://resources.premierleague.com/premierleague/photos/players/250x250/p199798.png'],
            ['name' => 'Levi Colwill', 'display_name' => 'Colwill', 'pos' => 'DEF', 'sub' => 'Centre Back', 'club' => 'Chelsea', 'ovr' => 81, 'att' => 45, 'mid' => 70, 'def' => 82, 'gk' => 10, 'rarity' => 'common', 'img' => 'https://resources.premierleague.com/premierleague/photos/players/250x250/p461530.png'],

            // Midfielders
            ['name' => 'Jude Bellingham', 'display_name' => 'Bellingham', 'pos' => 'MID', 'sub' => 'Central Midfield', 'club' => 'Real Madrid', 'ovr' => 90, 'att' => 87, 'mid' => 90, 'def' => 78, 'gk' => 14, 'rarity' => 'legendary', 'img' => 'https://resources.premierleague.com/premierleague/photos/players/250x250/p248857.png'],
            ['name' => 'Declan Rice', 'display_name' => 'Rice', 'pos' => 'MID', 'sub' => 'Defensive Midfield', 'club' => 'Arsenal', 'ovr' => 87, 'att' => 72, 'mid' => 86, 'def' => 88, 'gk' => 12, 'rarity' => 'epic', 'img' => 'https://resources.premierleague.com/premierleague/photos/players/250x250/p204480.png'],
            ['name' => 'Cole Palmer', 'display_name' => 'Palmer', 'pos' => 'MID', 'sub' => 'Attacking Midfield', 'club' => 'Chelsea', 'ovr' => 88, 'att' => 88, 'mid' => 89, 'def' => 48, 'gk' => 12, 'rarity' => 'legendary', 'img' => 'https://resources.premierleague.com/premierleague/photos/players/250x250/p244855.png'],
            ['name' => 'Phil Foden', 'display_name' => 'Foden', 'pos' => 'MID', 'sub' => 'Attacking Midfield / Wing', 'club' => 'Manchester City', 'ovr' => 88, 'att' => 87, 'mid' => 88, 'def' => 56, 'gk' => 10, 'rarity' => 'epic', 'img' => 'https://resources.premierleague.com/premierleague/photos/players/250x250/p209244.png'],
            ['name' => 'Kobbie Mainoo', 'display_name' => 'Mainoo', 'pos' => 'MID', 'sub' => 'Central Midfield', 'club' => 'Manchester United', 'ovr' => 82, 'att' => 72, 'mid' => 83, 'def' => 75, 'gk' => 10, 'rarity' => 'rare', 'img' => 'https://resources.premierleague.com/premierleague/photos/players/250x250/p543841.png'],
            ['name' => 'Conor Gallagher', 'display_name' => 'Gallagher', 'pos' => 'MID', 'sub' => 'Box-to-Box Midfield', 'club' => 'Atletico Madrid', 'ovr' => 82, 'att' => 76, 'mid' => 82, 'def' => 78, 'gk' => 10, 'rarity' => 'common', 'img' => 'https://resources.premierleague.com/premierleague/photos/players/250x250/p232787.png'],
            ['name' => 'Eberechi Eze', 'display_name' => 'Eze', 'pos' => 'MID', 'sub' => 'Attacking Midfield', 'club' => 'Crystal Palace', 'ovr' => 83, 'att' => 82, 'mid' => 84, 'def' => 52, 'gk' => 10, 'rarity' => 'rare', 'img' => 'https://resources.premierleague.com/premierleague/photos/players/250x250/p232413.png'],

            // Forwards
            ['name' => 'Harry Kane', 'display_name' => 'Kane', 'pos' => 'FWD', 'sub' => 'Striker', 'club' => 'Bayern Munich', 'ovr' => 90, 'att' => 93, 'mid' => 85, 'def' => 46, 'gk' => 15, 'rarity' => 'legendary', 'img' => 'https://resources.premierleague.com/premierleague/photos/players/250x250/p78830.png'],
            ['name' => 'Bukayo Saka', 'display_name' => 'Saka', 'pos' => 'FWD', 'sub' => 'Right Wing', 'club' => 'Arsenal', 'ovr' => 88, 'att' => 89, 'mid' => 84, 'def' => 65, 'gk' => 10, 'rarity' => 'legendary', 'img' => 'https://resources.premierleague.com/premierleague/photos/players/250x250/p223340.png'],
            ['name' => 'Ollie Watkins', 'display_name' => 'Watkins', 'pos' => 'FWD', 'sub' => 'Striker', 'club' => 'Aston Villa', 'ovr' => 85, 'att' => 87, 'mid' => 74, 'def' => 42, 'gk' => 10, 'rarity' => 'rare', 'img' => 'https://resources.premierleague.com/premierleague/photos/players/250x250/p178301.png'],
            ['name' => 'Anthony Gordon', 'display_name' => 'Gordon', 'pos' => 'FWD', 'sub' => 'Left Wing', 'club' => 'Newcastle United', 'ovr' => 83, 'att' => 84, 'mid' => 78, 'def' => 54, 'gk' => 10, 'rarity' => 'rare', 'img' => 'https://resources.premierleague.com/premierleague/photos/players/250x250/p232826.png'],
            ['name' => 'Jarrod Bowen', 'display_name' => 'Bowen', 'pos' => 'FWD', 'sub' => 'Right Wing', 'club' => 'West Ham United', 'ovr' => 83, 'att' => 84, 'mid' => 78, 'def' => 52, 'gk' => 10, 'rarity' => 'common', 'img' => 'https://resources.premierleague.com/premierleague/photos/players/250x250/p178186.png'],
            ['name' => 'Ivan Toney', 'display_name' => 'Toney', 'pos' => 'FWD', 'sub' => 'Striker', 'club' => 'Al-Ahli', 'ovr' => 82, 'att' => 84, 'mid' => 70, 'def' => 45, 'gk' => 10, 'rarity' => 'common', 'img' => 'https://resources.premierleague.com/premierleague/photos/players/250x250/p144485.png'],
        ];

        $synced = 0;
        foreach ($squad as $p) {
            PlayerCatalogue::updateOrCreate(
                ['name' => $p['name']],
                [
                    'display_name' => $p['display_name'],
                    'position' => $p['pos'],
                    'sub_position' => $p['sub'],
                    'club_name' => $p['club'],
                    'nationality' => 'England',
                    'avatar_url' => $p['img'],
                    'rarity' => $p['rarity'],
                    'overall_rating' => $p['ovr'],
                    'stat_attack' => $p['att'],
                    'stat_defence' => $p['def'],
                    'stat_midfield' => $p['mid'],
                    'stat_goalkeeping' => $p['gk'],
                    'is_active' => 1,
                ]
            );
            $synced++;
        }

        return redirect()->route('admin.matchday.players.index')
            ->with('success', "Successfully synced {$synced} official England national players into the squad catalogue!");
    }
}
