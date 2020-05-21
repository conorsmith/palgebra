@extends('layout')

@section('content')
    <table class="table">
        <thead>
        <tr>
            <th>Name</th>
            <th style="text-align: right">Number</th>
            <th style="text-align: right">Answers</th>
            <th style="text-align: right">Points</th>
            <th></th>
        </tr>
        </thead>
        @foreach($players as $player)
            <tr>
                <td><a href="/{{ $player->id }}/results">{{ $player->name }}</a></td>
                <td style="text-align: right">{{ $player->number }}</td>
                <td style="text-align: right">{{ $player->questions_answered }}</td>
                <td style="text-align: right; font-weight: bold;">{{ $player->points }}</td>
                <td style="text-align: right">
                    <form method="POST"
                          action="/game/{{ $game->id }}/remove/{{ $player->id }}"
                          onsubmit="return confirm('Remove {{ $player->name }}?');"
                    >
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-light btn-sm"><i class="fas fa-trash"></i></button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>

    @if($game->has_started)
        <div style="margin-top: 2rem; text-align: center;">
            Game started at {{ $game->started_at }}
        </div>
    @else
        <form method="POST" action="/game/{{ $game->id }}/start" style="font-family: 'Crimson Text', serif; font-size: 1.2rem; margin-top: 2rem;">
            {{ csrf_field() }}
            <button type="submit" class="btn btn-success btn-block" style="font-size: 1.2rem;">Start the Game</button>
        </form>
    @endif
    <hr>
    <a href="/dashboard" class="btn btn-light btn-block">Go to Dashboard</a>
@endsection
