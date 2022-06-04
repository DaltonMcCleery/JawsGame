@if (($gameState['active_character'] ?? 'N/A') === 'shark')
    @once
        <script>
            const gameAudio = new Audio('{{ asset('audio/shark.mp3') }}');
            setTimeout(function () {
                gameAudio.volume = 0.2;
                gameAudio.loop = {{ $gameState['act_1_over'] ? 'false' : 'true' }};
                gameAudio.play();
            }, 5000);
        </script>
    @endonce
@elseif (($gameState['audio'] ?? null) !== null)
    <script>
        setTimeout(function () {
            new Audio('{{ asset('audio/'.$gameState['audio'].'.mp3') }}').play();
        }, 2000);
    </script>
@endif

@if(isset($gameState['act_1_over']) && $gameState['act_1_over'] === true)
    <script>
        if (gameAudio) {
            gameAudio.loop = false;
            gameAudio.pause();
        }
    </script>
@endif
