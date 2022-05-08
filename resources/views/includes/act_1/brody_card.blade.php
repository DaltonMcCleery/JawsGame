<article class="panel">
    <p class="text-center mb-2">
        Actions: {{ $gameState['brody_moves'] ?? 4 }} @if(isset($gameState['extra_crew_move']) && $gameState['extra_crew_move'] === 1) + 1 @endif
        |
        Barrels: {{ $gameState['brody_barrels'] ?? 0 }}
    </p>

    <hr/>

    <div class="grid grid-cols-1 gap-4 py-4">
        @if(isset($gameState['brody_relocation']) && $gameState['brody_relocation'] === 1)
            <x-action action="Move Relocation" :currentAction="$gameState['current_selected_action']">
                <p class="font-bold text-gray-900">
                    Relocation
                </p>
            </x-action>
        @endif

        <x-action action="Move 1 Space" :currentAction="$gameState['current_selected_action']">
            <p class="font-bold text-gray-900">
                Move 1 Space
            </p>
        </x-action>

        <x-action action="Rescue 1 Swimmer" :currentAction="$gameState['current_selected_action']">
            <p class="font-bold text-gray-900">
                Rescue 1 Swimmer
            </p>
        </x-action>

        <x-action action="Pick up 1 Barrel" :currentAction="$gameState['current_selected_action']">
            <p class="font-bold text-gray-900">
                Pick up 1 Barrel
            </p>
        </x-action>

        <x-action action="Drop 1 Barrel" :currentAction="$gameState['current_selected_action']">
            <p class="font-bold text-gray-900">
                Drop 1 Barrel
            </p>
        </x-action>

        <hr/>

        <x-action action="Use Binoculars" :currentAction="$gameState['current_selected_action']">
            <p class="font-bold text-gray-900">
                Binoculars
            </p>
            <p class="text-sm text-gray-500 break-words text-center">
                See if the Shark is at a Beach
            </p>
        </x-action>

        <x-action action="Close a Beach" :currentAction="$gameState['current_selected_action']">
            <p class="font-bold text-gray-900">
                Close a Beach
            </p>
            <p class="text-sm text-gray-500 break-words text-center">
                Will prevent Swimmers from being placed there for 2 Rounds
            </p>
        </x-action>
    </div>
</article>
