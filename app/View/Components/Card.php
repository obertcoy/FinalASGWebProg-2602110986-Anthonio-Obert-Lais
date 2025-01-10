<?php

namespace App\View\Components;

use App\Models\Friend;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class Card extends Component
{
    public $friendId;
    public $imageUrl;
    public $name;
    public $age;
    public $status;

    public function __construct($friendId, $imageUrl, $name, $age)
    {
        $this->friendId = $friendId;
        $this->imageUrl = $imageUrl;
        $this->name = $name;
        $this->age = $age;
        $this->status = null;

        if(Auth::check()){
            $user = Auth::user();

            $friendship = Friend::where(function ($query) use ($user, $friendId) {
                $query->where('user_id', $user->id)
                      ->where('friend_id', $friendId);
            })->orWhere(function ($query) use ($user, $friendId) {
                $query->where('user_id', $friendId)
                      ->where('friend_id', $user->id);
            })->first();
        
            if ($friendship) {
                $this->status = $friendship->status;
            } 
        }
    }

    public function render(): View|Closure|string
    {
        return view('components.card');
    }
}
