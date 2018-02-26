<nav aria-label="breadcrumb">
  <div class="container">
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="{{ route('index') }}">
          <i class="fa fa-home" style="font-size:24px"></i>
        </a>
      </li>
      @yield('breadcrumb')
    </ol>
  </div>
</nav>
