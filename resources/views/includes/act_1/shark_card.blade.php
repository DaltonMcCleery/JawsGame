<article class="panel">
    <p class="panel-heading shark">
        The Shark @if($game->Shark->User->username === Auth::user()->username) <small>(You)</small>@endif
    </p>
    <p class="panel-tabs">
        <span class="is-active">Remaining Actions: {{ $gameState['shark_moves'] ?? 3 }}</span>
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

    <a class="panel-block @if(isset($gameState['active_player']) && $gameState['active_player'] === Auth::user()->username && $game->Shark->User->username === Auth::user()->username && $gameState['current_selected_action'] === 'Feeding Frenzy') shark @endif"
       wire:click="switchNextAction('Feeding Frenzy')">
        Feeding Frenzy
    </a>
    <a class="panel-block @if(isset($gameState['active_player']) && $gameState['active_player'] === Auth::user()->username && $game->Shark->User->username === Auth::user()->username && $gameState['current_selected_action'] === 'Evasive Moves') shark @endif"
       wire:click="switchNextAction('Evasive Moves')">
        Evasive Moves
    </a>
    <a class="panel-block @if(isset($gameState['active_player']) && $gameState['active_player'] === Auth::user()->username && $game->Shark->User->username === Auth::user()->username && $gameState['current_selected_action'] === 'Out of Sight') shark @endif"
       wire:click="switchNextAction('Out of Sight')">
        Out of Sight
    </a>
    <a class="panel-block @if(isset($gameState['active_player']) && $gameState['active_player'] === Auth::user()->username && $game->Shark->User->username === Auth::user()->username && $gameState['current_selected_action'] === 'Speed Burst') shark @endif"
       wire:click="switchNextAction('Speed Burst')">
        Speed Burst
    </a>
</article>
