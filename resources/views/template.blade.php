<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Agenda Telefônica - @yield('title')</title>
    <link rel="shortcut icon" href="favicon-16x16.png" type="image/x-icon">

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
