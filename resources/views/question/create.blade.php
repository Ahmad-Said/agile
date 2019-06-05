@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center ">
        <div class="col-md-8 " >
                <h1>Create Question</h1>
                <div class="card">
                        <div class="card-header">Options</div>
                
                        <div class="card-body">
                
                      <form name="form1" method="post" action="/question/create" >
                        @csrf
                            <table class="table table-striped">
                            
                                <tr>
                                    <th>
                                        {{Form::label('Number of Questions', 'Number of Questions')}}
                                        <th>
                                        {{ Form::label('Type','Type') }}
                                    </th><th></th>
                                </tr>
                                <tr>
                                    <td>
                                        {{ Form::number('count', $value = '' , ['min' => '1' ,'max'=>'10','class' => 'form-control', 'id' => 'number_count','required'])}}
                                    </td>
                                    <td> 
                                       
                                            <select id="type" name="type" class="form-control">
                                                    <option value=radiochoice>Radio Choice</option>
                                                    <option value=Radio>Lineaire Grading</option>
                                                    <option value=select>Selection menu</option>
                                            </select>
                                    
                                    </td>
                                    <td>    
                                        {{Form::submit('Refresh', ['class'=>'btn btn-primary' ])}}
                                    </td>
                                </tr>
                                </table>
                          
                                        </form>
                                @if(isset($data))
                                i exist 
                                {{ $data['type'] }}
                                @endif
                        </div>
 {{-- ------------------------------------------------------------------------------------------------ --}}     

 {!! Form::open(['action' => 'QuestionController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                 

 {{Form::label('body','Body',['class'=>'form-control'])}}
  {{Form::textarea('body', '', ['id' => 'article-ckeditor', 'class' => 'ckeditor', 'placeholder' => 'Body Text','required'=>'required'])}}                         
                                                
  <hr>
    @if(isset($data))
    
    <input type="hidden" name='type' value={{ $data['type'] }}>
    <input type="hidden" name='count' value={{ $data['count'] }}>
    
    <div class="card">
                        <div class="card-header">Options Choice Preview</div>
                
                        <div class="card-body">
                               <table class="table table-striped " > 

                            @if($data['type']=='radiochoice'|| $data['type']=='select')                           
                                            @for ($i=1;$i<=$data['count'];$i++ )
                                                <tr>@if($data['type']=='radiochoice')
                                                    <td>
                                                        
                                                        <input type="radio" class="[ btn btn-primary ]" name="members[]" id="fancy-checkbox-primary" autocomplete="off" >
                                                       
                                                    </td> @endif
                                                    <td>
                                                        {{ $i }}.
                                                    </td>
                                                    <td>
                                                        <input type="text" name="options[]"   class='form-control' placeholder="Option" required="required">
                                                        {{-- {{Form::text('options[]', '', ['class' => 'form-control', 'placeholder' => 'options'])}} --}}
                                                    </td>
                                                    </td>
                                                </tr>
                                           
                                            @endfor
                                        @if($data['type']=='select')
                                        <tr> <td align =center valign=middle><h3>Preview:<h3></td>
                                            
                                            <td colspan="2">
                                                <select class="form-control">
                                               
                                            @for ($i=1;$i<=$data['count'];$i++ )
                                            <option > Option {{$i}} </option>
                                            @endfor
                                            </select>
                                        </td>
                                        @endif
                
                            @elseif ($data['type']=='Radio')
                            
                            <tr>
                                @for ($i=1;$i<=$data['count'];$i++ )
                                 <td>
                                         {{ $i }}
                                    </td>
                                @endfor
                            </tr><tr>
                            @for ($i=1;$i<=$data['count'];$i++ )
                            
                                <td>
                                    <input type="radio" class="[ btn btn-primary ]" name="options[]" id="fancy-checkbox-primary" autocomplete="off" >
                                </td>
                            
                            @endfor
                       
                         
                        
                        @endif
                        
                        @else 
                      
                            <div class="alert alert-warning">
                            You need to fill options, then click on refresh button.
                            </div>
                        @endif
                    </table>
                   
                <div class="card">
                        <div class="card-header">
                            Label for graph axes (Optional)
                            </div>
                            <div class="card-body">
                                    <input type="text" name="label" class='form-control'   placeholder='Question ID by Default'>
                                </div></div>
                        <div class="text-center">
                             {{ Form::submit('Submit',['class'=>'btn btn-primary']) }}
                        </div>
                    
                
    {!! Form::close() !!}
</div>
</div>
</div>

</div>
</div>

@endsection