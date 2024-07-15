<a class="relative cursor-pointer rounded-lg border-2 bg-white px-6 py-5 shadow-sm flex flex-col items-center
   {{ ($action ?? false) ? '' : 'bg-red-100' }}
   {{ $currentAction === ($action ?? '') ? 'border-custom-red' : 'border-transparent' }}"
   @if ($action ?? false)
   wire:click="switchNextAction('{{ $action ?? '' }}')"
   @endif
>
    {{ $slot }}

    @if (! $action ?? true)
        <p class="absolute -rotate-6 top-0 left-0 w-full h-full flex justify-center items-center font-bold text-custom-red text-2xl font-demi-italic">
            USED
        </p>
    @endif
</a>
