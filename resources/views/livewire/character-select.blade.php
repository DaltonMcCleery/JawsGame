<section class="flex flex-col flex-1 items-center justify-center max-w-2xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:max-w-7xl lg:px-8">

    <h2 class="text-center text-4xl mb-4">Select a Character</h2>

    <div class="grid grid-cols-1 gap-y-10 sm:grid-cols-2 gap-x-6 xl:gap-x-8">
        <a class="group cursor-pointer p-2 @if($game->monitor) rounded-md border border-gray-200 @endif"
           wire:click="userSelectedCharacter('monitor')">
            <div class="relative w-full aspect-w-1 aspect-h-1 rounded-lg overflow-hidden sm:aspect-w-2 sm:aspect-h-3">
                <img src="{{ asset('characters/jaws.jpg') }}" alt="Main Monitor"
                     class="w-full h-full object-center object-cover group-hover:grayscale-0 @if($game->monitor) grayscale-0 @else grayscale @endif">
                @if($game->monitor)
                    <p class="absolute -rotate-6 top-0 left-0 w-full h-full flex justify-center items-center font-bold text-white text-2xl font-demi-italic">
                        SELECTED
                    </p>
                @endif
            </div>
        </a>

        <a class="group cursor-pointer p-2 @if($game->player) rounded-md border border-gray-200 @endif"
           wire:click="userSelectedCharacter('player')">
            <div class="relative w-full aspect-w-1 aspect-h-1 rounded-lg overflow-hidden sm:aspect-w-2 sm:aspect-h-3">
                <img src="{{ asset('images/player_characters.jpeg') }}" alt="Tablet Player"
                     class="w-full h-full object-center object-cover group-hover:grayscale-0 @isset($game->player) grayscale-0 @else grayscale @endif">
                @isset($game->player)
                    <p class="absolute -rotate-6 top-0 left-0 w-full h-full flex justify-center items-center font-bold text-white text-2xl font-demi-italic">
                        SELECTED
                    </p>
                @endisset
            </div>
        </a>
    </div>

</section>

@push('scripts')
    <script>
        Echo.join('lobby.{{ $session_id }}')
            .joining((user) => {
                Livewire.emit('userJoiningCharacterLobby', user);
            })
            .leaving((user) => {
                Livewire.emit('userLeavingCharacterLobby', user);
            })
            .listen('Characters.syncCharacterSelection', (data) => {
                Livewire.emit('syncSelectedCharacters', data.game);
            })
            .listen('Lobby.startGame', (data) => {
                // Redirect the User to the Game's page
                window.location.href = '/play/game/{{ $session_id }}';
            });
    </script>
@endpush
