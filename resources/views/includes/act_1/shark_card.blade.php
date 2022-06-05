<article class="panel">
    <p class="text-center mb-2">
        Actions: {{ $gameState['shark_moves'] ?? 3 }}
    </p>

    <hr/>

    <div class="grid grid-cols-1 gap-4 py-4 overflow-y-auto overflow-x-hidden scrolling-height">
        @if ($gameState['current_selected_action'] == 'Starting Position')
            <x-action action="Starting Position" :currentAction="$gameState['current_selected_action']">
                <p class="font-bold text-gray-900 text-center">
                    Select a Starting Position
                </p>
            </x-action>
        @else
            <x-action action="Move 1 Space" :currentAction="$gameState['current_selected_action']">
                <p class="font-bold text-gray-900 text-center">
                    Move 1 Space
                </p>
            </x-action>

            <x-action action="Eat 1 Swimmer" :currentAction="$gameState['current_selected_action']">
                <p class="font-bold text-gray-900 text-center">
                    Eat 1 Swimmer
                </p>
            </x-action>

            <hr/>

            <x-action :action="(! $gameState['used_feeding_frenzy'] ?? true) ? 'Ability Feeding Frenzy' : false" :currentAction="$gameState['current_selected_action']">
                <p class="font-bold text-gray-900 text-center">
                    Feeding Frenzy
                </p>
                <p class="text-sm text-gray-500 break-words text-center">
                    Eat All Swimmers at one Beach
                </p>
            </x-action>

            <x-action :action="(! $gameState['used_evasive_moves'] ?? true) ? 'Ability Evasive Moves' : false" :currentAction="$gameState['current_selected_action']">
                <p class="font-bold text-gray-900 text-center">
                    Evasive Moves
                </p>
                <p class="text-sm text-gray-500 break-words text-center">
                    Does not trigger any Motion Sensors this round
                </p>
            </x-action>

            <x-action :action="(! $gameState['used_out_of_sight'] ?? true) ? 'Ability Out of Sight' : false" :currentAction="$gameState['current_selected_action']">
                <p class="font-bold text-gray-900 text-center">
                    Out of Sight
                </p>
                <p class="text-sm text-gray-500 break-words text-center">
                    Undetectable from Binoculars and Fish Finder
                </p>
            </x-action>

            <x-action :action="(! $gameState['used_speed_burst'] ?? true) ? 'Ability Speed Burst' : false" :currentAction="$gameState['current_selected_action']">
                <p class="font-bold text-gray-900 text-center">
                    Speed Burst
                </p>
                <p class="text-sm text-gray-500 break-words text-center">
                    Move up to 3 Spaces in 1 Action
                </p>
            </x-action>
        @endif
    </div>
</article>
