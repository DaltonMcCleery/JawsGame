<article class="panel">
    <p class="text-center mb-2">
        Actions: {{ $gameState['shark_moves'] ?? 3 }}
    </p>

    <hr/>

    <div class="grid grid-cols-1 gap-4 py-4">
        @isset($gameState['current_selected_action'])
            <x-action action="Move 1 Space" :currentAction="$gameState['current_selected_action']">
                <p class="font-bold text-gray-900">
                    Move 1 Space
                </p>
            </x-action>

            <x-action action="Eat 1 Swimmer" :currentAction="$gameState['current_selected_action']">
                <p class="font-bold text-gray-900">
                    Eat 1 Swimmer
                </p>
            </x-action>

            <hr/>

            <x-action action="Ability Feeding Frenzy" :currentAction="$gameState['current_selected_action']">
                <p class="font-bold text-gray-900">
                    Feeding Frenzy
                </p>
                <p class="text-sm text-gray-500 break-words text-center">
                    Eat All Swimmers at one Beach
                </p>
            </x-action>

            <x-action action="Ability Evasive Moves" :currentAction="$gameState['current_selected_action']">
                <p class="font-bold text-gray-900">
                    Evasive Moves
                </p>
                <p class="text-sm text-gray-500 break-words text-center">
                    Does not trigger any Motion Sensors this round
                </p>
            </x-action>

            <x-action action="Ability Out of Sight" :currentAction="$gameState['current_selected_action']">
                <p class="font-bold text-gray-900">
                    Out of Sight
                </p>
                <p class="text-sm text-gray-500 break-words text-center">
                    Undetectable from Binoculars and Fish Finder
                </p>
            </x-action>

            <x-action action="Ability Speed Burst" :currentAction="$gameState['current_selected_action']">
                <p class="font-bold text-gray-900">
                    Speed Burst
                </p>
                <p class="text-sm text-gray-500 break-words text-center">
                    Move up to 3 Spaces in 1 Action
                </p>
            </x-action>
        @endisset
    </div>
</article>
