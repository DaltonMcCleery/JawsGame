<div class="container mt-4">
    {{-- GAME BOARD --}}
    <div class="columns">
        <div class="column is-12">
            @if($act === 1)
                <livewire:game-act-one :game="$game" :gameState="$gameState"/>
            @else
                <livewire:game-act-two :game="$game" :gameState="$gameState"/>
            @endif
        </div>
    </div>

    {{-- CHARACTER CARDS --}}
    <div class="columns">
        <div class="column is-3">
            <h1>Brody @if($game->Brody->username === Auth::user()->username) <small>(You)</small>@endif</h1>
        </div>
        <div class="column is-3">
            <h1>Hooper @if($game->Hooper->username === Auth::user()->username) <small>(You)</small>@endif</h1>
        </div>
        <div class="column is-3">
            <h1>Quint @if($game->Quint->username === Auth::user()->username) <small>(You)</small>@endif</h1>
        </div>
        <div class="column is-3">
            <livewire:chat :game="$game"/>
        </div>
    </div>

    {{-- DEBUG --}}
    <div class="columns">
        <div class="column is-12">
            <div class="notification is-dark">
                @foreach($gameState as $key => $value)
                    <p>
                        <strong>{{ $key }}</strong> => {{ $value }}
                    </p>
                @endforeach
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        Echo.join('game.{{ $game->session_id }}')
            .listen('Game.newGameState', (data) => {
                Livewire.emit('resetGameState', data.gameState);
            })
    </script>
@endpush
