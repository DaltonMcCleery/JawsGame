<article class="panel">
    <p class="text-center mb-2">
        Actions: {{ $gameState['quint_moves'] ?? 4 }} @if(isset($gameState['extra_crew_move']) && $gameState['extra_crew_move'] === 1) + 1 @endif
        |
        Barrels: {{ $localGameState['quint_barrels'] ?? $gameState['quint_barrels'] ?? 0 }}
    </p>

    <hr/>

    <div class="grid grid-cols-1 gap-4 py-4 overflow-y-auto scrolling-height">
        @if(isset($gameState['captain_down']) && isset($gameState['in_water']) && $gameState['captain_down'] === 1 && in_array('quint', $gameState['in_water']))
            <a class="relative cursor-pointer rounded-lg border-2 bg-white px-6 py-5 shadow-sm flex flex-col items-center
               {{ $gameState['current_selected_action'] === ($action ?? '') ? 'border-custom-red' : 'border-transparent' }}"
               wire:click="getBackUpOnBoat">
                <p class="font-bold text-gray-900 text-center">
                    Get Back on the Boat
                </p>
            </a>

            <hr/>
        @else
            <x-action action="Move 1 Space" :currentAction="$gameState['current_selected_action']">
                <p class="font-bold text-gray-900 text-center">
                    Move 1 Space
                </p>
            </x-action>

            <x-action action="Rescue 1 Swimmer" :currentAction="$gameState['current_selected_action']">
                <p class="font-bold text-gray-900 text-center">
                    Rescue 1 Swimmer
                </p>
            </x-action>

            <x-action action="Pick up any or all Barrels" :currentAction="$gameState['current_selected_action']">
                <p class="font-bold text-gray-900 text-center">
                    Pick up any or all Barrels
                </p>
            </x-action>

            <hr/>

            <x-action action="Launch a Barrel" :currentAction="$gameState['current_selected_action']">
                <p class="font-bold text-gray-900 text-center">
                    Launch a Barrel
                </p>
                <p class="text-sm text-gray-500 break-words text-center">
                    Launches a Barrel into an adjacent Space
                </p>
            </x-action>
        @endif
    </div>
</article>
