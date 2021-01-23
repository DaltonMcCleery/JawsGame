@extends('wrapper')
@section('content')

    <section id="index-hero" class="hero is-dark is-large" style="background: url('{{ asset('images/background.jpg') }}')">
{{--        <iframe id="homepage-video" src="https://www.youtube.com/embed/2I91DJZKRxs?autoplay=1&modestbranding=1&rel=0"--}}
{{--                allowTransparency="true" frameborder="0" allow="autoplay; muted" volume="0" allowfullscreen></iframe>--}}
        <div class="hero-body">
            <div class="container">
                <h1 class="title">
                    You're gonna need a bigger boat...
                </h1>
            </div>
        </div>
    </section>

    <livewire:available-games />

@endsection
