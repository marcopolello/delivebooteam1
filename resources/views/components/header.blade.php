{{-- HEADER --}}
<header id="header-search">
  <div class="container">

      {{-- menu --}}
        <ham-menu
            :welcome = "'{{ route("index") }}'"
            :login = "'{{ route("login") }}'"
            :register = "'{{ route("register") }}'"
            :dashboard = "'{{ route("dashboard") }}'"
            :logout = "'{{ route("logout") }}'"
            :user = "'{{ Auth::user() }}'"
            
            {{-- status --}}
            :welcome_s = "'{{Request::routeIs('index')}}'"
            :login_s = "'{{Request::routeIs('login')}}'"
            :register_s = "'{{Request::routeIs('register')}}'"
            :dashboard_s = "'{{Request::routeIs('dashboard')}}'"
            >
        </ham-menu>
  
      @include('components.search-bar')

      {{-- logo --}}
      <a href="{{route('index')}}" class="logo">
        <img src="{{asset('storage/img/deliveroo-logo.svg')}}" alt="">
    </a>

  </div>
</header>
