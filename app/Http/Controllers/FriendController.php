<?php

namespace App\Http\Controllers;

use App\Models\Friend;
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

        $user->friends()->attach($request->id);

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
