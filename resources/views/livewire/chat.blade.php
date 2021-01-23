<article class="panel is-dark">
    <p class="panel-heading">
        <span class="mb-2" style="display: block">Chat ({{ count($users) }} Users)</span>
        @foreach($users as $user)
            @if($host_id === $user['id'])
                <span class="tag is-info is-light">{{ $user['username'] }} (Host)</span>
            @else
                <span class="tag is-light">{{ $user['username'] }}</span>
            @endif
        @endforeach
    </p>

    <div id="lobbyChat" class="panel-block is-flex is-flex-direction-column is-align-items-flex-start" style="max-height: 500px; overflow-y: scroll">
        @foreach($lobbyMessages as $message)
            <p class="mb-3">
                <strong>{{ $message['username'] }}</strong><br/>
                {{ $message['message'] }}
            </p>
        @endforeach
    </div>

    <div class="panel-block is-flex is-justify-content-center is-flex-direction-column">
        <div class="field" style="width: 100%;">
            <div class="control is-expanded">
                <textarea class="textarea is-medium" placeholder="Type here..."
                          wire:model="message" wire:keydown.enter="chat"></textarea>
            </div>
        </div>
        <button class="button is-info" style="width: 100%;" wire:click="chat">Submit</button>
    </div>

</article>

@section('scripts')
    <script>
        const lobbyChatWindow = document.getElementById('lobbyChat');
        Livewire.on('scrollChatMessages', function() {
            var messages = lobbyChatWindow.querySelectorAll('p');
            (messages[messages.length - 1]).scrollIntoView()
        })

        Echo.join('lobby.{{ $session_id }}')
            .here((users) => {
                Livewire.emit('currentLobbyChatUsers', users);
            })
            .joining((user) => {
                Livewire.emit('userJoiningChatLobby', user);
            })
            .leaving((user) => {
                Livewire.emit('userLeavingChatLobby', user);
            })
            .listen('lobbyChat', (data) => {
                Livewire.emit('newLobbyMessage', data);
            })
            .listen('syncLobbyChat', (data) => {
                Livewire.emit('syncChatMessages', data.messages);
            })
            .listen('closeLobby', (data) => {
                // Host has chosen to close the Lobby/Game
                // this.leaveLobby(this.current_ninja);
            })
            .listen('startGame', (data) => {
                // Redirect the User to the Game's page
                window.location.href = '/play/game/{{ $session_id }}';
            });
    </script>
@endsection
