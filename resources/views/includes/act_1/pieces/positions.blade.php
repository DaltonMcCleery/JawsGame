@if(isset($gameState['shark_position']) && (($gameState['active_character'] === 'shark') || $gameState['show_shark']))
    <div id="shark-position" class="absolute {{ $gameState['shark_position'] }}"></div>
@endif

@if(isset($gameState['brody_position']))
    <div id="brody-position" class="{{ $gameState['brody_position'] }}"></div>
@endif

@if(isset($gameState['hooper_position']))
    <div id="hooper-position" class="{{ $gameState['hooper_position'] }}"></div>
@endif

@if(isset($gameState['quint_position']))
    <div id="quint-position" class="{{ $gameState['quint_position'] }}"></div>
@endif
