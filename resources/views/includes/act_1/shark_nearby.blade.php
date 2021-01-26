@if(isset($gameState['shark_nearby']) && count($gameState['shark_nearby']) > 0)
    <div class="notification is-warning">
        Shark is Nearby!<br/>
        Possible Locations:
        @foreach($gameState['shark_nearby'] as $location)
            @if($location !== 'Shop')
                "{{ str_replace('_', ' ', $location) }}"
            @endif
        @endforeach
    </div>
@endif

@if(isset($gameState['show_shark']) && $gameState['show_shark'] === true)
    <div class="notification is-warning">
        Shark is found!
    </div>
@endif
