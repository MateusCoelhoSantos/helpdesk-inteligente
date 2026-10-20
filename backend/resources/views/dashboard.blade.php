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

            <div class="row row-cols-1 row-cols-md-2 row-cols-xl-5 g-3 mb-4">

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

            </div>    

            <div class="flex flex-wrap gap-4">

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