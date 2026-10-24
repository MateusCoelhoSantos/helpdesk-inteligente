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
        <div class="container d-flex justify-content-between align-items-center">

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

                    <div class="dropdown">

                        <a
                            class="nav-link dropdown-toggle text-white"
                            href="#"
                            role="button"
                            data-bs-toggle="dropdown"
                        >
                            🔔

                            @if($unreadNotifications > 0)
                                <span class="badge bg-danger">
                                    {{ $unreadNotifications }}
                                </span>
                            @endif
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end">

                            @forelse($navbarNotifications as $notification)

                                <li>

                                    <a
                                        href="{{ route('notifications.show', $notification) }}"
                                        class="dropdown-item {{ !$notification->read ? 'fw-bold bg-light' : '' }}"
                                    >
                                        <strong>
                                            {{ $notification->title }}
                                        </strong>

                                        <br>

                                        <small>
                                            {{ $notification->message }}
                                        </small>

                                        <br>

                                        <small class="text-muted">
                                            {{ $notification->created_at->diffForHumans() }}
                                        </small>

                                    </a>

                                </li>

                            @empty

                                <li>
                                    <span class="dropdown-item-text">
                                        Nenhuma notificação
                                    </span>
                                </li>

                            @endforelse

                            <li>
                                <hr class="dropdown-divider">
                            </li>

                            <li>
                                <a
                                    href="{{ route('notifications.index') }}"
                                    class="dropdown-item text-center fw-bold"
                                >
                                    Ver todas
                                </a>
                            </li>

                        </ul>

                    </div>

                    <div class="d-flex flex-column align-items-end">
                        <span class="text-white">
                            {{ auth()->user()->name }}
                        </span>

                        <small class="text-light">
                            {{ auth()->user()->role_label }}
                        </small>
                    </div>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <button
                            type="submit"
                            class="btn btn-outline-light btn-sm"
                        >
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