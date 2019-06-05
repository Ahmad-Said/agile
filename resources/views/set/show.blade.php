@extends('layouts.app')

@section('content')

<div class="card">
    <div class="card-header"><h2>Set Title: {{$set->title}} </h2>
        <small> ID: {{$set->id}} </small>
        </div>

            <?php
                // $ques=$set->myquestions::orderby(id)->paginate(5);
                // $users=User::orderby('id')->paginate(5);
                // $quest=App\Question::orderby('id')->where('set_id',$set->id)->paginate(5);
                $quest=App\Question::orderby('id')->where('set_id',$set->id)->get(); // wihtout paginate
                $iscoach=auth::user()->type=='coach';
                // echo $iscoach;
                // $quest=DB::select("SELECT * FROM questions where set_id = $set->id");
                $generate=-1;
            ?>
            <br>
            {{-- {!! Form::open(['action' => 'QuestionController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!} --}}

         <div class="text-center">
                    <?php
                        session(['set_id' => $set->id]);
                    ?>
                    <a href="/question/create" class="btn btn-primary text-center" >Add New Question</a>
         </div>
         <div class="card-body">
@foreach($quest as $data)
              <br>  <?php $generate++;?>

              {!!Form::open(['action' => ['QuestionController@destroy', $data->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
                                        {{Form::hidden('_method', 'DELETE')}}
                                        {{Form::submit('Delete This Question', ['class' => 'btn btn-danger'])}}
                                    {!!Form::close()!!}
<div class="card-header">

                                <tr><th colspan=3> <h4> {!! $data['body'] !!} </h4> <small>ID: {{$data->id}} {{$data->label}}  </small>
                                   
                                    
                                    
                                
                                
                                </th>
                              
                                        
                              
                            </tr>
</div>
                     @if($data['type']=='radiochoice')
                    <ul class="list-group">   
                         <?php $x=explode(";",$data['options']);  ?>                        
                                     @for ($i=1;$i<=count($x);$i++ )
                                    
                                             <li class="list-group-item">
                                                 <input type="radio" class="[ btn btn-primary ]" name="response[{{$generate}}]" id="fancy-checkbox-primary" autocomplete="off" >
                                                
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
                          <td style="text-align:center">
                                <input type="radio" class="[ btn btn-primary ]" name={{"response".$generate}}  id="fancy-checkbox-primary" autocomplete="off" >
                               
                          </td>
                         @endfor
                        </tr>
                        
                     @for ($i=1;$i<=$data['options'];$i++ )
                     
                         <td style="text-align:center">
                                {{ $i }}
                         </td>
                     @endfor
                        </tr>
                    </table>
                 @endif 
                                
        @endforeach  
    
                  

    {{-- {!! Form::close() !!} --}}
                </div >       
</div>
@endsection