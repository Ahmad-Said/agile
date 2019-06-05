@extends('layouts.style')
@section('bodysection')
<!-- Scripts -->
<script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
<script>
    CKEDITOR.replace( 'article-ckeditor' );
</script>

{{-- for jstree not working idk--}}
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jstree/3.3.7/themes/default/style.min.css" />
<script src="//cdnjs.cloudflare.com/ajax/libs/jstree/3.3.7/jstree.min.js"></script>

    <div id="app" >
        @if(Auth::user())
            @include('inc.navbar')
        @endif
            <br><br>
            <div class="container">
                <main class="py-4">
                    @include('inc.messages')
                    @yield('content')
                </main>
            </div>
    </div>
@endsection

