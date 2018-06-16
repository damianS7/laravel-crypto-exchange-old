<nav class="navbar navbar-expand-lg">
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
		<span class="navbar-toggler-icon"></span>
	</button>
	<a class="navbar-brand" href="#">BitEx</a>

	<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		<ul class="navbar-nav ml-md-auto">
			@if (Auth::check())
			<li class="nav-item">
				<span class="navbar-text">Logged as {{ Auth::user()->email }}</span>
			</li>

			<li class="nav-item">
				<a class="nav-link" href="{{ route('account') }}">Account</a>
			</li>

			<li class="nav-item">
				<a class="nav-link" href="{{ route('logout') }}"
				onclick="event.preventDefault();
				document.getElementById('logout-form').submit();">Logout</a>

				<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
					{{ csrf_field() }}
				</form>
			</li>

			@else
			<li class="nav-item">
				<a class="nav-link" href="{{ route('login') }}">Login</a>
			</li>
			@endif

			@if (Cookie::get('theme') == 'light')
			<li class="nav-item">
				<a class="nav-link" href="{{ route('change-theme', '') }}">Light</a>
			</li>
			@else
			<li class="nav-item">
				<a class="nav-link" href="{{ route('change-theme', '') }}">Dark</a>
			</li>
			@endif

		</ul>
	</div>
</nav>
