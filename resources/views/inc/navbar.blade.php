

<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top" style="padding-left:5em; padding-right:5em">
  
  <a class="navbar-brand" href="/home" >{{ config('app.name', 'Laravel') }}</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarsExampleDefault">
    {{-- style="padding-left: 500px;" --}}
    <ul class="navbar-nav mr-auto" > 
      @if(Auth::user()->type=='admin')
        @include('admin.nav')
      @else
        @if(Auth::user()->type=='coach')
          @include('coach.nav')
        @else
          @include('other.nav')
        @endif
      @endif
    </ul>

    {{-- <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
      <button class="btn btn-secondary my-2 my-sm-0" type="submit">Search</button>
    </form> --}}

    <ul class="navbar-nav ml-auto">
        <!-- Authentication Links -->
        @guest
            <li class="nav-item">
                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
            </li>
            @if (Route::has('register'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                </li>
            @endif
            
        @else
        

            <li class="nav-item dropdown">
                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    {{ Auth::user()->name }} <span class="caret"></span>
                </a>

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="/home">
                      Home
                    </a>
                    <a class="dropdown-item" href="/profile">
                      Profile
                    </a>
                    <a class="dropdown-item" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>
                    
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </li>
        @endguest
        <li class="nav-item">
                <a class="nav-link" href="/about"> About us</a>
        </li>
    </ul>
  </div>
</nav>
