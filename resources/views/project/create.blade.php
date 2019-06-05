@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center ">
        <div class="col-md-8 " >
                <h1>Create Project</h1>
                    {!! Form::open(['action' => 'ProjectController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                        <div class="form-group">
                            {{Form::label('Title', 'Title')}}
                            {{Form::text('title', '', ['class' => 'form-control', 'placeholder' => 'Name'])}}
                        </div>
                        <?php
                         $myid=auth::user()->id;
                            $query="SELECT * FROM users where parentid=$myid and type=?";    // to use $users = DB::select(query,[array of values])
                            // button to show when no availble user
                            $but="<a href='/register'><input type=\"button\" class=\"btn btn-primary\" value=\"Empty List ->>Register New User\"></button></a>";
                            ?>
                        <div class="form-group">
                                {{Form::label('Product Owner', 'Product Owner')}}
                                <?php $users=DB::select($query,['product owner']);?> 
                                    @if(count($users)>0)
                                        <select id="members" name="owner_id" class="form-control">
                                            @foreach ($users as $item)
                                                <option value={{$item->id}}>{!!"Name: ".$item->name."   ........   Email: ".$item->email!!}</option>
                                            @endforeach    
                                              </select>
                                    @else
                                    {!!$but!!}
                                    @endif
                            </div>

                            <div class="form-group">
                                {{-- {{Form::label('Team Assignment', 'Team Assignment')}} --}}
                                <?php
                                    // $teams=DB::select('SELECT * FROM teams where project_id=1');
                                    $teams=App\Team::where('project_id', '1')->where('id','!=','1')->where('user_id',$myid)->paginate(5);
                                 ?> 

                                
                                    {{-- @if(count($teams)>0)
                                        <select id="team" name="team" class="form-control">
                                            @foreach ($teams as $team)
                                                <option value={{$team->id}}>{!!"Name: ".$team->name."   ........   Email: ".$item->team:location!!}</option>
                                            @endforeach    
                                              </select> --}}
                            
                                        <div class="card-header">Team Assignment</div>

                                        <div class="card-body">
                                                
                                                     
                                                    @if(count($teams)>0)
                                                        <table class="table table-striped" >
                                                            <tr>
                                                                <th></th>
                                                                <th>ID</th>
                                                                <th>Name</th>
                                                                <th>location</th>
                                                            </tr>
                                                            @foreach ($teams as $item)
                                                                <tr>
                                                                    <td>
                                                                            <input type="radio" class="[ btn btn-primary ]" name="team" id="fancy-checkbox-primary" autocomplete="off" value={{$item->id}} >
                                                                    </td>
                                                                    <td>{{$item->id}}</td>
                                                                    <td>{{$item->name}}</td>
                                                                    <td>{{$item->location}}</td>
                                                                </tr>
                                                            @endforeach
                                                            {{$teams->links()}}
                                                        </table>
                                                        @else
                                                        <a href='/team/create'><input type="button" class="btn btn-primary" value="Empty List ->>Register New User"></button></a>
                                                        @endif

                                                    </div>
                                                
                                                        
                                    </div>
                        {{Form::submit('Submit', ['class'=>'btn btn-primary' ])}}
                        
                    {!! Form::close() !!}
                </div>
        </div>
    </div>
</div>
@endsection