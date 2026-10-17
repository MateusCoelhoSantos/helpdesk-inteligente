
@extends('layouts.app')

@section('title', 'Chamados | HelpDesk Inteligente')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">Central de chamados</h1>
            <p class="text-secondary mb-0">
                Gerencie as solicitações de suporte.
            </p>
        </div>

        <a href="{{ route('tickets.create') }}" class="btn btn-primary">
            + Novo chamado
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close"
                data-bs-dismiss="alert" aria-label="Fechar"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            @forelse ($tickets as $ticket)
                <div class="border-bottom py-3">
                    <div class="d-flex justify-content-between flex-wrap gap-2">
                        <div>
                            <h2 class="h5 mb-1">
                                <a href="{{ route('tickets.show', $ticket) }}"
                                class="text-decoration-none">
                                    #{{ $ticket->id }} · {{ $ticket->title }}
                                </a>
                            </h2>
                            <p class="text-secondary mb-2">
                                {{ Str::limit($ticket->description, 150) }}
                            </p>
                            <small class="text-secondary">
                                Categoria: {{ $ticket->category ?? 'Não definida' }}
                            </small>
                        </div>

                        <div class="text-md-end">
                            @php
                                $priorities = [
                                    'low' => 'Baixa',
                                    'medium' => 'Média',
                                    'high' => 'Alta',
                                    'critical' => 'Crítica',
                                ];

                                $statuses = [
                                    'open' => 'Aberto',
                                    'in_progress' => 'Em andamento',
                                    'waiting' => 'Aguardando',
                                    'resolved' => 'Resolvido',
                                ];
                            @endphp

                            <span class="badge text-bg-primary">
                                {{ $priorities[$ticket->priority] ?? $ticket->priority }}
                            </span>

                            <span class="badge text-bg-secondary">
                                {{ $statuses[$ticket->status] ?? $ticket->status }}
                            </span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-5">
                    <h2 class="h5">Nenhum chamado cadastrado</h2>
                    <p class="text-secondary">
                        Crie seu primeiro chamado para começar.
                    </p>
                    <a href="{{ route('tickets.create') }}"
                        class="btn btn-primary">
                        Criar primeiro chamado
                    </a>
                </div>
            @endforelse
        </div>
    </div>

    <div class="mt-3">
        {{ $tickets->links() }}
    </div>
@endsection
