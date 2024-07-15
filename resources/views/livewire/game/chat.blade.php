<article id="chat-window" class="p-4">
{{--    <div id="lobbyChat" class="overflow-y-auto scrolling-height">--}}
{{--        @foreach($lobbyMessages as $message)--}}
{{--            <p class="mb-3">--}}
{{--                <strong>{{ $message['username'] }}</strong><br/>--}}
{{--                {{ $message['message'] }}--}}
{{--            </p>--}}
{{--        @endforeach--}}
{{--    </div>--}}

    @if ($isUsernameSet)
        <div class="min-w-0 flex-1">
            <form class="relative" wire:submit.prevent="chat">
                <div class="border border-gray-300 rounded-lg shadow-sm overflow-hidden focus-within:border-indigo-500 focus-within:ring-1 focus-within:ring-indigo-500">
                    <label for="comment" class="sr-only">Add your comment</label>
                    <textarea rows="3" name="comment" id="comment" class="block w-full py-3 border-0 resize-none focus:ring-0 sm:text-sm"
                              placeholder="Add your comment..." autofocus
                              wire:model="message" wire:keydown.enter="chat"></textarea>

                    <!-- Spacer element to match the height of the toolbar -->
                    <div class="py-2" aria-hidden="true">
                        <div class="py-px">
                            <div class="h-9"></div>
                        </div>
                    </div>
                </div>

                <div class="absolute bottom-0 inset-x-0 pl-3 pr-2 py-2 flex justify-between rounded-b-lg bg-white">
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 justify-center w-full"
                            wire:click="chat">
                        Submit Message
                    </button>
                </div>
            </form>
        </div>
    @else
        <div class="bg-white shadow sm:rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Chat Username</h3>
                <p class="mt-2 max-w-xl text-sm text-gray-700">
                    Enter a chat username
                </p>
                <form class="mt-5 sm:flex sm:items-center" wire:submit.prevent="setUsername">
                    <div class="w-full sm:max-w-xs">
                        <label for="username" class="sr-only">Username</label>
                        <input type="text" name="username" id="username" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                               wire:model="username" autofocus>
                    </div>
                    <button type="submit" class="mt-3 w-full inline-flex items-center justify-center px-4 py-2 border border-transparent shadow-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                            wire:click="setUsername()">
                        Save
                    </button>
                </form>
            </div>
        </div>
    @endif

</article>

@push('scripts')
    <script>
        const lobbyChatWindow = document.getElementById('lobbyChat');
        Livewire.on('scrollChatMessages', function() {
            var messages = lobbyChatWindow.querySelectorAll('p');
            if (messages.length > 1) {
                (messages[messages.length - 1]).scrollIntoView()
            }
        })

        {{--Echo.join('lobby.{{ $session_id }}')--}}
        {{--    .listen('Chat.LobbyChat', (data) => {--}}
        {{--        Livewire.emit('newLobbyMessage', data);--}}
        {{--    })--}}
            // .listen('Chat.SyncLobbyChat', (data) => {
            //     Livewire.emit('syncChatMessages', data.messages);
            // })
    </script>
@endpush
