<div class="card">
        <div class="card-header">Dashboard</div>
        <div class="card-body">
                @if(count($allusers) > 0)
                        <table class="table table-striped">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Type</th>
                                <th>Team</th>
                                <th> Parent ID </th>
                            </tr>
                            @foreach($allusers as $user)
                                <tr>
                                    <td>{{$user->id}}</td>
                                    <td>{{$user->name}}</td>
                                    <td>{{$user->email}}</td>
                                    <td>{{$user->type}}</td>
                                    <td>{{$user->team_id}}</td>
                                    <td>{{$user->parentid}}</td>
                                </tr>
                            @endforeach
                            {{$allusers->links()}}
                        </table>
                    @else
                        <p>You have no posts</p>
                    @endif
        </div>
    </div>
