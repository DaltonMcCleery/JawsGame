<?php

namespace App\Events\Game;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NewGameCards implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $session_id;
    public $card;
    public $cards;
    public $usedCards;

    /**
     * Create a new event instance.
     *
     * @param $session_id
     * @param $card
     * @param $cards
     * @param $usedCards
     */
    public function __construct($session_id, $card, $cards, $usedCards)
    {
        $this->session_id = $session_id;
        $this->card = $card;
        $this->cards = $cards;
        $this->usedCards = $usedCards;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PresenceChannel('game.'.$this->session_id);
    }
}
