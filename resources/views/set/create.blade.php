@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center ">
        <div class="col-md-8 " >
                <h1>Create Set</h1>
                    {!! Form::open(['action' => 'SetController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                        <div class="form-group">
                            {{Form::label('Title', 'Title')}}
                            {{Form::text('title', '', ['class' => 'form-control', 'placeholder' => 'Name'])}}
                        </div>
                        {{Form::submit('Submit', ['class'=>'btn btn-primary' ])}}
                        
                    {!! Form::close() !!}
                </div>
        </div>
    </div>
</div>
@endsection