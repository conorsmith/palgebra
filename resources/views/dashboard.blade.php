@extends('layout')

@section('content')
    <table class="table">
        <thead>
        <tr>
            <th>Created</th>
            <th>Players</th>
            <th>Started</th>
            <th colspan="2"></th>
        </tr>
        </thead>
        @foreach($games as $game)
            <tr>
                <td>{{ $game->created_at }}</td>
                <td>{{ $game->players }}</td>
                <td>{{ $game->started_at ?? "—" }}</td>
                <td style="text-align: right;">
                    @if(!$game->is_active)
                        <form method="POST" action="/game/{{ $game->id }}/activate">
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-light btn-sm">
                                <i class="fas fa-star"></i>
                            </button>
                        </form>
                    @endif
                </td>
                <td style="text-align: right;">
                    <a href="/game/{{ $game->id }}" class="btn btn-light btn-sm">
                        <i class="fas fa-eye"></i>
                    </a>
                </td>
            </tr>
        @endforeach
    </table>

    <form method="POST" action="/game" style="margin-top: 2rem;">
        {{ csrf_field() }}
        <button type="submit" class="btn btn-success btn-block" style="font-size: 1.2rem;">
            Create New Game
        </button>
    </form>

@endsection
