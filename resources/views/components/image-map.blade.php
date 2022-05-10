<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve"
    class="absolute top-0 right-0 bottom-0 left-0 w-full h-full" viewBox="0 0 708 473">

{{--    <span class="animate-pulse"></span>--}}

    <g title="Open Water">
        <polyline title="Space_1" wire:click="attemptAction('Space_1')" class="cursor-pointer {{ $class['Space_1'] ?? '' }}"
                  fill="{{ $fill['Space_1'] ?? 'transparent' }}"
                  points="349,34,350,1,0,-1,-1,205,85,207,155,130,197,97,244,71,295,49"/>

        <polyline title="Space_2" wire:click="attemptAction('Space_2')" class="cursor-pointer {{ $class['Space_2'] ?? '' }}"
                  fill="{{ $fill['Space_2'] ?? 'transparent' }}"
                  points="351,1,707,1,707,204,664,206,596,127,534,70,478,40,413,30,352,34" />

        <polyline title="Space_3" wire:click="attemptAction('Space_3')" class="cursor-pointer {{ $class['Space_3'] ?? '' }}"
                  fill="{{ $fill['Space_3'] ?? 'transparent' }}"
                  points="-1,208,0,472,322,472,321,402,264,409,175,436,136,438,88,412,58,380,30,338,25,292,37,259,60,227,82,208" />

        <polyline title="Space_4" wire:click="attemptAction('Space_4')" class="cursor-pointer {{ $class['Space_4'] ?? '' }}"
                  fill="{{ $fill['Space_4'] ?? 'transparent' }}"
                  points="326,472,707,471,707,211,670,208,688,240,690,275,681,313,670,348,652,384,635,413,616,431,583,447,551,449,527,437,500,420,476,408,429,406,388,406,324,402,325,439,324,457" />
    </g>

    <g title="Beaches">
        <polyline title="North_Beach" wire:click="attemptAction('North_Beach')" class="cursor-pointer {{ $class['North_Beach'] ?? '' }}"
                  fill="{{ $fill['North_Beach'] ?? 'transparent' }}"
                  points="349,39,349,131,365,144,342,171,317,181,290,210,156,134,179,113,215,89,249,71,285,55,323,43" />

        <polyline title="East_Beach" wire:click="attemptAction('East_Beach')" class="cursor-pointer {{ $class['East_Beach'] ?? '' }}"
                  fill="{{ $fill['East_Beach'] ?? 'transparent' }}"
                  points="534,74,478,134,451,208,450,223,459,226,467,235,494,232,501,224,537,207,659,205,633,175,609,147,584,121,558,96" />

        <polyline title="South_Beach" wire:click="attemptAction('South_Beach')" class="cursor-pointer {{ $class['South_Beach'] ?? '' }}"
                  fill="{{ $fill['South_Beach'] ?? 'transparent' }}"
                  points="325,399,326,315,357,277,394,289,442,319,503,337,556,447,522,433,496,413,464,404,398,404" />

        <polyline title="West_Beach" wire:click="attemptAction('West_Beach')" class="cursor-pointer {{ $class['West_Beach'] ?? '' }}"
                  fill="{{ $fill['West_Beach'] ?? 'transparent' }}"
                  points="86,211,205,292,203,346,124,428,86,402,63,380,44,350,33,325,29,301,35,273,51,246" />
    </g>

    <g title="Docks">
        <polyline title="Space_5" wire:click="attemptAction('Space_5')" class="cursor-pointer {{ $class['Space_5'] ?? '' }}"
                  fill="{{ $fill['Space_5'] ?? 'transparent' }}"
                  points="156,135,287,212,208,288,178,269,172,257,165,259,89,207" />

        <polyline title="Space_8" wire:click="attemptAction('Space_8')" class="cursor-pointer {{ $class['Space_8'] ?? '' }}"
                  fill="{{ $fill['Space_8'] ?? 'transparent' }}"
                  points="663,209,542,209,518,219,499,233,467,241,450,228,440,243,399,287,444,316,506,334,561,446,592,442,621,420,639,397,655,369,670,333,681,299,685,271,681,241" />
    </g>

    <g title="Other">
        <polyline title="Space_6" wire:click="attemptAction('Space_6')" class="cursor-pointer {{ $class['Space_6'] ?? '' }}"
                  fill="{{ $fill['Space_6'] ?? 'transparent' }}"
                  points="352,40,351,127,372,142,342,175,366,187,406,201,360,275,397,280,411,265,435,246,437,233,447,226,447,203,472,138,529,72,499,53,456,37,420,31,373,34,362,35" />

        <polyline title="Space_7" wire:click="attemptAction('Space_7')" class="cursor-pointer {{ $class['Space_7'] ?? '' }}"
                  fill="{{ $fill['Space_7'] ?? 'transparent' }}"
                  points="250,256,210,291,206,348,128,429,157,435,192,426,227,414,266,404,296,399,320,400,321,314,329,295,286,283,285,269" />
    </g>

    <g title="Shop">
        <polyline title="Shop" wire:click="attemptAction('Shop')" class="cursor-pointer {{ $class['Shop'] ?? '' }}"
                  fill="{{ $fill['Shop'] ?? 'transparent' }}"
                  points="255,252,315,188,335,178,343,184,350,184,399,202,377,246,336,295,320,291,288,278,295,270" />
    </g>
</svg>
