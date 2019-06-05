@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center ">
        <div class="col-md-8 " >
                <h1>Create Team</h1>
                    {!! Form::open(['action' => 'TeamController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                        <div class="form-group">
                            {{Form::label('Name', 'Name')}}
                            {{Form::text('name', '', ['class' => 'form-control', 'placeholder' => 'Name'])}}
                        </div>
                        <div class="form-group">
                                {{Form::label('Location', 'Location')}}
                                {{Form::text('location', '', ['class' => 'form-control', 'placeholder' => 'Location'])}}
                            </div>
                        {{-- <div class="form-group">
                                {{Form::label('body','Body')}}
                                {{Form::textarea('body', '', ['id' => 'article-ckeditor', 'class' => 'ckeditor', 'placeholder' => 'Body Text'])}}

                        </div> --}}
                       {{--   <div class="form-group">
                            {{Form::file('cover_image')}}
                        </div> --}}
                        <?php
                            $myid=auth::user()->id;
                            $query="SELECT * FROM users where parentid=$myid and type=?";
                            // to use $users = DB::select(query,[array of values])
                            // button to show when no availble user
                            $but="<a href='/register'><input type=\"button\" class=\"btn btn-primary\" value=\"Empty List ->>Register New User\"></button></a>";

                            ?>
                        {{-- <div class="form-group">
                                {{Form::label('Product Owner', 'Product Owner')}}

                                        <select id="members" name="members[]" class="form-control">
                                          php balise here  $users=DB::select($query,['product owner']);?>
                                            @foreach ($users as $item)
                                                <option value={{$item->id}}>{!!"Name: ".$item->name."   ........   Email: ".$item->email!!}</option>
                                            @endforeach
                                              </select>
                            </div> --}}

                            <div class="form-group">
                                    {{Form::label('Scrum Master', 'Scrum Master')}}
                                   <?php $query=$query." and team_id=1";
                                        $users=DB::select($query,['scrum-master']);?>
                                   @if(count($users)>0)
                                            <select id="members" name="members[]" class="form-control">
                                                @foreach ($users as $item)
                                                    <option value={{$item->id}}>{!!"Name: ".$item->name."   ........   Email: ".$item->email!!}</option>
                                                @endforeach
                                                  </select>
                                    @else {!!$but!!}
                                    @endif
                                </div>

                                <div class="form-group">
                                        <div class="card-header">Developers</div>

                                        <div class="card-body">
                                                  <?php  //$users=App\User::where('type', 'developer')->paginate(1);
                                                        $users=DB::select($query,['developer']);
                                                  ?>

                                                      @if(count($users) > 0)
                                                        <table class="table table-striped" >
                                                            <tr>
                                                                <th></th>
                                                                <th>Name</th>
                                                                <th>Email</th>
                                                            </tr>
                                                            @foreach ($users as $item)
                                                                <tr>
                                                                    <td>
                                                                            <input type="checkbox" class="[ btn btn-primary ]" name="members[]" id="fancy-checkbox-primary" autocomplete="off" value={{$item->id}} >


                                                                    </td>
                                                                    <td>{{$item->name}}</td>
                                                                    <td>{{$item->email}}</td>
                                                                </tr>
                                                            @endforeach
                                                            {{-- {{$users->links()}} --}}
                                                        </table>
                                                        @else
                                                        {!!$but!!}
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
