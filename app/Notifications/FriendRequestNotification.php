<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class FriendRequestNotification extends Notification
{
    protected $sender;
    protected $receiver;

    // Constructor to pass the user who sent the request
    public function __construct($sender, $receiver)
    {
        $this->sender = $sender;
        $this->receiver = $receiver;
    }

    // Define the delivery channels
    public function via($notifiable)
    {
        return ['database']; // You can add other channels like 'mail', 'broadcast', etc.
    }

    // Build the database notification
    public function toDatabase($notifiable)
    {
        return [
            'title' => 'Friend Request',
            'sender_id' => $this->sender->id,
            'receiver_id' => $this->receiver->id,
            'message' => $this->sender->name . ' has sent you a friend request.',
        ];
    }
}
