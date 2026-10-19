<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'HelpDesk Inteligente')</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet">
</head>
<body class="bg-light">

    <nav class="navbar navbar-dark bg-dark">
        <div class="container">

            <div class="d-flex gap-3">

                <a
                    href="{{ route('dashboard') }}"
                    class="text-white text-decoration-none">
                    Dashboard
                </a>

                <a
                    href="{{ route('tickets.index') }}"
                    class="text-white text-decoration-none">
                    Chamados
                </a>

            </div>

            @auth
                <div class="d-flex align-items-center gap-3">

                    <span class="text-white">
                        {{ auth()->user()->name }}
                    </span>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <button type="submit"
                                class="btn btn-outline-light btn-sm">
                            Sair
                        </button>
                    </form>

                </div>
            @endauth

        </div>
    </nav>

    <main class="container py-4">
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>