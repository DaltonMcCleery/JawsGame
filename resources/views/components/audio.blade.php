@if (($gameState['active_character'] ?? 'N/A') === 'shark')
    <audio class="hidden">
        <source src="{{ asset('storage/shark.mp3') }}" type="audio/mpeg">
        Your browser does not support the audio element.
    </audio>
    <script>
        setTimeout(function () {
            let audio = document.getElementsByTagName('audio')[0];
            audio.autoplay = true;
            audio.load();
        }, 2000);
    </script>
@elseif (($gameState['audio'] ?? null) !== null)
    <audio class="hidden">
        <source src="{{ asset('storage/'.$gameState['audio'].'.mp3') }}" type="audio/mpeg">
        Your browser does not support the audio element.
    </audio>
    <script>
        setTimeout(function () {
            let audio = document.getElementsByTagName('audio')[0];
            audio.autoplay = true;
            audio.load();
        }, 2000);
    </script>
@endif
