<div class="flex-1 grid grid-cols-12" wire:init="loadStartingActOneState">
    <div class="col-span-10 p-2 md:p-0 min-h-full">
        <div class="relative">
            <img src="{{ asset('storage/act_one_board.jpeg') }}" alt="Act I Board: Monitor" class="w-full max-h-screen">

            @include('includes.act_1.pieces', ['gameState' => $gameState])
        </div>
    </div>

    <div class="col-span-2 p-4 bg-gray-700 min-h-full">
        <h2 class="text-center mb-4">Act I</h2>

        <p class="text-center">
            Current Player's Turn: <strong>{{ ucwords($gameState['active_character'] ?? 'N/A') }}</strong>
        </p>

        @if ($gameState['current_description'] ?? false)
            <p class="text-center mt-2">
                {{ $gameState['current_description'] }}
            </p>
        @endif

        @isset ($gameState['swimmers_eaten'])
            <div class="w-full bg-gray-200 h-2 text-center mt-8">
                <div class="bg-custom-red h-2 mb-1" style="width: {{ ceil($gameState['swimmers_eaten'] / 9) }}%"></div>
                <p>
                    Swimmers Eaten: <strong>{{ $gameState['swimmers_eaten'] ?? 0 }}/9</strong>
                </p>
            </div>
        @endisset

        <br/>

        @isset ($gameState['shark_barrels'])
            <div class="w-full bg-gray-200 h-2 text-center mt-8">
                <div class="bg-red h-2 mb-1" style="width: 0%"></div>
                <p>
                    Barrels Attached: <strong>{{ $gameState['shark_barrels'] ?? 0 }}/2</strong>
                </p>
            </div>
        @endisset

        @isset ($gameState['current_event_description'])
            <div class="w-full text-center mt-8">
                <br/>
                <hr class="mb-6"/>
                <h3 class="text-center text-lg">
                    {{ $gameState['current_event_title'] }}
                </h3>
                <p class="text-center">
                    ({{ $gameState['current_event_swimmers'] }})
                </p>
                <p class="text-center mt-2">
                    "{{ $gameState['current_event_description'] }}"
                </p>
            </div>
        @endif
    </div>

    <x-audio :gameState="$gameState" />
</div>
