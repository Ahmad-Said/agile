@extends('layouts.app')

@section('content')
<div class="text-center">
<div class="form-group">

    <div class="card-header">
        <h4>Name: </h4> <h5> <label >Mohamad Naji</label></h5>
        <h4>Student ID: </h4> <h5> <label >92105</label></h5>
    </div>

    <div class="card-header">
            <h4>Name: </h4> <h5> <label >Ahmad Said</label></h5>
            <h4>Student ID: </h4> <h5> <label >88671</label></h5>
            
    </div>
    <div class="card-header">
        <h4> login informatin:</h4> <h5> <label >mohamad.naji@ahmad.said.com</label></h5>
        <h4>All Password: </h4> <h5> <label >123321</label></h5>
        
</div>
                  
          <div class="card-header">
            <h4>Represented To: </h4> <h5> <label >Dr. Ali Ghrayeb  -  Dr.Mohamad Hamze</label></h5>

    </div>     
<br>
<div>
        @if(Auth::guest())
        <a href='/'>
        @else
        <a href={{ URL::previous() }}>
        @endif
            <button style="float: left;" class="bg-transparent text-grey-darkest font-bold uppercase tracking-wide py-3 px-6 border-2 border-grey-light hover:border-grey rounded-lg">
                   Go Back
            </button>
        </a>
        
        <a href="/references">
         <button style="float: right;" class="bg-transparent text-grey-darkest font-bold uppercase tracking-wide py-3 px-6 border-2 border-grey-light hover:border-grey rounded-lg">
                References
         </button>
     </a>
<div>
<div class='text-center'>
   <a href="/home">
    <button style="float: center;" class="bg-transparent text-grey-darkest font-bold uppercase tracking-wide py-3 px-6 border-2 border-grey-light hover:border-grey rounded-lg">
        Go Home
    </button>
</a>


</div>     

@endsection