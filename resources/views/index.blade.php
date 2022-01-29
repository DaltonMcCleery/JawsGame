@extends('wrapper')
@section('content')

    <section class="w-full">
        <div class="relative min-h-[400px]">
            <div class="absolute inset-0">
                <img class="h-full w-full object-cover" src="{{ asset('images/background.jpg') }}" alt="JAWS Logo">
                <div class="absolute inset-0 bg-black mix-blend-multiply opacity-50"></div>
            </div>
            <div class="relative px-4 py-16 sm:px-6 sm:py-24 lg:py-32 lg:px-8 flex flex-col justify-center items-center">
                <h1 class="text-center uppercase text-4xl font-extrabold tracking-tight sm:text-5xl lg:text-6xl text-red">
                    JAWS
                </h1>
                <h2 class="text-center text-xl font-extrabold tracking-tight sm:text-2xl text-white">
                    We're gonna need a bigger boat
                </h2>
            </div>
        </div>
    </div>

    <livewire:available-games />

@endsection
