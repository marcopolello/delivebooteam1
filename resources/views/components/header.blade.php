<header id="header-search">
  <div class="container">

    <div class="components-container">
      @include('components.ham')
      @include('components.search-bar')
    </div>

    <a href="{{route('index')}}" class="logo">
      <img src="{{asset('storage/img/deliveroo-logo.svg')}}" alt="">
    </a>

  </div>
</header>
