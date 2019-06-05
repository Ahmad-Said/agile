@extends('layouts.app')

@section('content')

<div class="card">
    <div class="card-header"><h2>Set information</h2></div>

            <?php
                // $ques=$set->myquestions::orderby(id)->paginate(5);
                // $users=User::orderby('id')->paginate(5);
                // $quest=App\Question::orderby('id')->where('set_id',$set->id)->paginate(5);
                $quest=App\Question::orderby('id')->where('set_id',$set->id)->get(); // wihtout paginate
                
                // $quest=DB::select("SELECT * FROM questions where set_id = $set->id");
                $generate=-1;
            ?>
            <br>
            {!! Form::open(['action' => 'SetController@storeanswer', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
        <input type="hidden" name='set_id' value={{$set->id}} >
            <div class="card-body">
@foreach($quest as $data)
              <br>  <?php $generate++;?>
<div class="card-header">
                                <tr><th colspan=3> <h4> {!! $data['body'] !!}</h4></th></tr>
</div>
                     @if($data['type']=='radiochoice' )
                     
                         <?php $x=explode(";",$data['options']);  ?>  

                                 <ul class="list-group">                        
                                     @for ($i=1;$i<=count($x);$i++ )
                                    

                                             <li class="list-group-item">
                                                 <input type="radio" class="[ btn btn-primary ]" name="response[{{$generate}}]" 
                                                         id="fancy-checkbox-primary"  required="required"
                                                         value='{{$i}}'
                                                         >
                                                
                                                 <?php  echo $x[$i-1];
                                                 ?>
                                                 {{-- <input type="label" name="options[]"   class='form-control' placeholder='options' required="required" value=> --}}

                                             </li>
                                       
                                     @endfor
                                </ul>
         
                         @elseif($data['type']=='select')
                         <?php $x=explode(";",$data['options']);  ?>  
                         <select name="response[{{$generate}}]" 
                           required="required"  class="form-control">
                            @for ($i=1;$i<=count($x);$i++ )
                                <option value='{{$i}}' >
                                
                                        <?php  echo $x[$i-1];
                                        ?>
                                </option>
                            @endfor
                         </select>

                    @elseif ($data['type']=='Radio')
                     <table class="table table-condensed " ><tr>
                      @for ($i=1;$i<=$data['options'];$i++ )
                          <td align="center">
                                <input type="radio" class="[ btn btn-primary ]" name="response[{{$generate}}]" 
                                 id="fancy-checkbox-primary"  required="required"
                                 value='{{$i}}'
                                 >
                               
                          </td>
                         @endfor
                        </tr>
                        
                     @for ($i=1;$i<=$data['options'];$i++ )
                     
                         <td align="center">
                                {{ $i }}
                         </td>
                     @endfor
                        </tr>
                    </table>
                 @endif 
                                
        @endforeach  
    
        <div class="text-center">
        {{Form::submit('Submit', ['class'=>'btn btn-primary' ])}}
               </div>
    {!! Form::close() !!}
                </div >       
</div>
@endsection