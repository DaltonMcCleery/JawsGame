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
                        <h2 class="is-size-4">The Shark</h2>
                        <p class="mb-2">
                            <strong>Act I</strong><br/>
                            The Shark swims around the waters of Amity Island eating Swimmers at Beaches and avoiding detection
                            and barrels from the Crew.
                        </p>
                        <p>
                            The more Swimmers the Shark eats in Act I, the more abilities they gain in Act II and the less
                            abilities the Crew gets.
                        </p>
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
                        <h2 class="is-size-4">Brody</h2>
                        <p class="mb-2">
                            <strong>Act I</strong><br/>
                            Brody moves around Amity Island to rescue Swimmers, deliver Barrels to the Docks, help locate
                            the Shark, and Close Beaches.
                        </p>
                        <p class="mb-2">
                            Brody may use his <strong>Binoculars</strong> <small>(Once per round)</small> at any one of the
                            four Beach Spaces.<br/> If the Shark is at that Beach, they are shown to the rest of the Crew
                            for the remaining of the round.
                        </p>
                        <p>
                            Brody may <strong>Close a Beach</strong> if he is at either the Mayor's Office or Amity PD.
                            space and the Beach has NO Swimmers.
                        </p>
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
                        <h2 class="is-size-4">Hooper</h2>
                        <p class="mb-2">
                            <strong>Act I</strong><br/>
                            Hooper pilots his speed boat in the water around Amity Island to help locate the Shark, deliver
                            Barrels to Quint, and rescue Swimmers.
                        </p>
                        <p>
                            Hooper can use his <strong>Fish Finder</strong> <small>(Once per round)</small> to locate the
                            Shark nearby. If the Shark is in the same space as Hooper, the Shark is revealed to the rest
                            of the Crew for the rest of the round. If the Shark is in an adjacent space, the possible spaces
                            are shown to the rest of the Crew. If the Shark is neither in the same space or an adjacent space,
                            nothing is shown.
                        </p>
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
                        <h2 class="is-size-4">Quint</h2>
                        <p class="mb-2">
                            <strong>Act I</strong><br/>
                            Quint pilots the <em>Orca</em> in the water around Amity Island to rescue Swimmers and launch
                            Barrels into the water, hoping to hit the Shark.
                        </p>
                        <p>
                            Quint may <strong>Launch a Barrel</strong> <small>(Once per round)</small> into the water with
                            a Harpoon gun from his <em>Orca</em>. He may launch it into the same space he is in or an adjacent space.
                            If the Shark is in the space that the Barrel is launched, they are hit and the Barrel is now
                            attached to them for the remaining of Act I. If two Barrels are attached to the Shark, Act I is over.
                            <br/>
                            If the Shark is NOT in the space with the launched Barrel, that Barrel remains in the water
                            and becomes a <strong>Motion Sensor</strong> that will trigger if a Shark moves through that space.
                        </p>
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
