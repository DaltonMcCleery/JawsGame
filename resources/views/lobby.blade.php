@extends('wrapper')
@section('content')

    <div class="container mt-4">
        <div class="columns">
            <div class="column is-8">
                <livewire:character-select :game="$game"/>
            </div>
            <div class="column is-4">
                <livewire:chat :game="$game"/>
            </div>
        </div>
    </div>

@endsection
