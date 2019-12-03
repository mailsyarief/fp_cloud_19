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
                <form id="formId" method="POST">
                    <input class="form-control" type="text" name="api_token" value="{{Auth::user()->api_token}}" readonly>
                    <input class="form-control" type="text" name="to" value="png">
                    <input class="form-control" type="file" name="file" readonly>
                    <button class="btn btn-xs" type="submit">Submit</button>  
                </form>
                <div id="link">

                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
$( '#formId' )
  .submit( function( e ) {
    $.ajax( {
      url: 'http://localhost:8000/api/convert',
      type: 'POST',
      data: new FormData( this ),
      processData: false,
      contentType: false,
      success:function(data){

          url = "<a href='"+JSON.parse(data)+"'>donlot</a>";
          $('#link').html(url)
      }
    } );
    e.preventDefault();
  } );
</script>
@endsection
