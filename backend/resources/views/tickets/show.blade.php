@extends('layouts.app')

@section('content')
<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Detalhes do Chamado</h1>

        <a href="{{ route('tickets.index') }}" class="btn btn-secondary">
            Voltar
        </a>
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
                {{ $ticket->category ?? 'Não informada' }}
            </p>

            <p>
                <strong>Prioridade:</strong>
                {{ ucfirst($ticket->priority) }}
            </p>

            <p>
                <strong>Status:</strong>
                {{ ucfirst($ticket->status) }}
            </p>

            <p>
                <strong>Criado em:</strong>
                {{ $ticket->created_at->format('d/m/Y H:i') }}
            </p>

            <p>
                <strong>Atualizado em:</strong>
                {{ $ticket->updated_at->format('d/m/Y H:i') }}
            </p>

        </div>
    </div>

</div>
@endsection