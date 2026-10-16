<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Community;
use App\Models\CommunityMember;
use App\Models\CommunityPost;
use App\Models\CommunityPostLike;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class CommunityController extends Controller
{
    /**
     * Display the Hyst Foodie Community & Feed
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $userCircle = null;
        $posts = collect();
        $joinedCircles = collect();
        $restaurants = collect();

        try {
            if ($user) {
                // Get or create primary circle for logged in user
                $userCircle = Community::getOrCreateForUser($user);

                // Fetch circles where user is a member
                $communityIds = CommunityMember::where('user_id', $user->id)
                    ->pluck('community_id');

                if ($userCircle && !$communityIds->contains($userCircle->id)) {
                    $communityIds->push($userCircle->id);
                }

                $joinedCircles = Community::whereIn('id', $communityIds)->with('creator')->get();

                // Fetch posts from these circles (or general featured if empty)
                $posts = CommunityPost::whereIn('community_id', $communityIds)
                    ->with(['user', 'restaurant', 'product', 'likes'])
                    ->latest()
                    ->take(30)
                    ->get();
            }

            // If feed has few/no posts, show general community activity
            if ($posts->isEmpty()) {
                $posts = CommunityPost::with(['user', 'restaurant', 'product', 'likes'])
                    ->latest()
                    ->take(15)
                    ->get();
            }

            // Top restaurants for food tagging
            $restaurants = Restaurant::where('status', 1)
                ->take(20)
                ->get(['id', 'name', 'slug', 'image']);

        } catch (\Throwable $e) {
            // Failsafe in case DB schema is pending deployment
            $posts = collect();
            $joinedCircles = collect();
            $restaurants = collect();
        }

        // WhatsApp invite link for the user's circle
        $inviteCode = $userCircle ? $userCircle->invite_code : 'HYST';
        $inviteUrl = url("/community/join/{$inviteCode}");
        $shareText = urlencode("Hey! I'm using HYST to order authentic local food with zero hidden markups. Join my Foodie Circle so we can swap our favorite food picks and reviews: {$inviteUrl}");
        $whatsappShareUrl = "https://api.whatsapp.com/send?text={$shareText}";

        return view('front.community.index', compact(
            'user',
            'userCircle',
            'joinedCircles',
            'posts',
            'restaurants',
            'inviteUrl',
            'whatsappShareUrl'
        ));
    }

    /**
     * Handle incoming WhatsApp invite link (/community/join/{code})
     */
    public function showJoinModal(Request $request, $code)
    {
        $code = trim($code);
        $user = Auth::user();

        try {
            $circle = Community::where('invite_code', $code)->with('creator')->first();

            if (!$circle) {
                return redirect()->route('front.community.index')->with('error', 'Invalid or expired community invite code.');
            }

            // If user is not logged in, remember the invite code in session and ask to sign in
            if (!$user) {
                session(['pending_community_invite' => $code]);
                return view('front.community.join', [
                    'circle'          => $circle,
                    'requiresAuth'    => true,
                    'alreadyMember'   => false,
                    'isOwnCircle'     => false,
                ]);
            }

            // If it's their own circle
            if ($circle->creator_user_id === $user->id) {
                return redirect()->route('front.community.index')
                    ->with('info', "This is your own Foodie Circle! Share the invite link with friends on WhatsApp.");
            }

            // Check if already a member
            $isMember = CommunityMember::where('community_id', $circle->id)
                ->where('user_id', $user->id)
                ->exists();

            if ($isMember) {
                return redirect()->route('front.community.index')
                    ->with('info', "You are already a member of {$circle->name}!");
            }

            return view('front.community.join', [
                'circle'        => $circle,
                'requiresAuth'  => false,
                'alreadyMember' => false,
                'isOwnCircle'   => false,
            ]);

        } catch (\Throwable $e) {
            return redirect()->route('front.community.index');
        }
    }

    /**
     * Submit joining a community
     */
    public function joinCommunity(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect('/login')->with('info', 'Please log in to join your friend\'s Foodie Circle.');
        }

        $code = $request->input('code');

        try {
            $circle = Community::where('invite_code', $code)->first();

            if (!$circle) {
                return redirect()->route('front.community.index')->with('error', 'Community not found.');
            }

            if ($circle->creator_user_id === $user->id) {
                return redirect()->route('front.community.index')->with('info', 'This is your own circle!');
            }

            CommunityMember::firstOrCreate([
                'community_id' => $circle->id,
                'user_id'      => $user->id,
            ], [
                'role'         => 'member',
                'joined_at'    => now(),
            ]);

            session()->forget('pending_community_invite');

            return redirect()->route('front.community.index')
                ->with('success', "🎉 You successfully joined {$circle->name}! Welcome to the circle.");

        } catch (\Throwable $e) {
            return redirect()->route('front.community.index')
                ->with('error', 'Unable to join at this moment. Please try again.');
        }
    }

    /**
     * Post a new thought, review, or recommendation
     */
    public function storePost(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect('/login');
        }

        $request->validate([
            'content'        => 'required|string|max:1000',
            'community_id'   => 'nullable|integer',
            'restaurant_id'  => 'nullable|integer',
            'rating'         => 'nullable|integer|min:1|max:5',
            'tag'            => 'nullable|string|max:50',
            'image'          => 'nullable|image|max:4096',
        ]);

        try {
            $circle = null;
            if ($request->filled('community_id')) {
                $circle = Community::find($request->community_id);
            }
            if (!$circle) {
                $circle = Community::getOrCreateForUser($user);
            }

            $imagePath = null;
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/community'), $filename);
                $imagePath = 'uploads/community/' . $filename;
            }

            CommunityPost::create([
                'community_id'   => $circle->id,
                'user_id'        => $user->id,
                'restaurant_id'  => $request->restaurant_id ?: null,
                'product_id'     => null,
                'content'        => clean($request->content),
                'rating'         => $request->rating ?: null,
                'tag'            => $request->tag ?: 'Foodie Thought',
                'image'          => $imagePath,
                'likes_count'    => 0,
            ]);

            return redirect()->route('front.community.index')
                ->with('success', 'Your food thought was shared with your Foodie Circle!');

        } catch (\Throwable $e) {
            return redirect()->route('front.community.index')
                ->with('error', 'Could not share post right now: ' . $e->getMessage());
        }
    }

    /**
     * Toggle like on a community post
     */
    public function toggleLike(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Please log in'], 401);
        }

        try {
            $post = CommunityPost::findOrFail($id);
            $like = CommunityPostLike::where('post_id', $post->id)->where('user_id', $user->id)->first();

            if ($like) {
                $like->delete();
                $post->decrement('likes_count');
                $liked = false;
            } else {
                CommunityPostLike::create(['post_id' => $post->id, 'user_id' => $user->id]);
                $post->increment('likes_count');
                $liked = true;
            }

            return response()->json([
                'success' => true,
                'liked'   => $liked,
                'count'   => $post->fresh()->likes_count,
            ]);
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
