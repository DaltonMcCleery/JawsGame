<div id="act-1" wire:init="loadStartingActOneState">

    <div class="notification is-dark" style="flex-basis: 100%;">
        @foreach($gameState as $key => $value)
            <p>
                <strong>{{ $key }}</strong> => {{ $value }}
            </p>
        @endforeach
    </div>

    <div class="notification is-info" style="flex-basis: 100%;">
        Current Player's Turn: <strong>{{ $activePlayer }}</strong><br/>
        {{ $currentMove }}
    </div>

    @error('action-error')
        <div class="column is-full mb-2">
            <article class="message is-danger">
                <div class="message-body">{{ $message }}</div>
            </article>
        </div>
    @enderror

    <div class="image">
        <img src="{{ asset('images/act_1_board_1132x750.jpg') }}" alt="Act I Board" usemap="#act_1_map">

        @if(isset($gameState['shark_position']) && (($game->Shark->User->username === Auth::user()->username) || $showShark))
            <span id="shark-position" class="{{ $gameState['shark_position'] }}"></span>
        @endif
    </div>

    <map name="act_1_map" class="@if($activePlayer !== Auth::user()->username) disabled @endif">
        {{-- Outside water spaces --}}
        <area alt="Space 1" title="Space 1" wire:click="attemptAction('Space_1')"
              coords="560,47,559,3,3,4,4,320,133,320,243,203,340,129,443,77" shape="poly">
        <area alt="Space 2" title="Space 2" wire:click="attemptAction('Space_2')"
              coords="564,46,564,5,1131,4,1131,324,1066,325,1005,247,939,176,868,112,823,79,741,45,635,38" shape="poly">
        <area alt="Space 3" title="Space 3" wire:click="attemptAction('Space_3')"
              coords="509,643,510,747,4,748,2,327,127,328,74,381,51,424,40,472,46,520,66,564,102,619,145,656,194,685,245,696,303,686,336,673,397,655,460,643" shape="poly">
        <area alt="Space 4" title="Space 4" wire:click="attemptAction('Space_4')"
              coords="517,643,517,747,1131,748,1131,332,1071,330,1094,365,1106,407,1105,447,1094,495,1077,543,1053,600,1024,646,996,682,947,711,894,721,841,707,806,682,767,657,702,650,597,647" shape="poly">

        {{-- Beaches --}}
        <area alt="North Beach" title="North Beach" wire:click="attemptAction('North_Beach')"
              coords="250,205,464,326,576,246,584,223,558,205,558,54,474,77,391,113,317,155" shape="poly">
        <area alt="East Beach" title="East Beach" wire:click="attemptAction('East_Beach')"
              coords="944,193,1057,325,869,323,803,350,788,370,746,376,734,360,719,354,719,326,733,281,758,216,852,113" shape="poly">
        <area alt="South Beach" title="South Beach" wire:click="attemptAction('South_Beach')"
              coords="517,638,517,498,569,439,628,460,704,508,805,537,888,713,849,698,807,668,766,646,687,645" shape="poly">
        <area alt="West Beach" title="West Beach" wire:click="attemptAction('West_Beach')"
              coords="137,328,329,460,323,549,192,681,106,616,59,542,42,472,64,407,100,358" shape="poly">

        {{-- Other --}}
        <area alt="Space 5 (Dock)" title="Space 5 (Dock)" wire:click="attemptAction('Space_5')"
              coords="142,324,247,211,458,333,396,396,327,454" shape="poly">
        <area alt="Space 6" title="Space 6 (Mayor's Office)" wire:click="attemptAction('Space_6')"
              coords="563,54,644,43,744,56,817,87,847,108,753,210,712,323,710,356,693,385,630,449,573,432,607,396,641,332,641,315,545,282,594,236,586,212,562,199" shape="poly">
        <area alt="Space 7" title="Space 7 (Amity PD.)" wire:click="attemptAction('Space_7')"
              coords="510,636,422,642,344,663,261,687,201,682,328,555,334,458,401,401,461,430,454,444,515,469" shape="poly">
        <area alt="Space 8 (Dock)" title="Space 8 (Dock)" wire:click="attemptAction('Space_8')"
              coords="1065,331,1098,399,1094,461,1058,575,1004,663,956,704,898,717,808,532,704,500,635,453,714,360,741,378,791,374,803,357,864,331" shape="poly">

        {{-- Shop --}}
        <area alt="Shop" title="Shop" onclick="console.log('Shop!')"
              coords="407,398,470,334,534,277,553,289,566,282,573,295,636,318,630,340,603,391,536,468,463,443,467,427" shape="poly">
    </map>
</div>
