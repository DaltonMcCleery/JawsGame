@extends('wrapper')
@section('content')

    <section class="hero is-dark is-large">
        <div class="hero-body">
            <div class="container">
                <h1 class="title">
                    Jaws
                </h1>
                <h2 class="subtitle">
                    You're gonna need a bigger boat...
                </h2>
            </div>
        </div>
    </section>

    <livewire:available-games />

@endsection
@section('scripts')
@endsection
