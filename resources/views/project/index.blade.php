@extends('layouts.app')

@section('content')

<div class="card">
    <div class="card-header">Project List</div>

    <div class="card-body">
            @if(count($data) > 0)
                    <table class="table table-striped">
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Status</th>
                            <th>Team ID</th>
                            <th>Owner ID</th>
                            <th>Time Start</th>
                            <th>Time Finish</th>
                            <th></th>
                        </tr>
                        @foreach($data as $project)
                            <tr>
                                <td>{{$project->id}}</td>
                                <td>{{$project->title}}</td>
                                @if($project->status=='pending')
                                <td><button type="button" class="btn btn-warning">{{ $project->status }}</button></td>
                                @else
                                <td><button type="button" class="btn btn-success">{{ $project->status }}</button></td>
                                @endif
                                <td>{{$project->team_id}}</td>
                                <td>{{$project->user_id}}</td>
                                <td>{{$project->created_at}}</td>
                                <td>
                                    {{$project->updated_at}}</td>
                               
                                {{-- <td><a href="/project/{{$project->id}}/edit" class="btn btn-default">Edit</a></td> --}}
                                <td>
                                    {{-- {!!Form::open(['action' => ['PostsController@destroy', $post->id], 'method' => 'POST', 'class' => 'pull-right'])!!} --}}
                                 
                                 @if(auth::user()->type=='coach')
                                    @if($project->status!='Finished')
                                    {!! Form::open(['action' => ['ProjectController@update',$project->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                                    {{Form::hidden('_method','PUT')}}    
                                    {{Form::submit('Mark as Finished', ['class' => 'btn btn-success'])}}
                                    {!!Form::close()!!}
                                    @endif
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        {{$data->links()}}
                    </table>
                @else
                    <p>There are no Projects</p>
                @endif
                @if(auth::user()->type==='coach')
                <div class="text-center">
                <a href="/project/create" class="btn btn-primary text-center" >Create New Project</a>
                </div>
                @endif
    </div>
</div>
@endsection