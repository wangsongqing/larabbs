<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>@yield('title', '搬砖工') - {{ setting('site_name', 'PHP Laravel Mysql Redis 程序员') }}</title>
  <meta name="description" content="@yield('description', setting('seo_description', '松松程序员 社区。'))" />
  <meta name="keywords" content="@yield('keyword', setting('seo_keyword', 'Laravel,社区,论坛,开发者论坛,PHP,Mysql,Redis,程序员'))" />
  <!-- Styles -->
  <link href="{{ mix('css/app.css') }}?8765" rel="stylesheet">
  @yield('styles')
</head>

<body>
<div id="app" class="{{ route_class() }}-page">

  @include('layouts._header')

  <div class="container">

    @include('shared._messages')

    @yield('content')

  </div>

  @include('layouts._footer')
</div>
<!-- Scripts -->
<script src="{{ mix('js/app.js') }}?9888"></script>
@yield('scripts')
</body>

</html>
