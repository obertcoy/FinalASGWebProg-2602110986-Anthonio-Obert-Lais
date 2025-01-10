<?php

namespace App\Http\Controllers;

use App\Models\ChatRoom;
use App\Models\Friend;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatRoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function friend($is_friend)
    {
        $user = Auth::user();

        $chatRoom = ChatRoom::whereHas('users', function ($query) use ($user, $is_friend) {
            $query->where('user_id', $user->id);
        })->whereHas('users', function ($query) use ($user, $is_friend) {
            $query->where('user_id', $is_friend); // Use friend_id instead of id
        })->first();

        if (!$chatRoom) {
            $chatRoom = ChatRoom::create();

            $chatRoom->users()->attach([$user->id, $is_friend]);
        }

        $messages = $chatRoom->chats()->latest()->get();
        $friend = User::find($is_friend);

        return view('pages/chat-room', compact('chatRoom', 'messages', 'friend'));
    }

    public function show(ChatRoom $chatRoom)
    {
        $messages = $chatRoom->chats()->latest()->get();

        $friend = $chatRoom->users()->firstWhere('user_id', '!=', Auth::user()->id);

        return view('pages/chat-room', compact('chatRoom', 'messages', 'friend'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ChatRoom $chatRoom)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ChatRoom $chatRoom)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ChatRoom $chatRoom)
    {
        //
    }
}
