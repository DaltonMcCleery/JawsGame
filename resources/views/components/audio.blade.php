@if (($gameState['active_character'] ?? 'N/A') === 'shark')
    <audio controls autoplay class="hidden">
        <source src="{{ asset('storage/shark.mp3') }}" type="audio/mpeg">
        Your browser does not support the audio element.
    </audio>
    <script>
        document.getElementsByTagName('audio')[0].play();
    </script>
@endif
