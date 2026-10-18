@extends('layouts.helpdesk')

@section('title', 'Editar chamado | HelpDesk Inteligente')

@section('content')

<div class="mb-4">
    <a href="{{ route('tickets.show', $ticket) }}"
       class="text-decoration-none">
        &larr; Voltar para os detalhes
    </a>

    <h1 class="h3 mt-3">
        Editar chamado
    </h1>

    <p class="text-secondary">
        Atualize as informações do chamado.
    </p>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">

        <form action="{{ route('tickets.update', $ticket) }}" method="POST">

            @csrf
            @method('PUT')

            <div class="mb-3">

                <label for="title" class="form-label">
                    Título
                </label>

                <input
                    type="text"
                    id="title"
                    name="title"
                    value="{{ old('title', $ticket->title) }}"
                    class="form-control @error('title') is-invalid @enderror"
                    maxlength="255"
                    required>

                @error('title')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            <div class="mb-3">

                <label for="description" class="form-label">
                    Descrição do problema
                </label>

                <textarea
                    id="description"
                    name="description"
                    rows="5"
                    class="form-control @error('description') is-invalid @enderror"
                    required>{{ old('description', $ticket->description) }}</textarea>

                @error('description')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            <div class="mb-3">

                <label for="category" class="form-label">
                    Categoria
                </label>

                <select
                    id="category"
                    name="category"
                    class="form-select">

                    <option value="">Selecione uma categoria</option>

                    <option value="hardware"
                        @selected(old('category', $ticket->category) === 'hardware')>
                        Hardware
                    </option>

                    <option value="software"
                        @selected(old('category', $ticket->category) === 'software')>
                        Software
                    </option>

                    <option value="network"
                        @selected(old('category', $ticket->category) === 'network')>
                        Rede
                    </option>

                    <option value="access"
                        @selected(old('category', $ticket->category) === 'access')>
                        Acesso e permissões
                    </option>

                    <option value="other"
                        @selected(old('category', $ticket->category) === 'other')>
                        Outro
                    </option>

                </select>

            </div>

            <div class="mb-3">

                <label for="priority" class="form-label">
                    Prioridade
                </label>

                <select
                    id="priority"
                    name="priority"
                    class="form-select"
                    required>

                    <option value="low"
                        @selected(old('priority', $ticket->priority) === 'low')>
                        Baixa
                    </option>

                    <option value="medium"
                        @selected(old('priority', $ticket->priority) === 'medium')>
                        Média
                    </option>

                    <option value="high"
                        @selected(old('priority', $ticket->priority) === 'high')>
                        Alta
                    </option>

                    <option value="critical"
                        @selected(old('priority', $ticket->priority) === 'critical')>
                        Crítica
                    </option>

                </select>

            </div>

            <div class="mb-4">

                <label for="status" class="form-label">
                    Status
                </label>

                <select
                    id="status"
                    name="status"
                    class="form-select"
                    required>

                    <option value="open"
                        @selected(old('status', $ticket->status) === 'open')>
                        Aberto
                    </option>

                    <option value="in_progress"
                        @selected(old('status', $ticket->status) === 'in_progress')>
                        Em andamento
                    </option>

                    <option value="waiting"
                        @selected(old('status', $ticket->status) === 'waiting')>
                        Aguardando
                    </option>

                    <option value="resolved"
                        @selected(old('status', $ticket->status) === 'resolved')>
                        Resolvido
                    </option>

                </select>

            </div>

            <div class="d-flex gap-2">

                <button type="submit"
                        class="btn btn-primary">
                    Salvar alterações
                </button>

                <a href="{{ route('tickets.show', $ticket) }}" class="btn btn-outline-secondary">
                    Cancelar
                </a>

            </div>

        </form>

    </div>
</div>

@endsection