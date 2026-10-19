@extends('layouts.helpdesk')

@section('content')

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}

        <button type="button"
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="Fechar">
        </button>
    </div>
@endif

<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h1>Detalhes do Chamado</h1>

        <div class="d-flex gap-2">

            <a href="{{ route('tickets.edit', $ticket) }}"
            class="btn btn-warning">
                Editar chamado
            </a>

            <form action="{{ route('tickets.destroy', $ticket) }}"
                method="POST"
                onsubmit="return confirm('Tem certeza que deseja excluir este chamado?');">

                @csrf
                @method('DELETE')

                <button type="submit"
                        class="btn btn-danger">
                    Excluir chamado
                </button>

            </form>

            <a href="{{ route('tickets.index') }}"
            class="btn btn-secondary">
                Voltar
            </a>

        </div>

    </div>

    <div class="card">
        <div class="card-body">

            <h3>{{ $ticket->title }}</h3>

            <hr>

            <p>
                <strong>Descrição:</strong>
            </p>

            <p>{{ $ticket->description }}</p>

            <p>
                <strong>Categoria:</strong>
                {{ $ticket->category_Label ?? 'Não informada' }}
            </p>

            <p>
                <strong>Prioridade:</strong>
                {{ $ticket->priority_label }}
            </p>

            <p>
                <strong>Status:</strong>
                {{ $ticket->status_label }}       
            </p>

            <p>
                <strong>Criado em:</strong>
                {{ $ticket->created_at->format('d/m/Y H:i') }}
            </p>

            <p>
                <strong>Atualizado em:</strong>
                {{ $ticket->updated_at->format('d/m/Y H:i') }}
            </p>

            @if(auth()->user()->isAdmin())

                <div class="mb-3">

                    <strong>Aberto por:</strong>

                    {{ $ticket->user?->name ?? 'Usuário não identificado' }}

                </div>

            @endif

        </div>
    </div>

</div>
@endsection