<div class="relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity"></div>

    <div class="fixed z-10 inset-0 overflow-y-auto">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- This element is to trick the browser into centering the modal contents. -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div class="relative inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full sm:p-6">
                @if ($gameState['shark_moves'] === 0)
                    <div class="mt-3 text-center sm:mt-5">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Crew's Turn</h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">
                                Please pass the controller to the appropriate crew member.
                            </p>
                        </div>
                    </div>
                    <div class="mt-5 sm:mt-6 sm:grid sm:grid-cols-3 sm:gap-3 sm:grid-flow-row-dense">
                        @if ($gameState['brody_moves'] !== 0)
                            <button wire:click="setActivePlayer('brody')" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-brody text-base font-medium text-white">
                                Brody
                            </button>
                        @endif
                        @if ($gameState['hooper_moves'] !== 0)
                            <button wire:click="setActivePlayer('hooper')" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-hooper text-base font-medium text-white">
                                Hooper
                            </button>
                        @endif
                        @if ($gameState['quint_moves'] !== 0)
                            <button wire:click="setActivePlayer('quint')" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-quint text-base font-medium text-white">
                                Quint
                            </button>
                        @endif
                    </div>
                @else
                    <div class="mt-3 text-center sm:mt-5">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Shark's Turn</h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">
                                Please pass the controller to the shark player.
                            </p>
                        </div>
                    </div>
                    <div class="mt-5 sm:mt-6">
                        <button wire:click="setActivePlayer('shark')" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-custom-red text-base font-medium text-white">
                            Play
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
