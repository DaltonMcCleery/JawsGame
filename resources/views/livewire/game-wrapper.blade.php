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
        <div class="column is-3-desktop is-12-mobile">
            @if($act === 1)
                @include('includes.act_1.shark_card', ['game' => $game, 'gameState' => $gameState])
            @else
                @include('includes.act_2.shark_card', ['game' => $game, 'gameState' => $gameState])
            @endif
        </div>

        <div class="column is-3-desktop is-12-mobile">
            @if($act === 1)
                @include('includes.act_1.brody_card', ['game' => $game, 'gameState' => $gameState])
            @else
                @include('includes.act_2.brody_card', ['game' => $game, 'gameState' => $gameState])
            @endif
        </div>

        <div class="column is-3-desktop is-12-mobile">
            @if($act === 1)
                @include('includes.act_1.hooper_card', ['game' => $game, 'gameState' => $gameState])
            @else
                @include('includes.act_2.hooper_card', ['game' => $game, 'gameState' => $gameState])
            @endif
        </div>

        <div class="column is-3-desktop is-12-mobile">
            @if($act === 1)
                @include('includes.act_1.quint_card', ['game' => $game, 'gameState' => $gameState])
            @else
                @include('includes.act_2.quint_card', ['game' => $game, 'gameState' => $gameState])
            @endif
        </div>
    </div>

    {{-- CHAT --}}
    <div class="columns mt-4">
        <div class="column is-3"></div>
        <div class="column is-6 is-6-desktop is-full-mobile">
            <livewire:chat :game="$game"/>
        </div>
        <div class="column is-3"></div>
    </div>

    {{-- DEBUG --}}
    <div class="columns">
        <div class="column is-full">
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
            .listen('Game.newGameCards', (data) => {
                Livewire.emit('resetGameCards', data);
            })
    </script>
@endpush
