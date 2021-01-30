@if(isset($gameState['shark_nearby']) && count($gameState['shark_nearby']) > 0 && !isset($gameState['act_1_over']) && (isset($gameState['show_shark']) && $gameState['show_shark'] !== true))
    <div class="notification is-warning">
        Shark is Nearby!<br/>
        Possible Locations:
        @foreach($gameState['shark_nearby'] as $location)
            @if($location !== 'Shop')
                "{{ str_replace('_', ' ', $location) }}"@if(!$loop->last), @endif
            @endif
        @endforeach
    </div>
@endif

@if(isset($gameState['show_shark']) && $gameState['show_shark'] === true && !isset($gameState['act_1_over']))
    <div class="notification is-warning">
        Shark is found!
    </div>
@endif

@if(isset($gameState['act_1_over']) && $gameState['act_1_over'] === true)
    <div class="notification is-success">
        <h3 class="title is-3">Act I is over.</h3>
        <button class="button is-info" wire:click="watchReplay">Watch Action Replay</button>
    </div>
@endif
