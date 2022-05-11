@if(isset($gameState['shark_position']))
    @if((auth()->id() === $game->player && $gameState['active_character'] === 'shark') || $gameState['show_shark'])))
        <div id="shark-position" class="absolute w-[50px] {{ $gameState['shark_position'] }}">
            @if (($gameState['active_character'] === 'shark') || $gameState['show_shark'])
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-custom-red opacity-50"></span>
            @endif
            <img src="{{ asset('storage/shark.png') }}" alt="Shark" class="z-10"/>
        </div>
    @endif
@endif

@if(isset($gameState['brody_position']))
    <div id="brody-position" class="absolute w-[50px] {{ $gameState['brody_position'] }}">
        @if (($gameState['active_character'] === 'brody'))
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-brody opacity-50"></span>
        @endif
        <img src="{{ asset('storage/brody.png') }}" alt="Brody" class="z-10"/>
    </div>
@endif

@if(isset($gameState['hooper_position']))
    <div id="hooper-position" class="absolute w-[50px] {{ $gameState['hooper_position'] }}">
        @if (($gameState['active_character'] === 'hooper'))
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-hooper opacity-50"></span>
        @endif
        <img src="{{ asset('storage/hooper.png') }}" alt="Hooper" class="z-10"/>
    </div>
@endif

@if(isset($gameState['quint_position']))
    <div id="quint-position" class="absolute w-[50px] {{ $gameState['quint_position'] }}">
        @if (($gameState['active_character'] === 'quint'))
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-quint opacity-50"></span>
        @endif
        <img src="{{ asset('storage/quint.png') }}" alt="Quint" class="z-10"/>
    </div>
@endif
