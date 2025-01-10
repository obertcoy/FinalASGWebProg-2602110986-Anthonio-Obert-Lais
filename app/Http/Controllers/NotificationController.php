<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $notifications = $user->notifications()->paginate(10);

        // dd($notifications);

        $user->unreadNotifications->markAsRead();

        return view('pages/notification', compact('notifications'));
    }
}
