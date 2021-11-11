<div class="card">
    <div class="card-header">My Teams</div>

    <div class="card-body">
            @if(count($teams) <= 0)
                    <p>You have no Teams</p>
                @else
                {!! Form::open(['action' => 'SetController@SendForm', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}

                <table class="table table-condensed" style="border-collapse:collapse;">

                        <thead>
                            <tr><th>&nbsp;</th>
                                <td></td>
                                <th>ID</th>
                                <th>Name</th>
                                <th>location</th>
                                <th>Current Project ID</th>

                            </tr>
                        </thead>
                        <?php $i=0;?>
                    @foreach($teams as $team)

                        <tbody>
                            <tr>
                                      <td data-toggle="collapse" data-target={{"#demo".$i}} class="accordion-toggle"><input type='button' class="btn btn-default" value='expand'></button></td>
                                <td>  <input type="checkbox" class="[ btn btn-primary ]" name="teams[]" id="fancy-checkbox-primary" autocomplete="off" value={{$team->id}} >
                                                          <small>  Send all this team</small></td>
                                      <td>{{$team->id}}</td>
                                <td>{{$team->name}}</td>
                                <td>{{$team->location}}</td>
                                <td>
                                    @if($team->project_id!=1)
                                    {{$team->project_id}}
                                    @else<a href='/project/create'> <button type="button" class="btn btn-warning">Free</button></a></td>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td colspan="12" class="hiddenRow">
                                    <div class="accordian-body collapse" id={{"demo".$i}}>
                                        <?php $members=$team->members; ?>
                                  <table class="table table-striped">
                                          {{-- <thead>
                                            <tr><td><a href="WorkloadURL">Workload link</a></td><td>Bandwidth: Dandwidth Details</td><td>OBS Endpoint: end point</td></tr>
                                            <tr><th>Access Key</th><th>Secret Key</th><th>Status </th><th> Created</th><th> Expires</th><th>Actions</th></tr>
                                          </thead>
                                          <tbody>


                                            <tr><td>access-key-1</td><td>secretKey-1</td><td>Status</td><td>some date</td><td>some date</td><td><a href="#" class="btn btn-default btn-sm">
                                      <i class="glyphicon glyphicon-cog"></i></a></td></tr> --}}

                                      <thead>

                                            <tr><th></th>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                               <th>Type<th>
                                            </tr>
                                          </thead>
                                          <tbody>
                                          @foreach ($members as $item)

                                            <tr>
                                                    <td>
                                                            <input type="checkbox" class="[ btn btn-primary ]" name="members[]" id="fancy-checkbox-primary" autocomplete="off" value={{$item->id}} >


                                                    </td>

                                                    <td>{{$item->id}}</td>

                                                    <td>{{$item->name}}</td>
                                                    <td>{{$item->email}}</td>
                                                    <td>{{$item->type}}</td>
                                              </tr>
                                              @endforeach
                                              @if($team->owner()!=null)
                                              <?php
                                               $item=$team->owner(); ?>
                                              <tr>
                                                <td>
                                                        <input type="checkbox" class="[ btn btn-primary ]" name="members[]" id="fancy-checkbox-primary" autocomplete="off" value={{$item->id}} >


                                                </td>

                                                <td>{{$item->id}}</td>

                                                <td>{{$item->name}}</td>
                                                <td>{{$item->email}}</td>
                                                <td>{{$item->type}}</td>
                                          </tr>
                                              @endif
                                          </tbody>

                                       </table>

                                  </div>
                                  <?php $i++;?>
                        @endforeach
                                  {{-- // coaches manage --}}
                                  <?php
                                        $myid=auth::user()->id;
                                        $members= $users=DB::select("SELECT * FROM users where parentid=$myid and type='coach'");
                                        // print_r($members);
                                  ?>
                                  @if(count($members)>0)
                                  <tbody>
                                    <tr>
                                              <td data-toggle="collapse" data-target={{"#demo".$i}} class="accordion-toggle"><input type='button' class="btn btn-default" value='expand'></button></td>
                                        <td>
                                                                  <small>  Coaches Collection</small></td>
                                              <td>#</td>
                                        <td>#</td>
                                        <td>#</td>
                                        <td>
                                            <button type="button" class="btn btn-success">Pro</button></td>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="12" class="hiddenRow">
                                            <div class="accordian-body collapse" id={{"demo".$i}}>

                                          <table class="table table-striped">
                                                  {{-- <thead>
                                                    <tr><td><a href="WorkloadURL">Workload link</a></td><td>Bandwidth: Dandwidth Details</td><td>OBS Endpoint: end point</td></tr>
                                                    <tr><th>Access Key</th><th>Secret Key</th><th>Status </th><th> Created</th><th> Expires</th><th>Actions</th></tr>
                                                  </thead>
                                                  <tbody>


                                                    <tr><td>access-key-1</td><td>secretKey-1</td><td>Status</td><td>some date</td><td>some date</td><td><a href="#" class="btn btn-default btn-sm">
                                              <i class="glyphicon glyphicon-cog"></i></a></td></tr> --}}

                                              <thead>

                                                    <tr><th></th>
                                                        <th>ID</th>
                                                        <th>Name</th>
                                                        <th>Email</th>

                                                    </tr>
                                                  </thead>
                                                  <tbody>
                                                  @foreach ($members as $item)

                                                    <tr>
                                                            <td>
                                                                    <input type="checkbox" class="[ btn btn-primary ]" name="members[]" id="fancy-checkbox-primary" autocomplete="off" value={{$item->id}} >


                                                            </td>

                                                            <td>{{$item->id}}</td>

                                                            <td>{{$item->name}}</td>
                                                            <td>{{$item->email}}</td>

                                                      </tr>
                                                      @endforeach
                                                  </tbody>

                                               </table>

                                          </div>
                                          <?php $i++;?>

                                          @endif


                                </table>


                    {{-- // add set list --}}
                    @if(auth::user()->mysets)
                    <div class="form-group">
                                {{Form::label('Title', 'Set Selection')}}
                        <select id="set" name="set_id" class="form-control">

                        @foreach (auth::user()->mysets as $item)
                            <option value={{$item->id}}>{!!"Name: ".$item->title!!}</option>
                        @endforeach
                        </select>
                    </div>
                    {{Form::submit('Send Set to Selected Users', ['class'=>'btn btn-primary' ])}}
                    {{Form::submit('Send Set to all Scrum Masters', ['class'=>'btn btn-primary','name'=>'sub' ])}}
                    {{Form::submit('Send Set to all developers', ['class'=>'btn btn-primary', 'name'=>'sub' ])}}
                    {!! Form::close() !!}
                    @else<a href='/set/create'>
                    <button type="button" class="btn btn-warning">Free</button></a></td>

                        <p> Add new set to be availble to send</p>
                    @endif
    </div>@endif
    {{-- for the the first opened if--}}
</div>
