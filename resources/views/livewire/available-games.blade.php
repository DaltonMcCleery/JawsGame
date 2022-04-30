<section class="w-full max-w-4xl mx-auto bg-white py-12 md:py-20" @auth wire:init="loadGames" @endauth>

    @auth
        <div class="max-w-lg mx-auto">
            <div>
                <div class="text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 48 48" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M34 40h10v-4a6 6 0 00-10.712-3.714M34 40H14m20 0v-4a9.971 9.971 0 00-.712-3.714M14 40H4v-4a6 6 0 0110.713-3.714M14 40v-4c0-1.313.253-2.566.713-3.714m0 0A10.003 10.003 0 0124 26c4.21 0 7.813 2.602 9.288 6.286M30 14a6 6 0 11-12 0 6 6 0 0112 0zm12 6a4 4 0 11-8 0 4 4 0 018 0zm-28 0a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    @if(auth()->user()->role === 'ADMIN')
                        <h2 class="mt-2 text-lg font-medium text-gray-900">Create a New Game</h2>
                    @else
                        <h2 class="mt-2 text-lg font-medium text-gray-900">Join a Game</h2>
                    @endif
                </div>
                @if(auth()->user()->role === 'ADMIN')
                    <form action="#" class="mt-6 flex">
                        <input type="text" placeholder="Game Password (optional)" wire:model="game_id" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                        <button type="submit" class="ml-4 flex-shrink-0 px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" wire:click="createGame">
                            Create Game
                        </button>
                    </form>
                @endif
            </div>
            <div class="mt-10">
                <div class="flex justify-between">
                    <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wide">
                        {{ count($games) }} Games Found
                    </h3>
                    <button class="text-xs font-semibold text-gray-500 uppercase tracking-wide" wire:click="loadGames">Refresh</button>
                </div>
                <ul role="list" class="mt-4 border-t border-b border-gray-200 divide-y divide-gray-200">
                    @forelse($games as $game)
                        <li class="py-4 flex items-center justify-between space-x-3">
                            <div class="min-w-0 flex-1 flex items-center space-x-3">
                                <div class="min-w-0 flex-1">
                                    <p class="text-sm font-medium text-gray-900 truncate">{{ $game->host->name }}'s Game</p>
                                    <p class="text-sm font-medium text-gray-500 truncate">Created on {{ $game->created_at->format('F j, Y') }}</p>
                                </div>
                            </div>
                            <div class="flex-shrink-0">
                                <button type="button" class="inline-flex items-center py-2 px-3 border border-transparent rounded-full bg-gray-100 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                        wire:click="joinGame('{{ $game->id }}')">
                                    <svg class="-ml-1 mr-0.5 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="text-sm font-medium text-gray-900">Join</span>
                                </button>
                            </div>
                        </li>
                    @empty
                        <li class="py-4 flex items-center justify-between space-x-3">
                            <div class="min-w-0 flex-1 flex items-center space-x-3">
                                <div class="min-w-0 flex-1">
                                    <p class="text-sm font-medium text-gray-900 truncate">No Games Available</p>
                                    <p class="text-sm font-medium text-gray-500 truncate">Please refresh</p>
                                </div>
                            </div>
                        </li>
                    @endforelse
                </ul>
            </div>
        </div>
    @else
        <div class="relative block w-full border-2 border-gray-300 border-dashed rounded-lg p-12 text-center hover:border-red focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
            <span class="mt-2 block text-sm font-medium text-gray-900">
                Login to see available games
            </span>
        </div>
    @endauth
</section>
