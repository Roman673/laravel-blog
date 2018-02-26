<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Blog') }} | {{ $title }}</title>

  @include('layouts.styles')
</head>
<body class="bg-white">
<header>
  @include('layouts.navbar')

  @if (Request::path() != '/')
    @include('layouts.breadcrumbs')
  @endif
</header>

<main class="container">
  @include('layouts.messages')
    
  @yield('content')
</main>

@include('layouts.footer')  

@include('layouts.scripts')
</body>
</html>
