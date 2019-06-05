@extends('layouts.app')

@section('content')
{{-- about desgin and javascript :
	instead of repeating code fully wirtten using php at coach home page
	i will show this page using jstree design as optional page job not main job
	so javascript only for selection 
	and  generating graph is pure php job  
	check About->references for more informations on jstree and pChart 
	--}}
	<img src="/storage/graph_images/final_result.png" style="width: 100%;">
<div class="container">
    <div class="row justify-content-center ">
        <div class="col-md-8 " >
                <?php
//   initial values
	// i have by request $set as the 
?>
			<div class="text-center">
				
							<h1>"{{$set->title}}"<h1>
									
             </div>
						 <button class="list-group-item" data-toggle="collapse" data-target="#demo5">
		
								Notes</button>
<div id="demo5" class="collapse">   
<li class="list-group-item">
Select groupes members then click refresh to compare
</li>
<li class="list-group-item">
Disabled users in group A mean they have pending Set Form
</li>
<li class="list-group-item">
Group B will not show those users 
</li>
<li class="list-group-item">
Refresh button page without selection in both groups do not change output graph
</li>
</div>
<br>


			 <form name="form1" method="post" action="/set/analysis" >
				@csrf
					<input type="hidden" name='set_id' value={{$set->id}} >
					<input name="raw" type="hidden" id="raw" value='fis'>			

		<div id="groupes">
			<ul>
			  <li id='GA' class="jstree-open" data-jstree='{"icon":"/storage/jtree_images/root.png"}'>Groupe A
				<ul> 
					{{-- open first groupe --}}
					{{--  { initialisation } --}}
					<?php 
						$a=$set->users_answered()->orderby('team_id')->get(); // we need to order by team id because
																																	// because we are counting a new team on every switch
						$iuser=$a[0];
						$teamid=$iuser->team_id;
						$teamchange=0; 
					?>
					
					
					<li id={{'TA'.$teamid}} data-jstree='{"icon":"/storage/jtree_images/gro.png"}'>{{App\Team::find($iuser->team_id)->name}}
							<ul>	{{--  on every team change print a team 
							other wise continue printing--}}
				  @foreach($a as $user)
				  			<?php // check if team has changed
							if($user->team_id!=$teamid)
								{
									$teamchange=1; 
								}
							$teamid = $user->team_id;
							
							?>
					@if($teamchange)
							</ul>
							</li>
							<li id={{'TA'.$user->team_id}} data-jstree='{"icon":"/storage/jtree_images/gro.png"}' >
								{{-- i don't care about team name or team id  --}}
									{{"$user->team_id"}}: 
								{{App\Team::find($user->team_id)->name}}
							<ul>
							<?php $teamchange=0; ?>
					@endif

						{{-- print here the members who answered and who not show them disabled --}}
						@if($user->pivot->status=='done') 
									@if($user->type=='developer')
									<li id = {{'A'.$user->id}} value={{'A'.$user->id}}  data-jstree='{"icon":"/storage/jtree_images/final_dev2.png"}'> {{$user->id}}:  {{$user->name}} </li>
									@elseif($user->type=='scrum-master')
									<li id = {{'A'.$user->id}} value={{'A'.$user->id}}  data-jstree='{"icon":"/storage/jtree_images/final_scrum2.png"}'> <a href='#' class="jstree-clicked" > {{$user->id}}:  {{$user->name}} </a></li>
									@else
									<li id = {{'A'.$user->id}} value={{'A'.$user->id}}  data-jstree='{"icon":"/storage/jtree_images/final_owner.png"}'>  {{$user->id}}:  {{$user->name}}</li>
									
									@endif
						@else
									@if($user->type=='developer')
									<li id = {{'AD'.$user->id}} value={{'A'.$user->id}}  data-jstree='{"disabled":true,"icon":"/storage/jtree_images/final_dev2.png"}'> {{$user->id}}:  {{$user->name}} </li>
									@elseif($user->type=='scrum-master')
									<li id = {{'AD'.$user->id}} value={{'A'.$user->id}}  data-jstree='{"disabled":true,"icon":"/storage/jtree_images/final_scrum2.png"}'> {{$user->id}}:  {{$user->name}}</li>
									@else
									<li id = {{'AD'.$user->id}} value={{'A'.$user->id}}  data-jstree='{"disabled":true,"icon":"/storage/jtree_images/final_owner.png"}'>  {{$user->id}}:  {{$user->name}}</li>
									
									@endif
				
						@endif 
				  @endforeach
							</ul>
							</li> 
							{{-- close the last team --}}
				
				  
				</ul>
			  </li> 
			  {{-- closing root groupe A --}}

			{{-- </ul>
			closing main ul
		</div> --}}
			
			{{-- end first groupe --}}

			

			{{-- Group 2 begin --}}
		{{-- <div id="groupeB">
			<ul> --}}
				
					<li id='GB' class="jstree-clicked" data-jstree='{"icon":"/storage/jtree_images/root.png"}'>Groupe B
							<ul> 
								{{-- open first groupe --}}
								{{--  { initialisation } --}}
								<?php   //$a=set->users_answered;
								$ind=0;
								foreach($a as $i){
									if($i->pivot->status=='done')
										{
											$iuser=$i;
											
											break; // in $ind there is now the index of the iuser in $a
											
										}
										$ind++;
								}
									$teamid=$iuser->team_id;
									$teamchange=0; 
								?>
								
								
								<li id={{'TB'.$teamid}}  data-jstree='{"icon":"/storage/jtree_images/gro.png"}'>{{App\Team::find($iuser->team_id)->name}}
										<ul>	{{--  on every team change print a team 
										other wise continue printing--}}
								@for(;$ind<count($a);$ind++)
											<?php // check if team has changed
											$user=$a[$ind];
										if($user->team_id!=$teamid && $user->pivot->status=='done')
											{
												$teamchange=1; 
												$teamid = $user->team_id; // change the last group only if found done also 
											}
										
										?>
								@if($teamchange)
										</ul>
										</li>
										<li id={{'TB'.$user->team_id}} data-jstree='{"icon":"/storage/jtree_images/gro.png"}'>
											{{-- i don't care about team name or team id  --}}
												{{"$user->team_id"}}: 
											{{App\Team::find($user->team_id)->name}}
										<ul>
										<?php $teamchange=0; ?>
								@endif
			
									{{-- print here the members who answered and who not show them disabled --}}
									@if($user->pivot->status=='done') 
													@if($user->type=='developer')
													<li id = {{'B'.$user->id}} value={{'A'.$user->id}}  data-jstree='{"icon":"/storage/jtree_images/final_dev2.png"}'> {{$user->id}}:  {{$user->name}} </li>
													@elseif($user->type=='scrum-master')
													<li id = {{'B'.$user->id}} value={{'A'.$user->id}}  data-jstree='{"icon":"/storage/jtree_images/final_scrum2.png"}'> <a href='#' class="jstree-clicked" > {{$user->id}}:  {{$user->name}} </a></li>
													@else
													<li id = {{'B'.$user->id}} value={{'A'.$user->id}}  data-jstree='{"icon":"/storage/jtree_images/final_owner.png"}'>  {{$user->id}}:  {{$user->name}}</li>
													
													@endif
									@endif 
								@endfor
										</ul>
										</li> 
										{{-- close the last team --}}
							
								
							</ul>
							</li> 
			  {{-- group 2 end --}}
			</ul>
		  </div>

		









<div class="text-center">
		<p id="demo"></p>
				</div>
				
<div class="text-center">
				<a href="/set/{{$set->id}}" class="btn btn-primary text-center" >Review Set</a>
				
				{{Form::submit('Refresh', ['class'=>'btn btn-primary' ])}}
				</div>
			</form>



				

<script>
		$(function() {
$('#groupes').jstree({
	'plugins':["checkbox","unique","state","wholerow"],
	"state" : { "key" : "state_demos" } // conserve opened state

	
});
$('button').on("click", function () {
	var instance = $('#groupes').jstree(true);
	instance.deselect_all();
	instance.select_node('1');
});

});
</script>

		<script>
		// listen for event

		$('#groupes').on("changed.jstree", function (e, data) {
		console.log(data.selected);
		var i, j, r = [];
			for(i = 0, j = data.selected.length; i < j; i++) {
			// r.push(data.instance.get_node(data.selected[i]).text);
			r.push(data.instance.get_node(data.selected[i]).id);
			}
		// document.getElementById("demo").innerHTML = 'Selected: '+ r.toString();
		document.getElementById("raw").value =r.toString();
		//   document.getElementById("demo").value = 'Selected: '+ r.toString();
		});
	</script>

@endsection