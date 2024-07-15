<div class="col-span-12">
    @if (($gameState['video'] ?? null) !== null)
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity z-10"></div>

        <div class="absolute top-[10%] right-0 left-0 inline-block overflow-hidden w-full z-50">
            <video-js id="video-{{ $gameState['video'] }}" class="mx-auto">
                <source src="{{ asset('videos/'.$gameState['video'].'.mov') }}">
            </video-js>
        </div>

        <script>
            setTimeout(function () {
                window.videoPlayer = videojs('video-{{ $gameState['video'] }}', {}, function onPlayerReady() {
                    this.src({src: '{{ asset('videos/'.$gameState['video'].'.mov') }}'});

                    this.play();

                    this.on('ended', function() {
                        window.livewire.emit('onVideoEnd');
                    });
                });
            }, 1000);
        </script>
    @endif

    <script>
        window.videoPlayer = null;
    </script>
</div>
