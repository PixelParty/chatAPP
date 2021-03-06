<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class Message implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    /**
     * Messsage model 
     * 
     * @var App/Message
     */
    public $message;
    
    /**
     * User model
     * 
     * @var App/User
     */
    public $user;

    /**
     * Create a new event instance.
     *
     * @param $messageText
     * @param $userMail
     */
    public function __construct($message,$user)
    {
        $this->message = $message;
        $this->user = $user;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('message-channel');
    }
}
