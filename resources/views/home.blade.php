@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if(Auth::user()->api_token == '')
                        <form action="{{'/generate'}}" method="POST">
                            @csrf
                            <button class="btn btn-sm btn-danger" type="submit">Generate My Token</button>
                        </form>
                    @else
                        Your Token : <strong>{{Auth::user()->api_token}}</strong>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
