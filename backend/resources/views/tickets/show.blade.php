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

            @can('update', $ticket)
                <a href="{{ route('tickets.edit', $ticket) }}"
                class="btn btn-warning">
                    Editar chamado
                </a>
            @endcan

            @can('delete', $ticket)
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
            @endcan

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

            @if($ticket->resolved_at)

                <p>
                    <strong>Resolvido em:</strong>
                    {{ $ticket->resolved_at->format('d/m/Y H:i') }}
                </p>

                <p>
                    <strong>Tempo de resolução:</strong>
                    {{ $ticket->resolution_time }}
                </p>

                <p>
                    <strong>SLA:</strong>

                    <span class="badge bg-{{ $ticket->sla_status }}">
                        {{ $ticket->sla_label }}
                    </span>
                </p>

            @endif

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
            
            @if ($ticket->assignedUser)

                <div class="mb-3">
                    <strong>Responsável:</strong>
                    {{ $ticket->assignedUser->name }}
                </div>

            @else

                <div class="mb-3">
                    <strong>Responsável:</strong>
                    Não atribuído
                </div>

            @endif

        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header">
            <h5 class="mb-0">Anexos</h5>
        </div>

        <div class="card-body">

            @forelse($ticket->attachments as $attachment)

                <div class="mb-2">

                    <a
                        href="{{ asset('storage/' . $attachment->file_path) }}"
                        target="_blank"
                        class="text-decoration-none"
                    >
                        📎 {{ $attachment->original_name }}
                    </a>

                    <small class="text-muted ms-2">
                        enviado por {{ $attachment->user->name }}
                    </small>

                </div>

            @empty

                <p class="text-muted mb-0">
                    Nenhum anexo foi enviado.
                </p>

            @endforelse

        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header">
            <h5 class="mb-0">Comentários</h5>
        </div>

        <div class="card-body">

            @forelse($ticket->comments as $comment)

                <div class="border rounded p-3 mb-3">

                    <div class="fw-bold">
                        {{ $comment->user->name }}

                        @if($comment->user_id === auth()->id())
                            <span class="badge bg-primary ms-2">
                                Você
                            </span>
                        @endif
                    </div>

                    <small class="text-muted">
                        {{ $comment->created_at->format('d/m/Y H:i') }}
                    </small>

                    <div class="mt-2">
                        {{ $comment->message }}
                    </div>

                    @if($comment->attachments->count())

                        <div class="mt-3">

                            @foreach($comment->attachments as $attachment)

                                <div>

                                    <a
                                        href="{{ asset('storage/' . $attachment->file_path) }}"
                                        target="_blank"
                                    >
                                        📎 {{ $attachment->original_name }}
                                    </a>

                                </div>

                            @endforeach

                        </div>

                    @endif

                </div>

            @empty

                <p class="text-muted">
                    Nenhum comentário registrado.
                </p>

            @endforelse

        </div>
    </div>

    <form
        enctype="multipart/form-data"
        action="{{ route('tickets.comments.store', $ticket) }}"
        method="POST"
    >
        @csrf

        <div class="mb-3">
            <label class="form-label">
                Novo comentário
            </label>

            <textarea
                name="message"
                class="form-control"
                rows="4"
                required
            ></textarea>

            <div class="mt-3">
                <label class="form-label">
                    Anexos (opcional)
                </label>

                <input
                    type="file"
                    name="attachments[]"
                    class="form-control"
                    multiple
                    accept=".jpg,.jpeg,.png,.pdf,.doc,.docx"
                >
            </div>
        </div>

        <button
            type="submit"
            class="btn btn-primary"
        >
            Adicionar comentário
        </button>
    </form>

    <div class="card mt-4">
        <div class="card-header">
            <h5 class="mb-0">Histórico</h5>
        </div>

        <div class="card-body">

            <div class="timeline">

                @forelse($ticket->histories as $history)

                    <div class="timeline-item">

                        @php
                            $icon = match($history->action) {
                                'created' => '🟢',
                                'assigned' => '👤',
                                'reassigned' => '🔄',
                                'unassigned' => '❌',
                                'status_changed' => '📌',
                                'priority_changed' => '⚠️',
                                'category_changed' => '📁',
                                'commented' => '💬',
                                'attachment_added' => '📎',
                                default => '•',
                            };
                        @endphp

                        <div class="fw-semibold">
                            {{ $icon }} {{ $history->description }}
                        </div>

                        <div class="timeline-date">
                            {{ $history->created_at->format('d/m/Y H:i') }}
                        </div>

                    </div>

                @empty

                    <p class="text-muted">
                        Nenhum histórico registrado.
                    </p>

                @endforelse

            </div>
        </div>
    </div>
</div>

<style>
.timeline {
    position: relative;
    margin-left: 20px;
}

.timeline-item {
    position: relative;
    padding-left: 30px;
    padding-bottom: 25px;
}

.timeline-item:last-child {
    padding-bottom: 0;
}

.timeline-item::before {
    content: '';
    position: absolute;
    left: -10px;
    top: 6px;
    width: 12px;
    height: 12px;
    background: #0d6efd;
    border-radius: 50%;
}

.timeline-item::after {
    content: '';
    position: absolute;
    left: -5px;
    top: 18px;
    width: 2px;
    height: 100%;
    background: #dee2e6;
}

.timeline-item:last-child::after {
    display: none;
}

.timeline-date {
    font-size: 0.85rem;
    color: #6c757d;
}
</style>

@endsection