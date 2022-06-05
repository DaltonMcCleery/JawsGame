<?php

namespace App\Http\Livewire\Game;

use App\Events\Chat\LobbyChat;
use App\Events\Chat\SyncLobbyChat;
use App\Models\Game;
use Illuminate\Support\Str;
use Livewire\Component;

class Chat extends Component
{
    public string $session_id;
    public ?string $username = null;
    public bool $isUsernameSet = false;

    public ?string $message = null;
    public array $lobbyMessages = [];

    protected $listeners = [
        'userJoiningChatLobby',
        'newLobbyMessage',
        'syncChatMessages'
    ];

    public function mount() {
        $this->session_id = Game::where('session_id', Str::after(request()->path(), 'chat/'))->firstOrFail()->session_id;
        $this->username = session('chatUsername');
        $this->isUsernameSet = isset($this->username);
    }

    public function userJoiningChatLobby($user) {
        broadcast(new SyncLobbyChat($this->session_id, $this->lobbyMessages))->toOthers();
    }

    public function setUsername(): void
    {
        session()->put('chatUsername', $this->username);
        $this->isUsernameSet = true;
    }

    // -------------------------------------------------------------------------------------------------------------- //

    public function chat() {
        if ($this->message !== null && $this->message !== '') {
            // Send message via broadcast
            broadcast(new LobbyChat($this->session_id, $this->username, $this->message));
        }

        $this->reset(['message']);
    }

    public function newLobbyMessage($message) {
        $this->lobbyMessages[] = $message;
        $this->emit('scrollChatMessages');
    }

    public function syncChatMessages($messages) {
        $this->lobbyMessages = $messages;
        $this->emit('scrollChatMessages');
    }
}
