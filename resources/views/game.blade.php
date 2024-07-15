@extends('layout.game')
@section('content')

    @livewire('game.game-wrapper', ['game' => $game])

@endsection
