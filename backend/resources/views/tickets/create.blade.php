
@extends('layouts.app')

@section('title', 'Novo chamado | HelpDesk Inteligente')

@section('content')
    <div class="mb-4">
        <a href="{{ route('tickets.index') }}"
            class="text-decoration-none">
            &larr; Voltar para os chamados
        </a>
        <h1 class="h3 mt-3">Abrir chamado</h1>
        <p class="text-secondary">
            Descreva o problema para registrar uma solicitação de suporte.
        </p>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form action="{{ route('tickets.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="title" class="form-label">Título</label>
                    <input
                        type="text"
                        id="title"
                        name="title"
                        value="{{ old('title') }}"
                        class="form-control @error('title') is-invalid @enderror"
                        maxlength="255"
                        required
                    >
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
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
                        required
                    >{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="category" class="form-label">Categoria</label>
                    <select
                        id="category"
                        name="category"
                        class="form-select @error('category') is-invalid @enderror"
                    >
                        <option value="">Selecione uma categoria</option>
                        <option value="hardware" @selected(old('category') === 'hardware')>Hardware</option>
                        <option value="software" @selected(old('category') === 'software')>Software</option>
                        <option value="network" @selected(old('category') === 'network')>Rede</option>
                        <option value="access" @selected(old('category') === 'access')>Acesso e permissões</option>
                        <option value="other" @selected(old('category') === 'other')>Outro</option>
                    </select>
                    @error('category')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="priority" class="form-label">Prioridade</label>
                    <select
                        id="priority"
                        name="priority"
                        class="form-select @error('priority') is-invalid @enderror"
                        required
                    >
                        <option value="low" @selected(old('priority', 'medium') === 'low')>Baixa</option>
                        <option value="medium" @selected(old('priority', 'medium') === 'medium')>Média</option>
                        <option value="high" @selected(old('priority') === 'high')>Alta</option>
                        <option value="critical" @selected(old('priority') === 'critical')>Crítica</option>
                    </select>
                    @error('priority')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        Salvar chamado
                    </button>
                    <a href="{{ route('tickets.index') }}"
                        class="btn btn-outline-secondary">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
