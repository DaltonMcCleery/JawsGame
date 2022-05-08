<article class="panel">
    <p class="text-center mb-2">
        Actions: {{ $gameState['hooper_moves'] ?? 4 }} @if(isset($gameState['extra_crew_move']) && $gameState['extra_crew_move'] === 1) + 1 @endif
        |
        Barrels: {{ $gameState['hooper_barrels'] ?? 0 }}
    </p>

    <hr/>

    <div class="grid grid-cols-1 gap-4 py-4">
        @if(isset($gameState['captain_down']) && isset($gameState['in_water']) && $gameState['captain_down'] === true && in_array('hooper', $gameState['in_water']))
            <a class="relative cursor-pointer rounded-lg border-2 bg-white px-6 py-5 shadow-sm flex flex-col items-center
                    {{ $gameState['current_selected_action'] === ($action ?? '') ? 'border-custom-red' : 'border-transparent' }}"
                    wire:click="getBackUpOnBoat">
                <p class="font-bold text-gray-900 text-center">
                    Get Back on the Boat
                </p>
            </a>
        @else
            <x-action action="Move 1-2 Spaces" :currentAction="$gameState['current_selected_action']">
                <p class="font-bold text-gray-900 text-center">
                    Move 1-2 Spaces
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

            <x-action action="Give all Barrels to Quint" :currentAction="$gameState['current_selected_action']">
                <p class="font-bold text-gray-900 text-center">
                    Give all Barrels to Quint
                </p>
            </x-action>

            <hr/>

            <x-action action="Use Fish Finder" :currentAction="$gameState['current_selected_action']">
                <p class="font-bold text-gray-900 text-center">
                    Fish Finder
                </p>
                <p class="text-sm text-gray-500 break-words text-center">
                    Detects if the Shark is in the same Space or in an adjacent Space from you
                </p>
            </x-action>
        @endif
    </div>
</article>
