<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fuentes -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Stilos -->
        <style>
            body {
                margin: 0;
                font-family: 'Figtree', sans-serif;
                background-color: #121212;
                color: #ffffff;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                flex-direction: column;
            }
            .mensage {
                text-align: center;
                margin-bottom: 2rem;
            }
            .mensage h1 {
                font-size: 3rem;
                margin-bottom: 1rem;
            }
            .mensage p {
                font-size: 1.25rem;
                color: #bbbbbb;
            }
            .top-right-buttons {
                position: fixed;
                top: 1rem;
                right: 1rem;
                z-index: 10;
                text-align: right;
            }
            .top-right-buttons a {
                margin-left: 1rem;
                color: gray;
                text-decoration: none;
                font-weight: 600;
            }
            .top-right-buttons a:hover {
                color: darkgray;
            }
        </style>
    </head>
    <body class="antialiased">
        @if (Auth::check())
            <div class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
                <div class="top-right-buttons">
                    <a href="{{ url('/home') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Inicio</a>
                </div>
                <div class="mensage">
                    <h1>Bienvenido a la pagina principal</h1>
                    <p>Una Empresa S.A.</p>
                </div>
            </div>
        @else
            <script>window.location.href = "{{ route('login') }}";</script>
        @endif
    </body>
</html>
