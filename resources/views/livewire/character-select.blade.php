<section class="hero is-dark is-large">
    <div class="p-6 columns is-flex-wrap-wrap">

        {{-- SHARK --}}
        <div class="column is-full-mobile is-half-desktop" wire:click="userSelectedCharacter('shark')">
            <div class="card" @isset($shark) style="border: 3px solid #e40403" @endisset>
                <div class="card-image">
                    <figure class="image is-16by9">
                        <img src="{{ asset('characters/jaws.jpg') }}" alt="Jaws Shark">
                    </figure>
                    @isset($shark)
                        <article class="message character-selected shark">
                            <div class="message-body">
                                <p><strong>{{ $shark }}</strong></p>
                            </div>
                        </article>
                    @endif
                </div>
                <div class="card-content">
                    <div class="content">
                        The Shark
                    </div>
                </div>
            </div>
        </div>

        {{-- BRODY --}}
        <div class="column is-full-mobile is-half-desktop" wire:click="userSelectedCharacter('brody')">
            <div class="card" @isset($brody) style="border: 3px solid #020609" @endisset>
                <div class="card-image">
                    <figure class="image is-16by9">
                        <img src="{{ asset('characters/brody.jpg') }}" alt="Brody">
                    </figure>
                    @isset($brody)
                        <article class="message character-selected brody">
                            <div class="message-body">
                                <p><strong>{{ $brody }}</strong></p>
                            </div>
                        </article>
                    @endif
                </div>
                <div class="card-content">
                    <div class="content">
                        Brody
                    </div>
                </div>
            </div>
        </div>

        {{-- HOOPER --}}
        <div class="column is-full-mobile is-half-desktop" wire:click="userSelectedCharacter('hooper')">
            <div class="card" @isset($hooper) style="border: 3px solid #6b9cd1" @endisset>
                <div class="card-image">
                    <figure class="image is-16by9">
                        <img src="{{ asset('characters/hooper.jpg') }}" alt="Hooper">
                    </figure>
                    @isset($hooper)
                        <article class="message character-selected hooper">
                            <div class="message-body">
                                <p><strong>{{ $hooper }}</strong></p>
                            </div>
                        </article>
                    @endif
                </div>
                <div class="card-content">
                    <div class="content">
                        Hooper
                    </div>
                </div>
            </div>
        </div>

        {{-- QUINT --}}
        <div class="column is-full-mobile is-half-desktop" wire:click="userSelectedCharacter('quint')">
            <div class="card" @isset($quint) style="border: 3px solid #85b65b" @endisset>
                <div class="card-image">
                    <figure class="image is-16by9">
                        <img src="{{ asset('characters/quint.jpg') }}" alt="Quint">
                    </figure>
                    @isset($quint)
                        <article class="message character-selected quint">
                            <div class="message-body">
                                <p><strong>{{ $quint }}</strong></p>
                            </div>
                        </article>
                    @endif
                </div>
                <div class="card-content">
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

        @if($game->Host->id === Auth::user()->id && $shark !== null)
            <div class="column is-full">
                <button class="button is-success" style="width: 100%" wire:click="startGame">Start Game</button>
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
            .listen('Lobby.startGame', (data) => {
                // Redirect the User to the Game's page
                window.location.href = '/play/game/{{ $session_id }}';
            });
    </script>
@endpush
