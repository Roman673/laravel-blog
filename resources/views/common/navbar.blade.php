<nav class="navbar navbar-expand-md navbar-light bg-light">
  <div class="container">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="{{ url('/') }}">
      {{ config('app.name', 'Laravel') }}
    </a>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <!-- Left Side Of Navbar -->
      <ul class="navbar-nav mr-auto">
        <li class="nav-item">
          <a class="nav-link @if(Route::currentRouteName() == 'index') active @endif" href="{{ route('index') }}">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link @if(Route::currentRouteName() == 'posts.index') active @endif" href="{{ route('posts.index') }}">Posts</a>
        </li>
      </ul>

      <!-- Right Side Of Navbar -->
      <ul class="navbar-nav ml-auto">
      <!-- Authentication Links -->
        @guest
        <li>
          <a class="nav-link @if(Route::currentRouteName() == 'login') active @endif" href="{{ route('login') }}">
            Login
          </a>
        </li>
        <li>
          <a class="nav-link @if(Route::currentRouteName() == 'register') active @endif" href="{{ route('register') }}">
            Register
          </a>
        </li>
        @else
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  {{ Auth::user()->name }} <span class="caret"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="{{ route('dashboard') }}">Dashboard</a>
              <a class="dropdown-item" href="{{ route('posts.create') }}">Create post</a>
              <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Logout
              </a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
              </form>
            </div>
          </li>
        @endguest
      </ul>
    </div>
  </div>
</nav>

