@extends('layout')

@section('content')
    @if(session("correct"))
        <div class="alert alert-success" style="text-align: center;">
            <i class="fas fa-fw fa-check"></i> {{ session("correct") }}
        </div>
    @endif
    @if(session("incorrect"))
        <div class="alert alert-danger" style="text-align: center;">
            <i class="fas fa-fw fa-times"></i> {{ session("incorrect") }}
        </div>
    @endif
    @if(session("error"))
        <div class="alert alert-danger" style="text-align: center;">
            {{ session("error") }}
        </div>
    @endif
    @if(session("questionAnswered"))
        <div class="alert alert-danger" style="text-align: center;">
            You have already answered this question.
            @if($isLastQuestion)
                <a href="/{{ $playerId }}/results" class="alert-link">Proceed to your results.</a>
            @else
                <a href="/{{ $playerId }}/question/{{ $questionId + 1 }}" class="alert-link">Proceed to the next question.</a>
            @endif
        </div>
    @endif
    <div class="card" style="font-size: 1.4rem;">
        <div class="card-header" style="text-align: center;">
            Question {{ $questionId }}
        </div>
        <div class="card-body">
            <div style="text-align: center; font-size: 2rem;">
                {!! $question !!}
            </div>
            <form method="POST">
                {{ csrf_field() }}
                <div class="form-group" style="text-align: center; margin-top: 1rem;">
                    <label>Solve for x</label>
                    <input type="number" class="form-control" name="answer" autocomplete="off" autofocus>
                </div>
                <button type="submit" class="btn btn-success btn-block" style="font-size: 1.4rem;">Submit</button>
            </form>
        </div>
    </div>
    <div style="text-align: center; font-size: 1.4rem; margin-top: 2rem;">
        Remember, {{ $name }}, your number is <strong>{{ $number }}</strong>
    </div>
@endsection
