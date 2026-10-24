@extends('layouts.helpdesk')

@section('title', 'Dashboard')

@section('content')

    <div class="card shadow-sm">

        <div class="card-body">

            <h1 class="h3 mb-2">
                Bem-vindo(a), {{ auth()->user()->name }}
            </h1>

            <p class="text-muted mb-4">
                Gerencie seus chamados de suporte através do HelpDesk Inteligente.
            </p>

            <h2 class="h5 mb-3">
                Resumo dos Chamados
            </h2>

            <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 g-3 mb-4">

                <div class="col">

                    <a href="{{ route('tickets.index') }}"
                    class="text-decoration-none">

                        <div class="card h-100 border-start border-4 border-primary shadow-sm">

                            <div class="card-body text-center">

                                <h6 class="text-muted">
                                    Total de Chamados
                                </h6>

                                <h2 class="display-6 fw-bold mb-0">
                                    {{ $totalTickets }}
                                </h2>

                            </div>

                        </div>

                    </a>

                </div>

                <div class="col">

                    <a href="{{ route('tickets.index', ['status' => 'open']) }}"
                    class="text-decoration-none">

                        <div class="card h-100 border-start border-4 border-danger shadow-sm">

                            <div class="card-body text-center">
                                <h6 class="text-muted">
                                    Chamados Abertos
                                </h6>

                                <h2 class="display-6 fw-bold text-danger mb-0">
                                    {{ $openTickets }}
                                </h2>


                            </div>

                        </div>

                    </a>

                </div>

                <div class="col">

                    <a href="{{ route('tickets.index', ['status' => 'in_progress']) }}"
                    class="text-decoration-none">

                        <div class="card h-100 border-start border-4 border-info shadow-sm">

                            <div class="card-body text-center">

                                <h6 class="text-muted">
                                    Chamados em Andamento
                                </h6>

                                <h2 class="display-6 fw-bold text-primary mb-0">
                                    {{ $inProgressTickets }}
                                </h2>

                            </div>

                        </div>

                    </a>
                
                </div>

                <div class="col">

                    <a href="{{ route('tickets.index', ['status' => 'waiting']) }}"
                    class="text-decoration-none">

                        <div class="card h-100 border-start border-4 border-warning shadow-sm">

                            <div class="card-body text-center">

                                <h6 class="text-muted">
                                    Chamados Aguardando
                                </h6>

                                <h2 class="display-6 fw-bold text-warning mb-0">
                                    {{ $waitingTickets }}
                                </h2>

                            </div>

                        </div>

                    </a>

                </div>

                <div class="col">

                    <a href="{{ route('tickets.index', ['status' => 'resolved']) }}"
                    class="text-decoration-none">

                        <div class="card h-100 border-start border-4 border-success shadow-sm">

                            <div class="card-body text-center">

                                <h6 class="text-muted">
                                    Chamados Resolvidos
                                </h6>

                                <h2 class="display-6 fw-bold text-success mb-0">
                                    {{ $resolvedTickets }}
                                </h2>

                            </div>

                        </div>

                    </a>

                </div>         

                <div class="col">
                    <div class="card h-100 border-start border-4 border-dark shadow-sm">
                        <div class="card-body text-center">
                            <h6 class="text-muted">
                                Chamados Críticos
                            </h6>

                            <h2 class="display-6 fw-bold text-danger mb-0">
                                {{ $criticalTickets }}
                            </h2>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card h-100 border-start border-4 border-primary shadow-sm">
                        <div class="card-body text-center">
                            <h6 class="text-muted">
                                Atribuídos a Mim
                            </h6>

                            <h2 class="display-6 fw-bold text-primary mb-0">
                                {{ $assignedToMe }}
                            </h2>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card h-100 border-start border-4 border-secondary shadow-sm">
                        <div class="card-body text-center">
                            <h6 class="text-muted">
                                Sem Responsável
                            </h6>

                            <h2 class="display-6 fw-bold text-secondary mb-0">
                                {{ $unassignedTickets }}
                            </h2>
                        </div>
                    </div>
                </div>

            </div>    

            <div class="row mt-4">

                <div class="col-md-6">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            Chamados por Status
                        </div>

                        <div class="card-body">
                            <canvas id="statusChart"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            Chamados por Categoria
                        </div>

                        <div class="card-body">
                            <canvas id="categoriesChart"></canvas>
                        </div>
                    </div>
                </div>

            </div>

            <div class="card mt-4 shadow-sm">

                <div class="card-header bg-danger text-white">
                    ⚠️ Chamados Críticos Abertos
                </div>

                <div class="card-body">

                    @forelse($attentionTickets as $ticket)

                        <div class="mb-2">

                            <a
                                href="{{ route('tickets.show', $ticket) }}"
                                class="text-decoration-none fw-semibold"
                            >
                                #{{ $ticket->id }} - {{ $ticket->title }}
                            </a>

                            <div class="small text-muted">
                                {{ $ticket->status_label }}
                            </div>

                        </div>

                    @empty

                        <p class="text-muted mb-0">
                            Nenhum chamado crítico pendente.
                        </p>

                    @endforelse

                </div>

            </div> 

            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>  

            <script>

                const statusCtx = document.getElementById('statusChart');

                new Chart(statusCtx, {
                    type: 'doughnut',
                    data: {
                        labels: [
                            'Abertos',
                            'Em Andamento',
                            'Aguardando',
                            'Resolvidos'
                        ],
                        datasets: [{
                            data: [
                                {{ $statusChart['open'] }},
                                {{ $statusChart['in_progress'] }},
                                {{ $statusChart['waiting'] }},
                                {{ $statusChart['resolved'] }}
                            ]
                        }]
                    }
                });

                const categoriesCtx = document.getElementById('categoriesChart');

                new Chart(categoriesCtx, {
                    type: 'bar',
                    data: {
                        labels: [
                            'Hardware',
                            'Software',
                            'Rede',
                            'Acesso',
                            'Outros'
                        ],
                        datasets: [{
                            label: 'Chamados',
                            data: [
                                {{ $categoriesChart['hardware'] }},
                                {{ $categoriesChart['software'] }},
                                {{ $categoriesChart['network'] }},
                                {{ $categoriesChart['access'] }},
                                {{ $categoriesChart['other'] }}
                            ]
                        }]
                    }
                });

            </script>

            <div class="flex flex-wrap gap-4">
                <br>
                <a href="{{ route('tickets.index') }}"
                class="btn btn-primary">
                    Acessar Meus Chamados
                </a>

            </div>

            <div class="mt-4">

                <h2 class="text-lg font-semibold mb-4">
                    Últimos Chamados
                </h2>

                <div class="card shadow-sm">
                    <div class="list-group list-group-flush">

                        @forelse ($recentTickets as $ticket)

                            <div class="list-group-item">

                                <div class="d-flex justify-content-between align-items-center">

                                    <div>

                                        <a href="{{ route('tickets.show', $ticket) }}"
                                        class="fw-semibold text-decoration-none">

                                            #{{ $ticket->id }} - {{ $ticket->title }}

                                        </a>
                                                                    
                                        <p class="small text-muted">
                                            Categoria: {{ $ticket->category_label }}
                                        </p>

                                        @if(auth()->user()->isAdmin())

                                            <p class="small text-muted">
                                                Aberto por: {{ $ticket->user?->name ?? 'Usuário não identificado' }}
                                            </p>

                                        @endif

                                        @if($ticket->assignedUser)

                                            <p class="small text-muted">
                                                Responsável: {{ $ticket->assignedUser->name }}
                                            </p>

                                        @endif

                                    </div>

                                    <span class="text-sm text-gray-600">
                                        Status: {{ $ticket->status_label }}
                                    </span>

                                </div>

                            </div>

                        @empty

                            <div class="p-4 text-gray-500">
                                Nenhum chamado cadastrado.
                            </div>

                    
                        @endforelse
                    </div>
                </div>

            </div>

        </div>

    </div>

@endsection