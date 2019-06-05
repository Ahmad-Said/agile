@extends('layouts.app')

@section('content')

<div class="card">
    <div class="card-header"><h2> My Questions Sets<h2></div>
{{-- //      here will be all set stored in my table variable --}}
<?php 
    $user=auth::user();
    $iscoach=$user->type==='coach';
?>
    <div class="card-body">
        @if($iscoach)
            <div class="text-right">
                
                    <a href="/set/create" class="btn btn-primary text-center" >Create New Set</a>
                <br>
                </div>
        @endif
            @if(count($mysets) > 0)
      <br>
                    <table class="table table-striped">
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Owner ID</th>
                            @if($iscoach)
                            <th>Creation Time </th>
                            <th>Last Time Updated</th>
                            <th colspan="3"></th>
                            @else
                            <th> Time Received</th>
                            <th>Last Time Submitted</th>
                            <th> Status</th>
                            <th>Action</th>
                            @endif
                          
                        </tr>
                        @foreach($mysets as $s)
                            <tr>
                                <td>{{ $s['id'] }}</td>
                                <td>{{ $s['title'] }}</td>
                                <td>{{ $s['user_id'] }}</td>
                                @if($iscoach)
                                <td>{{ $s['created_at'] }}</td>
                                <td>{{ $s['updated_at'] }}</td>
                                @else
                                <td>{{ $s->pivot['created_at'] }}</td>
                                <td>{{  $s->pivot['updated_at'] }}</td>
                                    
                                    {{-- @if($s->pivot['created_at'] !=$s->pivot['updated_at']) --}}
                                    @if($s->pivot['status'] =='done' )
                                     <td><button type="button" class="btn btn-success">Done</button></td>
                                     <td><a href="/set/showform/{{ $s['id'] }}"><button type="button" 
                                        class="btn btn-info">Update My Answer</button></a></td>
                                     @else
                                     <td><button type="button" class="btn btn-success">Pending</button></td>
                                     <td><a href="/set/showform/{{ $s['id'] }}"><button type="button" 
                                        class="btn btn-info">Answer</button></a></td>
                                    @endif
                                @endif
                                @if($iscoach)
                                <td>
                                        <a href="/set/analysis/{{ $s['id'] }}"><button type="button" class="btn btn-success">Analysis</button></a></td>
                                    <td><a href="/set/{{ $s['id'] }}"><button type="button" class="btn btn-info">View</button></a></td>
                                    <td>
                                            {!!Form::open(['action' => ['SetController@destroy', $s->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
                                                {{Form::hidden('_method', 'DELETE')}}
                                                {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
                                            {!!Form::close()!!}
                                        </td>
                                @endif
                                
                            </tr>
                        @endforeach
                    </table>
                @else
                    <p>There are no Set available</p>
                @endif
    </div>
</div>
@endsection