<div class="flex-1 grid grid-cols-12" wire:init="loadStartingActOneState">
    @if (isset($gameState['active_character']) && $gameState['active_character'] !== null)
        <div class="col-span-10 p-2 md:p-0 min-h-full">

            @include('includes.act_1.current_action_state', ['currentActionState' => $currentActionState, 'gameState' => $gameState])

            <div class="relative">
                @error('action-error')
                    <div class="bg-red-100 p-4 absolute w-full top-0">
                        <div class="flex items-center justify-center">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <p class="ml-3 text-red-700 font-bold">
                                {{ $message }}
                            </p>
                        </div>
                    </div>
                @enderror

                <img src="{{ asset('storage/act_one_board.jpeg') }}" alt="Act I Board" class="w-full" usemap="#act_1_map">

                @include('includes.act_1.pieces', ['gameState' => $gameState])

                <x-image-map :gameState="$gameState"/>
            </div>
        </div>

        <div class="col-span-2 p-4 bg-gray-700 min-h-full">
            <h2 class="text-center mb-4">
                {{ ucwords($gameState['active_character'] ?? 'N/A') }}
            </h2>

            @isset($gameState['active_character'])
                @if ($gameState['active_character'] === 'shark')
                    @include('includes.act_1.shark_card', ['game' => $game, 'gameState' => $gameState])
                @elseif ($gameState['active_character'] === 'brody')
                    @include('includes.act_1.brody_card', ['game' => $game, 'gameState' => $gameState])
                @elseif ($gameState['active_character'] === 'hooper')
                    @include('includes.act_1.hooper_card', ['game' => $game, 'gameState' => $gameState])
                @elseif ($gameState['active_character'] === 'quint')
                    @include('includes.act_1.quint_card', ['game' => $game, 'gameState' => $gameState])
                @endif
            @endisset
        </div>
    @elseif (isset($gameState['shark_moves']))
        <x-turn-selector :gameState="$gameState"/>
    @endif
</div>
