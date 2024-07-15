@extends('wrapper')
@section('content')
    <section class="w-full">
        <div class="relative min-h-[400px]">
            <div class="absolute inset-0">
                <img class="h-full w-full object-cover" src="{{ asset('images/500.jpeg') }}" alt="JAWS Logo">
                <div class="absolute inset-0 bg-black mix-blend-multiply opacity-50"></div>
            </div>
            <div class="relative px-4 py-16 sm:px-6 sm:py-24 lg:py-32 lg:px-8 flex flex-col justify-center items-center">
                <p class="text-sm font-semibold text-white text-opacity-50 uppercase tracking-wide">500 error</p>
                <h1 class="text-center text-xl font-extrabold tracking-tight md:text-4xl text-white">
                    The holiday ham was eaten...
                </h1>
                <div class="mt-6">
                    <a href="/" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-black text-opacity-75 bg-white bg-opacity-75 sm:bg-opacity-25 sm:text-white sm:hover:bg-custom-red sm:hover:bg-opacity-50">
                        Go back home
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
