<div class="relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity"></div>

    <div class="fixed z-10 inset-0 overflow-y-auto">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- This element is to trick the browser into centering the modal contents. -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div class="relative inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full sm:p-6">
                <div class="mt-3 text-center sm:mt-5">
                    <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Act I</h3>
                    <div class="mt-2">
                        <p class="text-sm text-gray-500 mb-4">
                            Game Over<br/>
                            @if ($gameState['shark_barrels'] === 2)
                                Humans win!
                            @else
                                Shark Wins!
                            @endif
                        </p>

                        <button wire:click="watchReplay()" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-brody text-base font-medium text-white">
                            Watch Act I Replay
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
