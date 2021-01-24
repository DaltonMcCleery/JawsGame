@extends('wrapper')
@section('content')

    @livewire('game-wrapper', [
        'game' => $game,
        'event_cards' => $event_cards,
        'shark_ability_cards' => $shark_ability_cards,
        'resurface_cards' => $resurface_cards,
        'crew_cards' => $crew_cards
    ])

@endsection
