@extends('layout')

@section('content')
    @if(session("error"))
        <div class="alert alert-danger" style="text-align: center;">
            {{ session("error") }}
        </div>
    @endif
    <div class="card" style="font-size: 1.4rem; text-align: center;">
        <div class="card-body">
            <form method="POST">
                {{ csrf_field() }}
                <div class="form-group">
                    <label>Enter your name</label>
                    <input type="text" class="form-control" name="name" autocomplete="off" autofocus>
                </div>
                <button type="submit" class="btn btn-success btn-block" style="font-size: 1.4rem;">Ready</button>
            </form>
        </div>
    </div>
@endsection
