<nav class="navbar navbar-expand-lg">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="#">BitEx</a>

    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="navbar-nav ml-md-auto">
            @if (Auth::check())
              <li class="nav-item active">
                  <a class="nav-link" href="{{ route('account') }}">Account</a>
              </li>
              <li class="nav-item active">
                  <a class="nav-link" href="{{ route('logout') }}"
                  onclick="event.preventDefault();
                  document.getElementById('logout-form').submit();">
                  Logout
              </a>

              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  {{ csrf_field() }}
              </form>
              </li>
            @else
            <li class="nav-item">
                <a class="nav-link" href="{{ route('login') }}">Login</a>
            </li>
            @endif

            @if (Auth::check())
            <li class="nav-item">
                <a class="nav-link" href="?theme=dark">Dark</a>
            </li>
            @else
            <li class="nav-item">
                <a class="nav-link" href="?theme=light">Light</a>
            </li>
            @endif
        </ul>
    </div>
</nav>
