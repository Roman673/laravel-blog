<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Laravel') }} | @yield('title')</title>

  <!-- Styles -->
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">

  <style>
    h1, h2 { font-family: serif;}
    a, li { font-size: 1.2rem; }
    p { font-size: 1.3rem; }
    @yield('style')
  </style>
</head>
<body>
  @include('common.navbar')

  @include('common.messages')

  <main>
    @yield('content')
  </main>
  
  <footer class="container">
    <hr>
    <p><small>&copy; Roman Lisicyn 2018</small></p>
  </footer>

  <!-- Scripts -->
  <script src="{{ asset('js/app.js') }}"></script>
  <script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
  <script>
      CKEDITOR.replace('ckeditor');
  </script>
</body>
</html>
