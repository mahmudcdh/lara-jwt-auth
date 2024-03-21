<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <title>@yield('title')</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="{{ asset('css/animate.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/fontawesome.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/progress.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style2.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/toastify.min.css') }}" />

    <script src="{{ asset('js/toastify-js.js') }}"></script>
    <script src="{{ asset('js/jquery-3.7.0.min.js') }}"></script>
    <script src="{{ asset('js/axios.min.js') }}"></script>
    <script src="{{ asset('js/config.js') }}"></script>

</head>
<body class="text-gray-800 font-inter">

<div id="loader" class="LoadingOverlay d-none">
    <div class="Line-Progress">
        <div class="indeterminate"></div>
    </div>
</div>

    @include('components.dashboard.sidebar')

<main class="w-full md:w-[calc(100%-256px)] md:ml-64 bg-gray-50 min-h-screen transition-all main">

    @include('components.dashboard.navbar')

    <div class="container mx-auto">
        @yield('content')
    </div>
</main>

<script src="https://unpkg.com/@popperjs/core@2"></script>

<script src="{{ asset('js/datatables.min.js') }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.1.1/flowbite.min.js"></script>
<script src="{{ asset('js/script.js') }}"></script>

</body>
</html>
