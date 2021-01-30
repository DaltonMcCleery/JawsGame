@if(count($currentActionState) > 0)
    <nav class="breadcrumb has-arrow-separator" aria-label="breadcrumbs">
        <ul>
            @foreach($currentActionState as $action)
                <li><a disabled>{{ $action }}</a></li>
            @endforeach
        </ul>
        <span>{{ $localGameState[$gameState['active_character'].'_moves'] - count($currentActionState) }} Actions Remaining</span>
    </nav>

    <button class="button is-warning" wire:click="undoPreviousAction">Undo Previous Action</button>
    <button class="button is-success" wire:click="confirmTurn">Confirm Turn</button>
    @if(isset($gameState['extra_crew_move']) && $gameState['extra_crew_move'] === 1 && Auth::user()->username !== $game->Shark->User->username)
        <button class="button is-info" wire:click="takeExtraMove">Take Extra Move</button>
    @endif
@endif
