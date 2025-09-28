<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    📚Saber+
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('books.catalogo') }}">{{ __('Consultar Catalogo') }}</a>
                        </li>
                        @if (Session::has('cliente_id'))
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Prestamos
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route('prestamos.index') }}">Ver Prestamos</a></li>
                                    <li><a class="dropdown-item" href="{{ route('deudas.index') }}">Ver Multas</a></li>
                                </ul>
                            </li>
                        @endif
                        @auth
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Gestion de servicios
                                </a>
                                <ul class="dropdown-menu">
                                    <li><span class="dropdown-item-text"><strong>Clientes</strong></span></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="{{ route('clientes.create') }}">Registrar Cliente</a></li>
                                    <li><a class="dropdown-item" href="{{ route('clientes.index') }}">Lista de Clientes</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><span class="dropdown-item-text"><strong>Libros</strong></span></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="{{ route('books.create') }}">Registrar Libro</a></li>
                                    
                                    <li><hr class="dropdown-divider"></li>
                                    <li><span class="dropdown-item-text"><strong>Prestamos</strong></span></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="{{ route('pedidos.index') }}">Lista de Solicitudes</a></li>
                                    <li><a class="dropdown-item" href="{{ route('prestamos.returns.index') }}">Gestionar Devoluciones</a></li>
                                </ul>
                            </li>
                        @endauth
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @if (Auth::check() || Session::has('cliente_id'))
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    🔔
                                </a>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    @if (Session::has('cliente_id'))
                                        @if ($lastPrestamo)
                                            @php
                                                $statusClass = 'text-secondary'; // Default neutral
                                                switch ($lastPrestamo->estado_solicitud) {
                                                    case 'Pendiente':
                                                        $statusClass = 'text-info';
                                                        break;
                                                    case 'Aprobado':
                                                        $statusClass = 'text-success';
                                                        break;
                                                    case 'Rechazado':
                                                    case 'Cancelado':
                                                        $statusClass = 'text-muted';
                                                        break;
                                                    case 'Atrasado':
                                                        $statusClass = 'text-warning';
                                                        break;
                                                    case 'Devuelto':
                                                        $statusClass = 'text-primary';
                                                        break;
                                                }
                                            @endphp
                                            <a class="dropdown-item {{ $statusClass }}" href="{{ route('prestamos.index') }}">
                                                Tu último préstamo fue: {{ $lastPrestamo->estado_solicitud }}
                                            </a>
                                        @else
                                            <a class="dropdown-item" href="#">
                                                No tienes préstamos registrados.
                                            </a>
                                        @endif

                                        @if ($hasPendingDeudas)
                                            <a class="dropdown-item text-danger" href="{{ route('deudas.index') }}">
                                                Tienes Multas por pagar, pasa por caja!
                                            </a>
                                        @endif
                                    @else
                                        <a class="dropdown-item" href="#">
                                            Sin notificaciones nuevas.
                                        </a>
                                    @endif
                                </div>
                            </li>
                        @endif

                        @if (!Auth::check() && !Session::has('cliente_id'))
                            @if (Route::has('login') && Route::currentRouteName() !== 'login')
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register') && Route::currentRouteName() !== 'register' && Route::currentRouteName() !== 'cliente.login')
                                <li class="nav-item d-none">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            @if (Session::has('cliente_id'))
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Session::get('cliente_nombre') }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('cliente.logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form-cliente').submit();">
                                        {{ __('Cerrar Sesion') }}
                                    </a>

                                    <form id="logout-form-cliente" action="{{ route('cliente.logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                            @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Cerrar Sesion') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                            @endif
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>

    <script>
        function showForm() {
            document.getElementById('form-container').style.display = 'block';
            document.getElementById('welcome-message').style.display = 'none';
        }
    </script>
</body>
</html>
