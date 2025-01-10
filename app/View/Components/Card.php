<?php

namespace App\View\Components;

use App\Models\Friend;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class Card extends Component
{
    public $userId;
    public $imageUrl;
    public $name;
    public $age;
    public $status;
    public $hobbies;
    public $gender;

    public function __construct($user)
    {
        $this->userId = $user->id;
        $this->imageUrl = $user->profile_picture_url;
        $this->name = $user->name;
        $this->age = $user->age;
        $this->status = null;
        $this->hobbies = $user->hobbies;
        $this->gender = $user->gender;

        if(Auth::check()){
            $currentUser = Auth::user();

            $friendship = Friend::where(function ($query) use ($currentUser) {
                $query->where('user_id', $currentUser->id)
                      ->where('friend_id', $this->userId);
            })->orWhere(function ($query) use ($currentUser) {
                $query->where('user_id', $this->userId)
                      ->where('friend_id', $currentUser->id);
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
