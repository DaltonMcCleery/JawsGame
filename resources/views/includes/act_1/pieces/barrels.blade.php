@if(isset($gameState['Shop_barrels']) && $gameState['Shop_barrels'] > 0)
    <div id="shop-barrels" title="{{ $gameState['Shop_barrels'] }}" class="absolute bottom-[47%] left-[45%] w-[45px]">
        <div class="relative">
            <img src="{{ asset('images/barrel.png') }}" alt="Barrel"/>
            <span class="absolute px-2 inline-flex md:text-lg text-2xl font-bold rounded-full top-[-15px] right-[-15px] bg-gray-700 text-white">
                {{ $gameState['Shop_barrels'] }}
            </span>
        </div>
    </div>
@endif

@if(isset($gameState['Space_8_barrels']) && $gameState['Space_8_barrels'] > 0)
    <div id="space-8-barrels" title="{{ $gameState['Space_8_barrels'] }}" class="absolute bottom-[55%] left-[24%] w-[45px]">
        <div class="relative">
            <img src="{{ asset('images/barrel.png') }}" alt="Barrel"/>
            <span class="absolute px-2 inline-flex md:text-lg text-2xl font-bold rounded-full top-[-15px] right-[-15px] bg-gray-700 text-white">
                {{ $gameState['Space_8_barrels'] }}
            </span>
        </div>
    </div>
@endif

@if(isset($gameState['Space_5_barrels']) && $gameState['Space_5_barrels'] > 0)
    <div id="space-5-barrels" title="{{ $gameState['Space_5_barrels'] }}" class="absolute bottom-[27%] left-[85%] w-[45px]">
        <div class="relative">
            <img src="{{ asset('images/barrel.png') }}" alt="Barrel"/>
            <span class="absolute px-2 inline-flex md:text-lg text-2xl font-bold rounded-full top-[-15px] right-[-15px] bg-gray-700 text-white">
                {{ $gameState['Space_5_barrels'] }}
            </span>
        </div>
    </div>
@endif
