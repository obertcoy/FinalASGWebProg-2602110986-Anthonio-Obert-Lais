<?php

namespace App\Http\Controllers;

use App\Models\Friend;
use App\Models\User;
use App\Notifications\FriendRequestNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\Types\Boolean;

class FriendController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(!Auth::check()){
            return redirect()->route('auth.sign-in');
        }

        $user = Auth::user();

        $friendRequests = $user->friendOf()->where('status', 'Requested')->get();

        $friendsSentAccepted = $user->friends()->where('status', 'Accepted')->get();
        $friendsReceivedAccepted = $user->friendOf()->where('status', 'Accepted')->get();
        $friends = $friendsSentAccepted->merge($friendsReceivedAccepted);

        $friends->each(function ($friend) use ($user) {
            if ($friend->user_id == $user->id) {
                $friend->is_friend = $friend->friend_id; // Friend is the other user
            } else {
                $friend->is_friend = $friend->user_id; // Friend is the current user
            }
        });

        $friends = $friends->sortByDesc('created_at');

        return view('pages/friend', compact('friendRequests', 'friends'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if(!Auth::check()){
            return redirect()->route('auth.sign-in');
        }

        $user = Auth::user();

        $receiver = User::findOrFail($request->id);

        Friend::create([
            'user_id' => $user->id,
            'friend_id' => $receiver->id,
        ]);

        $receiver->notify(new FriendRequestNotification($user, $receiver));

        return redirect()->back()->with('success', 'Friend request sent');
    }

    /**
     * Display the specified resource.
     */
    public function show(Friend $friend)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Friend $friend)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Friend $friend)
    {
        if(!Auth::check()){
            return redirect()->route('auth.sign-in');
        }

        $user = Auth::user();

        if ($friend->status === 'Requested') {

            if ($request->accept) {
                $friend->status = 'Accepted';
                $friend->user->friendOf()->where('user_id', $friend->friend_id)->update(['status' => 'Accepted']);
                $friend->save();
            } else {
                $friend->delete();
            }

            return redirect()->back()->with('success', $request->accept ? 'Friend request accepted.' : 'Friend request rejected.');
        }

        return redirect()->back()->with('error', 'This request is no longer valid.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Friend $friend)
    {
        //
    }
}
