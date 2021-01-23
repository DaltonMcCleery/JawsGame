@extends('wrapper')
@section('content')

    <div class="container mt-4">
        <div class="columns">
            <div class="column is-8">
                <livewire:profile/>
            </div>
            <div class="column is-4">

                <article class="panel is-dark">
                    <p class="panel-heading">
                        My Stats
                    </p>

                    <a class="panel-block">
                        <span class="panel-icon">
                            <i class="fas fa-book" aria-hidden="true"></i>
                        </span>
                        Total Wins: {{ $stats->games_won ?? '0' }}
                    </a>

                    <a class="panel-block">
                        <span class="panel-icon">
                            <i class="fas fa-book" aria-hidden="true"></i>
                        </span>
                        Total Games Played: {{ $stats->games_played ?? '0' }}
                    </a>

                    <hr>

                    <a class="panel-block">
                        <span class="panel-icon">
                            <i class="fas fa-book" aria-hidden="true"></i>
                        </span>
                        Wins as Shark: {{ $stats->won_as_shark ?? '0' }}
                    </a>

                    <a class="panel-block">
                        <span class="panel-icon">
                            <i class="fas fa-book" aria-hidden="true"></i>
                        </span>
                        Wins as Brody: {{ $stats->won_as_brody ?? '0' }}
                    </a>

                    <a class="panel-block">
                        <span class="panel-icon">
                            <i class="fas fa-book" aria-hidden="true"></i>
                        </span>
                        Wins as Hooper: {{ $stats->won_as_hooper ?? '0' }}
                    </a>

                    <a class="panel-block">
                        <span class="panel-icon">
                            <i class="fas fa-book" aria-hidden="true"></i>
                        </span>
                        Wins as Quint: {{ $stats->won_as_quint ?? '0' }}
                    </a>

                    <hr>

                    <a class="panel-block">
                        <span class="panel-icon">
                            <i class="fas fa-book" aria-hidden="true"></i>
                        </span>
                        Times picked Shark: {{ $stats->times_picked_shark ?? '0' }}
                    </a>

                    <a class="panel-block">
                        <span class="panel-icon">
                            <i class="fas fa-book" aria-hidden="true"></i>
                        </span>
                        Times picked Brody: {{ $stats->times_picked_brody ?? '0' }}
                    </a>

                    <a class="panel-block">
                        <span class="panel-icon">
                            <i class="fas fa-book" aria-hidden="true"></i>
                        </span>
                        Times picked Hooper: {{ $stats->times_picked_hooper ?? '0' }}
                    </a>

                    <a class="panel-block">
                        <span class="panel-icon">
                            <i class="fas fa-book" aria-hidden="true"></i>
                        </span>
                        Times picked Quint: {{ $stats->times_picked_quint ?? '0' }}
                    </a>

                </article>
            </div>
        </div>
    </div>

@endsection
