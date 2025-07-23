<?php
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class MessageSent implements ShouldBroadcast
{
    public $message;

    public function __construct($message)
    {
        $this->message = $message;
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('chat.' . $this->message->receiver_id),
        ];
    }

    public function broadcastWith(): array
    {
        return [
            'id' => $this->message->id,
            'message' => $this->message->message,
            'file_path' => $this->message->file_path ? asset('storage/' . $this->message->file_path) : null,
            'sender_id' => $this->message->sender_id,
            'receiver_id' => $this->message->receiver_id,
            'created_at' => $this->message->created_at->toDateTimeString(),
        ];
    }
}
