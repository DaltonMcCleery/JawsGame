<div id="act-1" wire:init="loadStartingActOneState">

    <div class="notification">
        @include('includes.act_1.phases', ['gameState' => $gameState])

        @include('includes.act_1.crew_turn_picker', ['game' => $game, 'gameState' => $gameState])

        @include('includes.act_1.current_action_state', ['currentActionState' => $currentActionState, 'gameState' => $gameState])
    </div>

    @include('includes.act_1.shark_nearby', ['gameState' => $gameState])
</div>
