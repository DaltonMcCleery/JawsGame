<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Events\lobbyChat;
use App\Events\syncLobbyChat;
use Illuminate\Support\Facades\Auth;

class Chat extends Component
{
    public $users = [];

    public $host_id;
    public $session_id;

    public $message = null;
    public $lobbyMessages = [];

    protected $listeners = [
        'currentLobbyChatUsers',
        'userJoiningChatLobby',
        'userLeavingChatLobby',
        'newLobbyMessage',
        'syncChatMessages'
    ];

    public function mount($game) {
        $this->session_id = $game->session_id;
        $this->host_id = $game->Host->id;
    }

    public function leaveLobby() {
        $this->redirect('/');
    }

    // -------------------------------------------------------------------------------------------------------------- //

    public function currentLobbyChatUsers($users) {
        $this->users = $users;
    }

    public function userJoiningChatLobby($user) {
        // Add user
        $this->users[] = $user;
        broadcast(new syncLobbyChat($this->session_id, $this->lobbyMessages));
    }

    public function userLeavingChatLobby($user) {
        // Remove user
        foreach ($this->users as $key => $lobbyUser) {
            if ($lobbyUser['username'] === $user['username']) {
                unset($this->users[$key]);
            }
        }
    }

    // -------------------------------------------------------------------------------------------------------------- //

    public function chat() {
        if ($this->message !== null && $this->message !== '') {
            // Send message via broadcast
            broadcast(new lobbyChat($this->session_id, Auth::user()->username, $this->message));
        }

        $this->reset('message');
    }

    public function newLobbyMessage($message) {
        $this->lobbyMessages[] = $message;
        $this->emit('scrollChatMessages');
    }

    public function syncChatMessages($messages) {
        $this->lobbyMessages = $messages;
        $this->emit('scrollChatMessages');
    }

    // -------------------------------------------------------------------------------------------------------------- //

    public function render()
    {
        return view('livewire.chat');
    }
}
