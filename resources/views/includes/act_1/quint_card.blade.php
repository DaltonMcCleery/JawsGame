<article class="panel">
    <p class="panel-heading quint">
        Quint @if($game->Quint->username === Auth::user()->username) <small>(You)</small>@endif
    </p>
    <p class="panel-tabs">
        <span class="is-active">Remaining Actions: {{ $gameState['quint_moves'] ?? 4 }} @if(isset($gameState['extra_crew_move']) && $gameState['extra_crew_move'] === 1) + 1 @endif</span>
    </p>

    <a class="panel-block @if(isset($gameState['active_player']) && $gameState['active_character'] === 'quint' && $gameState['active_player'] === Auth::user()->username && $game->Quint->username === Auth::user()->username && $gameState['current_selected_action'] === 'Move 1 Space') quint @endif"
       wire:click="switchNextAction('Move 1 Space')">
        Move 1 Space
    </a>
    <a class="panel-block @if(isset($gameState['active_player']) && $gameState['active_character'] === 'quint' && $gameState['active_player'] === Auth::user()->username && $game->Quint->username === Auth::user()->username && $gameState['current_selected_action'] === 'Rescue 1 Swimmer') quint @endif"
       wire:click="switchNextAction('Rescue 1 Swimmer')">
        Rescue 1 Swimmer
    </a>
    <a class="panel-block @if(isset($gameState['active_player']) && $gameState['active_character'] === 'quint' && $gameState['active_player'] === Auth::user()->username && $game->Quint->username === Auth::user()->username && $gameState['current_selected_action'] === 'Pick up any or all Barrels') quint @endif"
       wire:click="switchNextAction('Pick up any or all Barrels')">
        Pick up any or all Barrels
    </a>

    <hr/>

    <a class="panel-block">
        Launch a Barrel
    </a>
</article>
