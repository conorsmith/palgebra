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
    <div class="card">
        <table class="table">
            <thead>
                <tr>
                    <th>Question</th>
                    <th style="text-align: right">Your Answer</th>
                    <th style="text-align: right">Correct Answer</th>
                </tr>
            </thead>
            @foreach($answers as $answer)
                <tr class="{{ $answer->is_correct ? "table-success" : "table-danger" }}">
                    <td><span style="font-style: italic;">{{ $answer->question }}:&nbsp;&nbsp;</span> {!! $answer->question_text !!}</td>
                    <td style="text-align: right">{{ number_format($answer->given_answer) }}</td>
                    <td style="text-align: right">{{ number_format($answer->correct_answer) }}</td>
                </tr>
            @endforeach
        </table>
        <div style="text-align: center; margin-bottom: 0.4rem; font-size: 2rem;">
            You scored <strong>{{ $points }}</strong> point{{ $points === 1 ? "" : "s" }}!
        </div>
        <div style="text-align: center; margin-bottom: 1rem; font-size: 1.4rem;">
            @if($points === 10)
                A perfect score, {{ $name }}
            @elseif($points > 4)
                Well done, {{ $name }}
            @elseif($points > 1)
                It's the effort that counts, {{ $name }}
            @else
                Oh, {{ $name }}...
            @endif
        </div>
    </div>
    <div style="text-align: center; font-size: 1.4rem; margin-top: 2rem;">
        Remember, {{ $name }}, your number was <strong>{{ $number }}</strong>
    </div>
@endsection
