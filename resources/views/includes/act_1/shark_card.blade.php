<article class="panel">
    <p class="panel-heading shark">
        The Shark @if($game->Shark->User->username === Auth::user()->username) <small>(You)</small>@endif
    </p>
    <p class="panel-tabs">
        <span class="is-active">
            Actions: {{ $gameState['shark_moves'] ?? 3 }}
            |
            Barrels: {{ $gameState['shark_barrels'] ?? 0 }}
        </span>
    </p>

    <a class="panel-block @if(isset($gameState['active_player']) && $gameState['active_player'] === Auth::user()->username && $game->Shark->User->username === Auth::user()->username && $gameState['current_selected_action'] === 'Move 1 Space') shark @endif"
       wire:click="switchNextAction('Move 1 Space')">
        Move 1 Space
    </a>
    <a class="panel-block @if(isset($gameState['active_player']) && $gameState['active_player'] === Auth::user()->username && $game->Shark->User->username === Auth::user()->username && $gameState['current_selected_action'] === 'Eat 1 Swimmer') shark @endif"
       wire:click="switchNextAction('Eat 1 Swimmer')">
        Eat 1 Swimmer
    </a>

    <hr/>

    <a class="panel-block is-flex-direction-column has-text-centered
       @if(isset($gameState['active_player']) && $gameState['active_player'] === Auth::user()->username && $game->Shark->User->username === Auth::user()->username && $gameState['current_selected_action'] === 'Use Feeding Frenzy') shark @endif"
       wire:click="switchNextAction('Use Feeding Frenzy')">
        <strong>Feeding Frenzy</strong>
        <small>Eat All Swimmers at one Beach</small>
    </a>
    <a class="panel-block is-flex-direction-column has-text-centered
       @if(isset($gameState['active_player']) && $gameState['active_player'] === Auth::user()->username && $game->Shark->User->username === Auth::user()->username && $gameState['current_selected_action'] === 'Use Evasive Moves') shark @endif"
       wire:click="switchNextAction('Use Evasive Moves')">
        <strong>Evasive Moves</strong>
        <small>Does not trigger any Motion Sensors</small>
    </a>
    <a class="panel-block is-flex-direction-column has-text-centered
       @if(isset($gameState['active_player']) && $gameState['active_player'] === Auth::user()->username && $game->Shark->User->username === Auth::user()->username && $gameState['current_selected_action'] === 'Use Out of Sight') shark @endif"
       wire:click="switchNextAction('Use Out of Sight')">
        <strong>Out of Sight</strong>
        <small>Undetectable from Binoculars and Fish Finder</small>
    </a>
    <a class="panel-block is-flex-direction-column has-text-centered
       @if(isset($gameState['active_player']) && $gameState['active_player'] === Auth::user()->username && $game->Shark->User->username === Auth::user()->username && $gameState['current_selected_action'] === 'Use Speed Burst') shark @endif"
       wire:click="switchNextAction('Use Speed Burst')">
        <strong>Speed Burst</strong>
        <small>Move up to 3 Spaces in 1 Action</small>
    </a>
</article>
