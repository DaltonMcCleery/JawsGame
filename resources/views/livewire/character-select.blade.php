<section class="hero is-dark is-large">
    <div class="p-6 columns is-flex-wrap-wrap">

        {{-- SHARK --}}
        <div class="column is-full-mobile is-half-desktop" wire:click="userSelectedCharacter('shark')">
            <div class="card" @isset($shark) style="border: 3px solid #e40403" @endisset>
                <div class="card-image">
                    <figure class="image is-4by3">
                        <img src="https://bulma.io/images/placeholders/1280x960.png" alt="Placeholder image">
                    </figure>
                </div>
                <div class="card-content">
                    @isset($shark)
                        <div class="media">
                            <div class="media-content">
                                <p class="is-6"><strong>Selected By: {{ $shark }}</strong></p>
                            </div>
                        </div>
                    @endif

                    <div class="content">
                        The Shark
                    </div>
                </div>
            </div>
        </div>

        {{-- BRODY --}}
        <div class="column is-full-mobile is-half-desktop" wire:click="userSelectedCharacter('brody')">
            <div class="card" @isset($brody) style="border: 3px solid blue" @endisset>
                <div class="card-image">
                    <figure class="image is-4by3">
                        <img src="https://bulma.io/images/placeholders/1280x960.png" alt="Placeholder image">
                    </figure>
                </div>
                <div class="card-content">
                    @isset($brody)
                        <div class="media">
                            <div class="media-content">
                                <p class="is-6"><strong>Selected By: {{ $brody }}</strong></p>
                            </div>
                        </div>
                    @endif

                    <div class="content">
                        Brody
                    </div>
                </div>
            </div>
        </div>

        {{-- HOOPER --}}
        <div class="column is-full-mobile is-half-desktop" wire:click="userSelectedCharacter('hooper')">
            <div class="card" @isset($hooper) style="border: 3px solid yellow" @endisset>
                <div class="card-image">
                    <figure class="image is-4by3">
                        <img src="https://bulma.io/images/placeholders/1280x960.png" alt="Placeholder image">
                    </figure>
                </div>
                <div class="card-content">
                    @isset($hooper)
                        <div class="media">
                            <div class="media-content">
                                <p class="is-6"><strong>Selected By: {{ $hooper }}</strong></p>
                            </div>
                        </div>
                    @endif

                    <div class="content">
                        Hooper
                    </div>
                </div>
            </div>
        </div>

        {{-- QUINT --}}
        <div class="column is-full-mobile is-half-desktop" wire:click="userSelectedCharacter('quint')">
            <div class="card" @isset($quint) style="border: 3px solid green" @endisset>
                <div class="card-image">
                    <figure class="image is-4by3">
                        <img src="https://bulma.io/images/placeholders/1280x960.png" alt="Placeholder image">
                    </figure>
                </div>
                <div class="card-content">
                    @isset($quint)
                        <div class="media">
                            <div class="media-content">
                                <p class="is-6"><strong>Selected By: {{ $quint }}</strong></p>
                            </div>
                        </div>
                    @endif

                    <div class="content">
                        Quint
                    </div>
                </div>
            </div>
        </div>

        @error('character-error')
            <div class="column is-full mb-4">
                <article class="message is-danger">
                    <div class="message-body">{{ $message }}</div>
                </article>
            </div>
        @enderror

        @if($game->Host->id === Auth::user()->id)
            <div class="column is-full">
                <button class="button is-success" style="width: 100%">Start Game</button>
            </div>
        @endif
    </div>

</section>

@push('scripts')
    <script>
        Echo.join('lobby.{{ $session_id }}')
            .joining((user) => {
                console.log(user)
                Livewire.emit('userJoiningCharacterLobby', user);
            })
            .leaving((user) => {
                Livewire.emit('userLeavingCharacterLobby', user);
            })
            .listen('Characters.syncCharacterSelection', (data) => {
                Livewire.emit('syncSelectedCharacters', data.characters);
            })
            .listen('startGame', (data) => {
                // Redirect the User to the Game's page
                window.location.href = '/play/game/{{ $session_id }}';
            });
    </script>
@endpush
