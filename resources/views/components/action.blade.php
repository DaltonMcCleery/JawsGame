<a class="relative cursor-pointer rounded-lg border-2 bg-white px-6 py-5 shadow-sm flex flex-col items-center
   {{ $currentAction === ($action ?? '') ? 'border-custom-red' : 'border-transparent' }}"
   wire:click="switchNextAction('{{ $action ?? '' }}')">
    {{ $slot }}
</a>
