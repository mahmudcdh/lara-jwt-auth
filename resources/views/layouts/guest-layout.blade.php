<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="{{ asset('css/animate.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/fontawesome.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/progress.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/toastify.min.css') }}" />
    <script src="{{ asset('js/toastify-js.js') }}"></script>
    <script src="{{ asset('js/jquery-3.7.0.min.js') }}"></script>
    <script src="{{ asset('js/axios.min.js') }}"></script>
    <script src="{{ asset('js/config.js') }}"></script>
</head>
<body class="bg-zinc-900">

<div id="loader" class="LoadingOverlay d-none">
    <div class="Line-Progress">
        <div class="indeterminate"></div>
    </div>
</div>

<div class="container mx-auto">
    @yield('content')
</div>


</body>
</html>
