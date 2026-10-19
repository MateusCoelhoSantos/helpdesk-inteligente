@extends('layouts.helpdesk')

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

    <div class="card border-0 shadow-sm mb-3">
        <div class="card-body">

            <form method="GET"
                action="{{ route('tickets.index') }}">

                <div class="row g-2 align-items-end">

                    <div class="col-md-3">

                        <label for="q" class="form-label">
                            Buscar por título
                        </label>

                        <input
                            type="text"
                            id="q"
                            name="q"
                            class="form-control"
                            placeholder="Digite parte do título..."
                            value="{{ request('q') }}">

                    </div>

                    <div class="col-md-2">

                        <label for="status" class="form-label">
                            Status
                        </label>

                        <select
                            id="status"
                            name="status"
                            class="form-select">

                            <option value="">
                                Todos
                            </option>

                            <option value="open"
                                @selected(request('status') === 'open')>
                                Aberto
                            </option>

                            <option value="in_progress"
                                @selected(request('status') === 'in_progress')>
                                Em andamento
                            </option>

                            <option value="waiting"
                                @selected(request('status') === 'waiting')>
                                Aguardando
                            </option>

                            <option value="resolved"
                                @selected(request('status') === 'resolved')>
                                Resolvido
                            </option>

                        </select>

                    </div>

                    <div class="col-md-2">

                        <label for="priority" class="form-label">
                            Prioridade
                        </label>

                        <select
                            id="priority"
                            name="priority"
                            class="form-select">

                            <option value="">
                                Todas
                            </option>

                            <option value="low"
                                @selected(request('priority') === 'low')>
                                Baixa
                            </option>

                            <option value="medium"
                                @selected(request('priority') === 'medium')>
                                Média
                            </option>

                            <option value="high"
                                @selected(request('priority') === 'high')>
                                Alta
                            </option>

                            <option value="critical"
                                @selected(request('priority') === 'critical')>
                                Crítica
                            </option>

                        </select>

                    </div>

                    <div class="col-md-3">

                        <label for="category" class="form-label">
                            Categoria
                        </label>

                        <select
                            id="category"
                            name="category"
                            class="form-select">

                            <option value="">
                                Todas
                            </option>

                            <option value="hardware"
                                @selected(request('category') === 'hardware')>
                                Hardware
                            </option>

                            <option value="software"
                                @selected(request('category') === 'software')>
                                Software
                            </option>

                            <option value="network"
                                @selected(request('category') === 'network')>
                                Rede
                            </option>

                            <option value="access"
                                @selected(request('category') === 'access')>
                                Acesso e Permissões
                            </option>

                            <option value="other"
                                @selected(request('category') === 'other')>
                                Outro
                            </option>

                        </select>

                    </div>

                    <div class="col-md-2">

                        <button type="submit"
                                class="btn btn-primary w-100">
                            Buscar
                        </button>

                    </div>

                </div>

            </form>

        </div>
    </div>

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
                                Categoria: {{ $ticket->category_label }}
                            </small>

                            @if(auth()->user()->isAdmin())

                                <br>

                                <small class="text-secondary">
                                    Aberto por:
                                    {{ $ticket->user?->name ?? 'Usuário não identificado' }}
                                </small>

                            @endif
                        </div>

                        <div class="text-md-end">

                            <span class="badge text-bg-primary">
                                {{ $ticket->priority_label }}
                            </span>

                            <span class="badge text-bg-secondary">
                                {{ $ticket->status_label }}
                            </span>
                        </div>
                    </div>
                </div>

            @empty
                <div class="text-center py-5">

                    @if(
                        request()->filled('q') ||
                        request()->filled('status') ||
                        request()->filled('priority') ||
                        request()->filled('category')
                    )

                        <h2 class="h5">
                            Nenhum chamado encontrado
                        </h2>

                        <p class="text-secondary">
                            Tente alterar os filtros ou os termos utilizados na busca.
                        </p>

                        <a href="{{ route('tickets.index') }}"
                        class="btn btn-outline-primary">
                            Limpar filtros
                        </a>

                    @else

                        <h2 class="h5">
                            Nenhum chamado cadastrado
                        </h2>

                        <p class="text-secondary">
                            Crie seu primeiro chamado para começar.
                        </p>

                        <a href="{{ route('tickets.create') }}"
                        class="btn btn-primary">
                            Criar primeiro chamado
                        </a>

                    @endif

                </div>
            @endforelse

        </div>
    </div>

    <div class="mt-3">
        {{ $tickets->links() }}
    </div>
@endsection
