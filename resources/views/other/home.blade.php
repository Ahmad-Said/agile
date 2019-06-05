<div class="card">
        <?php
            $a=App\Team::find(auth()->user()->team_id);
            $b=auth()->user()->id;
           
            ?>
@if($a->id==1 )
            <div class="card-header"><h3>You have no team</h3>
            </div>
@else
    <div class="card-header"><h3>My Team: {{$a->name}} </h3>
                <small>ID {{$a->id}} </small>
    </div>
    
            <div class="card-body">
                    @if(count($team) > 0 )

                            <table class="table table-striped">
                                <tr>
                                    <th >ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Type</th>
                                </tr>
                                @foreach($team as $user)
                                @if( $user->id == $b )
                                    <tr class="table-success">
                                        @else
                                        <tr>
                                        @endif

                                        <td>{{ $user->id }}</td>
                                        <td>{{$user->name}}</td>
                                        <td>{{$user->email}}</td>
                                        <td>{{$user->type}}</td>
                                    </tr>
                                @endforeach

                            </table>
                    @endif
    @endif
            </div>

            <div class="form-group">
                    <?php 
                    $co=App\Project::find($a->project_id);
                    ?>
                    @if($co->id!=1)
                    <div class="card-header"><h3>Project:</h3><h5><b>Title:</b>    <label ><?php echo $co["title"]; ?></h5></label>
                                                        </h4><h5><b>Time Assigned:</b>    <label ><?php echo $co["updated_at"]; ?></h5></label>
                    </div>
                    @endif
            </div>
            <div class="form-group">
                    <?php 
                    $u=App\User::find($co->user_id);
                    ?>
                    <div class="card-header"><h3>Project Owner:</h3><h5><b>Name:</b>    <label ><?php echo $u['name']; ?></h5></label>
                    </h4><h5><b>Email:</b>    <label ><?php echo $u["email"]; ?></h5></label>
</div>
add later more information on current project if exist 
            </div>
        </div>