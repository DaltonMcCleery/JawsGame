<article class="panel">
    <p class="panel-heading brody">
        Brody @if($game->Brody->username === Auth::user()->username) <small>(You)</small>@endif
    </p>
    <p class="panel-tabs">
        <span class="is-active">Remaining Actions: {{ $gameState['brody_moves'] ?? 4 }} @if(isset($gameState['extra_crew_move']) && $gameState['extra_crew_move'] === 1) + 1 @endif</span>
    </p>

    <a class="panel-block @if(isset($gameState['active_player']) && $gameState['active_character'] === 'brody' && $gameState['active_player'] === Auth::user()->username && $game->Brody->username === Auth::user()->username && $gameState['current_selected_action'] === 'Move 1 Space') brody @endif"
       wire:click="switchNextAction('Move 1 Space')">
        Move 1 Space
    </a>
    <a class="panel-block @if(isset($gameState['active_player']) && $gameState['active_character'] === 'brody' && $gameState['active_player'] === Auth::user()->username && $game->Brody->username === Auth::user()->username && $gameState['current_selected_action'] === 'Rescue 1 Swimmer') brody @endif"
       wire:click="switchNextAction('Rescue 1 Swimmer')">
        Rescue 1 Swimmer
    </a>
    <a class="panel-block @if(isset($gameState['active_player']) && $gameState['active_character'] === 'brody' && $gameState['active_player'] === Auth::user()->username && $game->Brody->username === Auth::user()->username && $gameState['current_selected_action'] === 'Pick up 1 Barrel') brody @endif"
       wire:click="switchNextAction('Pick up 1 Barrel')">
        Pick up 1 Barrel
    </a>
    <a class="panel-block @if(isset($gameState['active_player']) && $gameState['active_character'] === 'brody' && $gameState['active_player'] === Auth::user()->username && $game->Brody->username === Auth::user()->username && $gameState['current_selected_action'] === 'Drop 1 Barrel') brody @endif"
       wire:click="switchNextAction('Drop 1 Barrel')">
        Drop 1 Barrel
    </a>

    <hr/>

    <a class="panel-block @if(isset($gameState['active_player']) && $gameState['active_character'] === 'brody' && $gameState['active_player'] === Auth::user()->username && $game->Brody->username === Auth::user()->username && $gameState['current_selected_action'] === 'Use Binoculars') brody @endif"
       wire:click="switchNextAction('Use Binoculars')">
        Binoculars
    </a>
    <a class="panel-block @if(isset($gameState['active_player']) && $gameState['active_character'] === 'brody' && $gameState['active_player'] === Auth::user()->username && $game->Brody->username === Auth::user()->username && $gameState['current_selected_action'] === 'Close a Beach') brody @endif"
       wire:click="switchNextAction('Close a Beach')">
        Close a Beach
    </a>
</article>
