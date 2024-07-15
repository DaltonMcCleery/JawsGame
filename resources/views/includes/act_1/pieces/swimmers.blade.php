@if(isset($gameState['North_Beach_Swimmers']) && $gameState['North_Beach_Swimmers'] > 0)
    <div id="north-swimmers" title="{{ $gameState['North_Beach_Swimmers'] ?? 0 }}" class="absolute bottom-[70%] left-[30%] w-[55px]">
        <div class="relative">
            <img src="{{ asset('images/swimmer_1.jpg') }}" alt="North Beach Swimmers"/>
            <span class="absolute px-2 inline-flex md:text-lg text-2xl font-bold rounded-full top-[-15px] right-[-15px] bg-gray-700 text-white">
                {{ $gameState['North_Beach_Swimmers'] ?? 0 }}
            </span>
        </div>
    </div>
@endif

@if(isset($gameState['East_Beach_Swimmers']) && $gameState['East_Beach_Swimmers'] > 0)
    <div id="east-swimmers" title="{{ $gameState['East_Beach_Swimmers'] ?? 0 }}" class="absolute bottom-[62%] left-[74%] w-[55px]">
        <div class="relative">
            <img src="{{ asset('images/swimmer_2.jpg') }}" alt="East Beach Swimmers"/>
            <span class="absolute px-2 inline-flex md:text-lg text-2xl font-bold rounded-full top-[-15px] right-[-15px] bg-gray-700 text-white">
                {{ $gameState['East_Beach_Swimmers'] ?? 0 }}
            </span>
        </div>
    </div>
@endif

@if(isset($gameState['South_Beach_Swimmers']) && $gameState['South_Beach_Swimmers'] > 0)
    <div id="south-swimmers" title="{{ $gameState['South_Beach_Swimmers'] ?? 0 }}" class="absolute bottom-[16%] left-[61%] w-[55px]">
        <div class="relative">
            <img src="{{ asset('images/swimmer_3.jpg') }}" alt="South Beach Swimmers"/>
            <span class="absolute px-2 inline-flex md:text-lg text-2xl font-bold rounded-full top-[-15px] right-[-15px] bg-gray-700 text-white">
                {{ $gameState['South_Beach_Swimmers'] ?? 0 }}
            </span>
        </div>
    </div>
@endif

@if(isset($gameState['West_Beach_Swimmers']) && $gameState['West_Beach_Swimmers'] > 0)
    <div id="west-swimmers" title="{{ $gameState['West_Beach_Swimmers'] ?? 0 }}" class="absolute bottom-[30%] left-[7%] w-[55px]">
        <div class="relative">
            <img src="{{ asset('images/swimmer_4.jpg') }}" alt="West Beach Swimmers"/>
            <span class="absolute px-2 inline-flex md:text-lg text-2xl font-bold rounded-full top-[-15px] right-[-15px] bg-gray-700 text-white">
                {{ $gameState['West_Beach_Swimmers'] ?? 0 }}
            </span>
        </div>
    </div>
@endif

@if(isset($gameState['michael_position']) && \in_array($gameState['michael_position'], ['North_Beach', 'East_Beach', 'South_Beach', 'West_Beach']))
    <div id="michael-swimmer" class="absolute w-[30px] {{ $gameState['michael_position'] }}">
        <img src="{{ asset('images/michael.jpg') }}" alt="Michael"/>
    </div>
@endif
