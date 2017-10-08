<?php

namespace App\Events;

use App\User;
use App\Message;
use App\Chat;
use App\PersonalChat;
use App\GroupChat;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class MessageSent implements ShouldBroadcast {
    
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * User that sent the message
     *
     * @var User
     */
    public $user;

    /**
     * Message content
     *
     * @var Message
     */
    public $message;

    /**
     * Chat details
     *
     * @var Chat
     */
    public $chat;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($user, $message, $chat){
        $this->user = $user;
        $this->message = $message;
        $this->chat = $chat;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn() {
        return new PrivateChannel('chat.'.$this->chat);
    }
}
