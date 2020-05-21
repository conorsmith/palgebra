@extends('layout')

@section('content')
    @if(session("error"))
        <div class="alert alert-danger" style="text-align: center;">
            {{ session("error") }}
        </div>
    @endif
    <div class="card" style="font-size: 1.4rem; text-align: center;">
        <div class="card-body">

            <p>Welcome, {{ $name }}</p>
            <p>Your number is <strong>{{ $number }}</strong></p>
            <p style="margin-bottom: 2rem;">Remember this</p>

            <p>You may submit each answer only once</p>
            <p style="margin-bottom: 2rem;">Remember this</p>

            <p>
                Your lucky colour is
                <span style="padding: 0.1rem 0.4rem; background-color: {{ $colour['value'] }};">
                    <span style="mix-blend-mode: difference; color: #fff; font-weight: 700;">
                        {!! $colour['label'] !!}
                    </span>
                </span>
            </p>
            <p style="margin-bottom: 2rem;">Do not remember this</p>

            <p>When all players are ready, press below</p>

            <a href="/{{ $playerId }}/question/1"
               class="btn btn-success btn-block"
               style="font-size: 1.4rem;"
            >Below</a>
        </div>
    </div>
@endsection
