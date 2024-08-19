<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Agenda Telefônica - @yield('title')</title>
    <link rel="shortcut icon" href="favicon-16x16.png" type="image/x-icon">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:ital,wght@0,100..700;1,100..700&family=Roboto+Slab:wght@100..900&display=swap" rel="stylesheet">

    <style>
        html, body, #app {
            height: 100vh;
            width: 100%;
            margin: 0;
            background-color: #f0f3f8;
        }
    </style>

    @vite(['resources/js/app.js'])
</head>
<body>
    <div id="app">
        <!-- Vue.js components will be processed here. -->
        @yield('content')
    </div>
</body>
</html>
