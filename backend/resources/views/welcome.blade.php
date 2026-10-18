<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>HelpDesk Inteligente</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container py-5">

        <div class="text-center mb-5">

            <h1 class="display-4 fw-bold">
                HelpDesk Inteligente
            </h1>

            <p class="lead text-secondary">
                Sistema de gerenciamento de chamados de suporte técnico
                desenvolvido com Laravel, PostgreSQL e integração futura com IA.
            </p>

            <div class="mt-4 d-flex justify-content-center gap-2">

                @auth

                    <a href="{{ route('tickets.index') }}"
                       class="btn btn-primary btn-lg">
                        Acessar Sistema
                    </a>

                @else

                    <a href="{{ route('login') }}"
                       class="btn btn-primary btn-lg">
                        Entrar
                    </a>

                    <a href="{{ route('register') }}"
                       class="btn btn-outline-primary btn-lg">
                        Criar Conta
                    </a>

                @endauth

            </div>

        </div>

        <div class="row g-4">

            <div class="col-md-6">

                <div class="card shadow-sm h-100">
                    <div class="card-body">

                        <h2 class="h4">
                            Funcionalidades
                        </h2>

                        <ul class="mb-0">
                            <li>Gestão de chamados</li>
                            <li>Controle de status</li>
                            <li>Busca por título</li>
                            <li>Filtros avançados</li>
                            <li>Autenticação de usuários</li>
                            <li>Relacionamento entre usuários e chamados</li>
                            <li>Integração com IA (em desenvolvimento)</li>
                        </ul>

                    </div>
                </div>

            </div>

            <div class="col-md-6">

                <div class="card shadow-sm h-100">
                    <div class="card-body">

                        <h2 class="h4">
                            Tecnologias
                        </h2>

                        <ul class="mb-0">
                            <li>PHP 8.5</li>
                            <li>Laravel 13</li>
                            <li>PostgreSQL</li>
                            <li>Bootstrap</li>
                            <li>JavaScript</li>
                        </ul>

                    </div>
                </div>

            </div>

        </div>

        <footer class="text-center text-secondary mt-5">

            <p class="mb-0">
                Projeto de Portfólio • Mateus Coelho Santos
            </p>

        </footer>

    </div>

</body>
</html>