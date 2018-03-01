<nav aria-label="breadcrumb">
  <div class="container">
    <ol class="breadcrumb">
    @foreach ($breadcrumbs as $breadcrumb)
      @if ($breadcrumb[1])
      <li class="breadcrumb-item"><a href="{{ url($breadcrumb[1]) }}">{{ $breadcrumb[0] }}</a></li>
      @else
      <li class="breadcrumb-item active">{{ $breadcrumb[0] }}</li>
      @endif
    @endforeach
    </ol>
  </div>
</nav>
