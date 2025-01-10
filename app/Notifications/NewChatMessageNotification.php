<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\DatabaseMessage;
use App\Models\User;

class NewChatMessageNotification extends Notification
{
    use Queueable;

    protected $sender;
    protected $message;
    protected $chatRoom;

    public function __construct(User $sender, $message, $chatRoom)
    {
        $this->sender = $sender;
        $this->message = $message;
        $this->chatRoom = $chatRoom;
    }

    public function via($notifiable)
    {
        // You can send the notification through the database and other channels like mail, etc.
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'New Message',
            'sender_id' => $this->sender->id,
            'sender_name' => $this->sender->name,
            'message' => $this->message,
            'chat_room_id' => $this->chatRoom->id,
        ];
    }
}
