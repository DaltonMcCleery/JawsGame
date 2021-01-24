<div class="container mt-4">
    <div class="columns">
        <div class="column is-12">
            @if($act === 1)
                <livewire:game-act-one :game="$game" :gameState="$gameState"/>
            @else
                <livewire:game-act-two :game="$game" :gameState="$gameState"/>
            @endif
        </div>
    </div>
    <div class="columns">
        <div class="column is-3">
            <h1>Brody Card</h1>
        </div>
        <div class="column is-3">
            <h1>Hooper Card</h1>
        </div>
        <div class="column is-3">
            <h1>Quint Card</h1>
        </div>
        <div class="column is-3">
            <livewire:chat :game="$game"/>
        </div>
    </div>
</div>
