{{-- HEADER --}}
<header id='header-no-search'>
    <div class="container">
  
        {{-- menu --}}
            <ham-menu
                :login = "'{{ route("login") }}'"
                :register = "'{{ route("register") }}'"
                :dashboard = "'{{ route("dashboard") }}'"
                :logout = "'{{ route("logout") }}'"
                :user = "'{{ Auth::user() }}'"
                >
            </ham-menu>
  
        {{-- logo --}}
        <a href="{{route('index')}}" class="logo">
          <img src="{{asset('storage/img/deliveroo-logo.svg')}}" alt="">
      </a>
      
    </div>
  </header>
  