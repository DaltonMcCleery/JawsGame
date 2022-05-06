<div class="min-h-screen flex flex-col">
    @if(auth()->id() === $game->monitor)
        @livewire('game.monitor.game-act-one', [
            'game' => $game,
            'gameState' => $gameState,
        ])
    @else
        @livewire('game.player.game-act-one', [
           'game' => $game,
           'gameState' => $gameState,
       ])
    @endif

    <div class="grid grid-cols-4">
        @foreach($gameState as $key => $value)
            @if ($loop->index / 4 === 0)
            <div>
            @endif
            @if(! \is_array($value) && ! \in_array($key, ['current_description']))
                <p class="col-span-1">
                    <strong>{{ $key }}</strong> => {{ $value }}
                </p>
            @endif
            @if ($loop->index / 4 === 0)
            </div>
            @endif
        @endforeach
    </div>
</div>

{{--<div class="container mt-4">--}}
    {{-- CHARACTER CARDS --}}
{{--        <div class="column is-3-desktop is-12-mobile">--}}
{{--            @if($act === 1)--}}
{{--                @include('includes.act_1.brody_card', ['game' => $game, 'gameState' => $gameState])--}}
{{--            @else--}}
{{--                @include('includes.act_2.brody_card', ['game' => $game, 'gameState' => $gameState])--}}
{{--            @endif--}}
{{--        </div>--}}

{{--        <div class="column is-3-desktop is-12-mobile">--}}
{{--            @if($act === 1)--}}
{{--                @include('includes.act_1.hooper_card', ['game' => $game, 'gameState' => $gameState])--}}
{{--            @else--}}
{{--                @include('includes.act_2.hooper_card', ['game' => $game, 'gameState' => $gameState])--}}
{{--            @endif--}}
{{--        </div>--}}

{{--        <div class="column is-3-desktop is-12-mobile">--}}
{{--            @if($act === 1)--}}
{{--                @include('includes.act_1.quint_card', ['game' => $game, 'gameState' => $gameState])--}}
{{--            @else--}}
{{--                @include('includes.act_2.quint_card', ['game' => $game, 'gameState' => $gameState])--}}
{{--            @endif--}}
{{--        </div>--}}
{{--    </div>--}}
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
