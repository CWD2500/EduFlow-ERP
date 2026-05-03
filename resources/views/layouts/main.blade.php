<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Exame Management </title>
    {{-- CSS Bootstrap 5  --}}
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
   
  </head>
  <body>

    {{-- Content --}}
      @yield('content')
    {{-- End Content  --}}
    
    <script src="{{ asset('js/bootstrap.min.js') }}" ></script>
  </body>
</html>