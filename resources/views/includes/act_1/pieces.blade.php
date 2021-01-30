{{-- POSITIONS --}}
@include('includes.act_1.pieces.positions', ['gameState' => $gameState])

{{-- BARRELS --}}
@include('includes.act_1.pieces.barrels', ['gameState' => $gameState])

{{-- Swimmers --}}
@include('includes.act_1.pieces.swimmers', ['gameState' => $gameState])

@if(isset($gameState['closed_beach']) && isset($gameState['closed_beach_open_in']) && $gameState['closed_beach'] !== 'none')
    @if($gameState['closed_beach_open_in'] === 1)
        <span id="beach-closed" title="Opening Soon" class="{{ $gameState['closed_beach'] }}">
            <img src="{{ asset('images/opening_soon.jpg') }}">
        </span>
    @else
        <span id="beach-closed" title="Closed" class="{{ $gameState['closed_beach'] }}">
            <img src="{{ asset('images/beach_closed.jpg') }}">
        </span>
    @endif
@endif
