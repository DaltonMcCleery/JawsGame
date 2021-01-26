@if(isset($gameState['active_player']) && $gameState['active_player'] === 'N/A' && $game->Shark->User->username !== Auth::user()->username)
    {{-- Crew needs to decide who's next --}}
    <br/><br/>
    @if($gameState['brody_moves'] !== 0)
        <button class="button is-dark" wire:click="setActiveCharacter('brody')">Brody's Turn</button>
    @endif
    @if($gameState['hooper_moves'] !== 0)
        <button class="button is-info" wire:click="setActiveCharacter('hooper')">Hooper's Turn</button>
    @endif
    @if($gameState['quint_moves'] !== 0)
        <button class="button is-success" wire:click="setActiveCharacter('quint')">Quint's Turn</button>
    @endif
@endif
