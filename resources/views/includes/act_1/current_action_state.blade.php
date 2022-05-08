@if(count($currentActionState) > 0)
    <nav aria-label="Action State">
        <ol role="list" class="border border-gray-300 md:flex bg-gray-100">
            @foreach($currentActionState as $action)
                <li class="relative md:flex-1 md:flex">
                    <a wire:click="undoPreviousAction" class="group flex items-center w-full cursor-pointer">
                        <div class="px-4 py-1 flex items-center text-sm font-medium">
                            <span class="flex-shrink-0 w-10 h-10 flex items-center justify-center bg-indigo-600 rounded-full group-hover:bg-indigo-800">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                            </span>
                            <div class="flex flex-col ml-4">
                                <span class="text-sm font-medium text-indigo-600">{{ $action }}</span>
                                <span class="text-xs">Click to Undo Action</span>
                            </div>
                        </div>
                    </a>

                    <!-- Arrow separator for lg screens and up -->
                    <div class="hidden md:block absolute top-0 right-0 h-full w-5" aria-hidden="true">
                        <svg class="h-full w-full text-gray-900" viewBox="0 0 22 80" fill="none" preserveAspectRatio="none">
                            <path d="M0 -2L20 40L0 82" vector-effect="non-scaling-stroke" stroke="currentcolor" stroke-linejoin="round" />
                        </svg>
                    </div>
                </li>
            @endforeach
            @if ($localGameState[$gameState['active_character'].'_moves'] - count($currentActionState) > 0)
                @for($i = 0; $i < ($localGameState[$gameState['active_character'].'_moves'] - count($currentActionState)); $i++)
                    <li class="relative md:flex-1 md:flex">
                        <div class="px-4 py-1 flex items-center text-sm font-medium" aria-current="step">
                            <span class="flex-shrink-0 w-10 h-10 flex items-center justify-center border-2 border-indigo-600 rounded-full">
                                <span class="text-indigo-600">{{ $i + 2 }}</span>
                            </span>
                            <span class="ml-4 text-sm font-medium text-gray-600">Action {{ $i + 2 }}</span>
                        </div>

                        <!-- Arrow separator for lg screens and up -->
                        <div class="hidden md:block absolute top-0 right-0 h-full w-5" aria-hidden="true">
                            <svg class="h-full w-full text-gray-900" viewBox="0 0 22 80" fill="none" preserveAspectRatio="none">
                                <path d="M0 -2L20 40L0 82" vector-effect="non-scaling-stroke" stroke="currentcolor" stroke-linejoin="round" />
                            </svg>
                        </div>
                    </li>
                @endfor
            @endif
            <li class="relative md:flex-1 md:flex">
                <a wire:click="confirmTurn" class="px-6 py-2 flex items-center text-sm font-medium cursor-pointer" aria-current="step">
                    <span class="px-4 py-1 flex items-center text-sm font-medium">
                        <span class="flex-shrink-0 w-10 h-10 flex items-center justify-center bg-indigo-600 rounded-full group-hover:bg-indigo-800">
                            <svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </span>
                        <span class="ml-4 text-sm font-medium text-indigo-600">End Turn</span>
                    </span>
                </a>
            </li>
        </ol>
    </nav>
{{--    @if(isset($gameState['extra_crew_move']) && $gameState['extra_crew_move'] === 1 && Auth::user()->username !== $game->Shark->User->username)--}}
{{--        <button class="button is-info" wire:click="takeExtraMove">Take Extra Move</button>--}}
{{--    @endif--}}
@endif
