@if(isset($gameState['Shop_barrels']) && $gameState['Shop_barrels'] > 0)
    <span id="shop-barrels" title="{{ $gameState['Shop_barrels'] }}" class="barrels-count">
        <img src="{{ asset('images/barrel.png') }}" alt="Barrel"/>
    </span>
@endif

@if(isset($gameState['Space_8_barrels']) && $gameState['Space_8_barrels'] > 0)
    <span id="space-8-barrels" title="{{ $gameState['Space_8_barrels'] }}" class="barrels-count">
        <img src="{{ asset('images/barrel.png') }}" alt="Barrel"/>
    </span>
@endif

@if(isset($gameState['Space_5_barrels']) && $gameState['Space_5_barrels'] > 0)
    <span id="space-5-barrels" title="{{ $gameState['Space_5_barrels'] }}" class="barrels-count">
        <img src="{{ asset('images/barrel.png') }}" alt="Barrel"/>
    </span>
@endif
