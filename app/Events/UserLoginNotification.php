<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class UserLoginNotification implements ShouldBroadcast
{
    use SerializesModels;


    public $message;
    public $user;


    public function __construct(User $user)
    {
        $this->user = $user;

        $this->message = 
        $user->name." logged in successfully";
    }


    public function broadcastOn()
    {
        return new Channel('login-channel');
    }


    public function broadcastAs()
    {
        return 'user.login';
    }
}