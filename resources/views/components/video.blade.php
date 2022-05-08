<div class="col-span-12">
    @if (($gameState['video'] ?? null) !== null)
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity z-10"></div>

        <div class="absolute top-[10%] inline-block overflow-hidden w-full z-50">
            <video-js id="video">
                <source src="{{ asset('storage/'.$gameState['video'].'.mov') }}">
            </video-js>
        </div>

        <script>
            setTimeout(function () {
                let player = videojs('video', {
                    muted: false
                });

                player.play();

                player.on('ended', function() {
                    window.livewire.emit('onVideoEnd');
                });
            }, 1000);
        </script>
    @endif
</div>
