@if(isset($gameState['North_Beach_Swimmers']) && $gameState['North_Beach_Swimmers'] > 0)
    <span id="north-swimmers" title="{{ $gameState['North_Beach_Swimmers'] ?? 0 }}" class="swimmers-count">
        <img src="{{ asset('images/swimmer_1.jpg') }}" alt="North Beach Swimmers"/>
    </span>
@endif

@if(isset($gameState['East_Beach_Swimmers']) && $gameState['East_Beach_Swimmers'] > 0)
    <span id="east-swimmers" title="{{ $gameState['East_Beach_Swimmers'] ?? 0 }}" class="swimmers-count">
        <img src="{{ asset('images/swimmer_2.jpg') }}" alt="East Beach Swimmers"/>
    </span>
@endif

@if(isset($gameState['South_Beach_Swimmers']) && $gameState['South_Beach_Swimmers'] > 0)
    <span id="south-swimmers" title="{{ $gameState['South_Beach_Swimmers'] ?? 0 }}" class="swimmers-count">
        <img src="{{ asset('images/swimmer_3.jpg') }}" alt="South Beach Swimmers"/>
    </span>
@endif

@if(isset($gameState['West_Beach_Swimmers']) && $gameState['West_Beach_Swimmers'] > 0)
    <span id="west-swimmers" title="{{ $gameState['West_Beach_Swimmers'] ?? 0 }}" class="swimmers-count">
        <img src="{{ asset('images/swimmer_4.jpg') }}" alt="West Beach Swimmers"/>
    </span>
@endif

@if(isset($gameState['michael_position']) && in_array($gameState['michael_position'], ['North_Beach', 'East_Beach', 'South_Beach', 'West_Beach']))
    <span id="michael-swimmer" class="{{ $gameState['michael_position'] }}">
        <img src="{{ asset('images/michael.jpg') }}" alt="Michael"/>
    </span>
@endif
