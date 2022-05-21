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

    <div class="grid grid-cols-4 {{ app()->environment() !== 'local' ? 'hidden' : '' }}">
        @foreach(collect($gameState)->mapWithKeys(fn ($value, $key) => [strtolower($key) => $value])->sortKeys() as $key => $value)
            @if ($loop->index / 4 === 0)
            <div>
            @endif
            @if(! \is_array($value) && ! \in_array($key, ['current_description']))
                <p class="col-span-1">
                    <strong>{{ $key }}</strong> => {{ $value }}
                </p>
            @elseif(\is_array($value))
                <p class="col-span-1">
                    <strong>{{ $key }}</strong> => {{ collect($value)->implode(', ') }}
                </p>
            @endif
            @if ($loop->index / 4 === 0)
            </div>
            @endif
        @endforeach
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
