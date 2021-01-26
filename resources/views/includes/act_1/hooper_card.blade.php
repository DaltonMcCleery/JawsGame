<article class="panel">
    <p class="panel-heading hooper">
        Hooper @if($game->Hooper->username === Auth::user()->username) <small>(You)</small>@endif
    </p>
    <p class="panel-tabs">
        <span class="is-active">
            Actions: {{ $gameState['hooper_moves'] ?? 4 }} @if(isset($gameState['extra_crew_move']) && $gameState['extra_crew_move'] === 1) + 1 @endif
            |
            Barrels: {{ $gameState['hooper_barrels'] ?? 0 }}
        </span>
    </p>

    <a class="panel-block @if(isset($gameState['active_player']) && $gameState['active_character'] === 'hooper' && $gameState['active_player'] === Auth::user()->username && $game->Hooper->username === Auth::user()->username && $gameState['current_selected_action'] === 'Move 1 Space') hooper @endif"
       wire:click="switchNextAction('Move 1-2 Spaces')">
        Move 1-2 Spaces
    </a>
    <a class="panel-block @if(isset($gameState['active_player']) && $gameState['active_character'] === 'hooper' && $gameState['active_player'] === Auth::user()->username && $game->Hooper->username === Auth::user()->username && $gameState['current_selected_action'] === 'Rescue 1 Swimmer') hooper @endif"
       wire:click="switchNextAction('Rescue 1 Swimmer')">
        Rescue 1 Swimmer
    </a>
    <a class="panel-block @if(isset($gameState['active_player']) && $gameState['active_character'] === 'hooper' && $gameState['active_player'] === Auth::user()->username && $game->Hooper->username === Auth::user()->username && $gameState['current_selected_action'] === 'Pick up any or all Barrels') hooper @endif"
       wire:click="switchNextAction('Pick up any or all Barrels')">
        Pick up any or all Barrels
    </a>
    <a class="panel-block @if(isset($gameState['active_player']) && $gameState['active_character'] === 'hooper' && $gameState['active_player'] === Auth::user()->username && $game->Hooper->username === Auth::user()->username && $gameState['current_selected_action'] === 'Give all Barrels to Quint') hooper @endif"
       wire:click="switchNextAction('Give all Barrels to Quint')">
        Give all Barrels to Quint
    </a>

    <hr/>

    <a class="panel-block @if(isset($gameState['active_player']) && $gameState['active_character'] === 'hooper' && $gameState['active_player'] === Auth::user()->username && $game->Hooper->username === Auth::user()->username && $gameState['current_selected_action'] === 'Use Fish Finder') hooper @endif"
       wire:click="switchNextAction('Use Fish Finder')">
        Fish Finder
    </a>
</article>
