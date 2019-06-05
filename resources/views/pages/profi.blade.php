@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center ">
        <div class="col-md-8 " >
                <h1>Profile</h1>
                <small>ID:{{$a->id}} </small>
                    {!! Form::open(['action' => 'PagesController@update', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                        <div class="form-group">
                                <div class="card-header">Name <input type='text' class='form-control' name='name' value="{{$a->name}}"> </input></div>


                        </div>
                        <div class="form-group">
                                <div class="card-header">Email: <input type='text' class='form-control' name='email' value={{$a->email}}  ></input></div>


                        </div>
                        <div class="form-group">
                                {{-- <div class="card-header"><h4 style=' display: inline-block;'>Type: </h4> </label> --}}
                                    <div class="card-header">
                                    <h4 style=' display: inline-block;'>Type:  &nbsp &nbsp &nbsp &nbsp <label >{{$a->type}} </label></h4>
                                </div>

                        </div>
                        @if(!($a->type=='admin'))
                        <div class="form-group">
                            <?php
                            $co=App\User::find( $a["parentid"]);
                            ?>
                            <div class="card-header"><h4  style=' display: inline-block;'>Responsible: &nbsp &nbsp &nbsp &nbsp  <label >{{$co->name}}</label></h4><br> <a href='#'>Email: {{$co->email}}</a>
                            </div>
                        </div>
                            @if(!($a->type=='coach'))
                            <div class="form-group">
                                    <?php
                                    $co=App\Team::find( $a["team_id"]);
                                    ?>
                                    <div class="card-header"><h4>Team:  <label ><?php echo $co["name"]; ?></label></h4>
                                    </div>
                            </div>
                            @endif
                        @endif
                        <div class="text-right">
                        {{Form::submit('Update', ['class'=>'btn btn-primary' ])}}
                        </div>
                    {!! Form::close() !!}

        </div>
    </div>
</div>
@endsection
