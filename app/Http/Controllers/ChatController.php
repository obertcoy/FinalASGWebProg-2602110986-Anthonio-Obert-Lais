<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\ChatRoom;
use App\Models\Friend;
use App\Models\User;
use App\Notifications\NewChatMessageNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
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
    public function store(Request $request, ChatRoom $chatRoom, User $friend)
    {

        // dd([
        //     'chatRoom' => $chatRoom,
        //     'friend' => $friend,
        //     'request' => $request->all()
        // ]);
        $user = Auth::user();

        Chat::create([
            'chat_room_id' => $chatRoom->id,
            'sender_id' => $user->id,
            'message' => $request->message,
        ]);


        $friend->notify(new NewChatMessageNotification($user, $request->message, $chatRoom));


        return redirect()->route('chat-room.show', $chatRoom);
    }

    /**
     * Display the specified resource.
     */
    public function show(Chat $chat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Chat $chat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Chat $chat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chat $chat)
    {
        //
    }
}
