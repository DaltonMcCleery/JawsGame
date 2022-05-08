@if (($gameState['active_character'] ?? 'N/A') === 'shark')
    <script>
        setTimeout(function () {
            let audio = new Audio('{{ asset('storage/shark.mp3') }}');
            audio.volume = 0.5;
            audio.loop = true;
            audio.play();
        }, 2000);
    </script>
@elseif (($gameState['audio'] ?? null) !== null)
    <script>
        setTimeout(function () {
            new Audio('{{ asset('storage/'.$gameState['audio'].'.mp3') }}').play();
        }, 2000);
    </script>
@endif
