@if(isset($gameState['shark_position']) && (($game->Shark->User->username === Auth::user()->username) || $gameState['show_shark']))
    <span id="shark-position" class="{{ $gameState['shark_position'] }}"></span>
@endif

@if(isset($gameState['brody_position']))
    <span id="brody-position" class="{{ $gameState['brody_position'] }}"></span>
@endif

@if(isset($gameState['hooper_position']))
    <span id="hooper-position" class="{{ $gameState['hooper_position'] }}"></span>
@endif

@if(isset($gameState['quint_position']))
    <span id="quint-position" class="{{ $gameState['quint_position'] }}"></span>
@endif
