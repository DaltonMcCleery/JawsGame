<div class="tabs is-toggle is-fullwidth">
    <ul>
        <li class="@if(isset($gameState['current_phase']) && $gameState['current_phase'] === 'Event') is-active @endif">
            <a disabled>
                <span>Event Phase</span>
            </a>
        </li>
        <li class="@if(isset($gameState['current_phase']) && $gameState['current_phase'] === 'Shark') is-active @endif">
            <a disabled>
                <span>Shark Phase</span>
            </a>
        </li>
        <li class="@if(isset($gameState['current_phase']) && $gameState['current_phase'] === 'Crew') is-active @endif">
            <a disabled>
                <span>Crew Phase</span>
            </a>
        </li>
    </ul>
</div>
