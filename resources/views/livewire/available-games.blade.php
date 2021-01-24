<section class="section" wire:init="loadGames">
    <div class="container">

        <h2 class="subtitle has-text-centered">{{ count($games) }} Games Found</h2>
        <div class="is-flex is-justify-content-center is-flex-direction-column">
            <button class="button is-dark @auth mb-2 @else mb-4 @endauth" wire:click="loadGames">Refresh</button>

            @auth
                @if(Auth::user()->role === 'ADMIN')
                    <div class="field is-grouped mb-4">
                        <p class="control is-expanded">
                            <input class="input" type="text" placeholder="Game Password (optional)" wire:model="game_id">
                        </p>
                        <p class="control">
                            <button class="button is-success" wire:click="createGame">Create</button>
                        </p>
                    </div>
                @endif
            @endauth
        </div>

        @if(count($games) > 0)
            @foreach($games as $game)
                <div class="box">
                    <article class="media">
                        <div class="media-content">
                            <div class="content">
                                <p>
                                    <strong>{{ $game->Host->name }}'s Game</strong>
                                    <br>
                                    <small>Created At {{ $game->created_at }}</small>
                                    <br/>
                                    <small>Current Users in Lobby {{ $game->current_sessions }}</small>
                                </p>
                                <p>
                                    Open Characters:
                                    @if(!$game->Brody) <span class="tag is-light">Brody</span> @endif
                                    @if(!$game->Hooper) <span class="tag is-light">Hooper</span> @endif
                                    @if(!$game->Quint) <span class="tag is-light">Quint</span> @endif
                                    @if(!$game->Shark->user_id) <span class="tag is-dark">Shark</span> @endif
                                </p>
                            </div>
                            <nav class="level is-mobile">
                                <div class="level-left">
                                    @auth
                                        @isset($game->game_id)
                                            <div class="field is-grouped">
                                                <p class="control is-expanded">
                                                    <input class="input @error('joining_game_id') is-danger @enderror" type="text" placeholder="Game Password" wire:model="joining_game_id">
                                                </p>
                                                <p class="control">
                                                    <button class="button is-success" wire:click="joinGame('{{ $game->id }}')">Join</button>
                                                </p>
                                            </div>
                                            @error('joining_game_id')
                                                <p class="help is-danger" style="position: absolute; bottom: 10px;">{{ $message }}</p>
                                            @enderror
                                        @else
                                            <button class="button is-success" wire:click="joinGame('{{ $game->id }}')">Join</button>
                                        @endisset
                                    @else
                                        <a href="/login" class="button is-danger" style="background-color: #e40403;">Login to Play</a>
                                    @endauth
                                </div>
                            </nav>
                        </div>
                    </article>
                </div>
            @endforeach
        @endif
    </div>
</section>
