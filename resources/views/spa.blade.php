@php
$config = [
    'appName' => config('app.name'),
    'locale' => $locale = app()->getLocale(),
    'locales' => config('app.locales'),
    'githubAuth' => config('services.github.client_id'),
];
@endphp
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="{{ asset('css/feather/feather.min.css') }}">
  <link rel="stylesheet" href="{{ mix('dist/css/app.css') }}">
  <link rel="stylesheet" href="{{ asset('css/theme.min.css') }}">
  <link rel="icon" href="/img/icon.png" type="image/x-icon">
  <link rel="shortcut icon" href="/img/icon.png" type="image/x-icon">
  <title>SMART SCHOOL</title>
</head>
<body>
  <div id="app"></div>

  {{-- Global configuration object --}}
  <script>
    window.config = @json($config);
  </script>

  {{-- Load the application scripts --}}
  <script src="{{ mix('dist/js/app.js') }}"></script>
</body>
</html>
