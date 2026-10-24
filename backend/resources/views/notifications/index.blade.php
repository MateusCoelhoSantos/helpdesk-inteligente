@extends('layouts.helpdesk')

@section('title', 'Notificações')

@section('content')

<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h1>Notificações</h1>

    </div>

    <form
        action="{{ route('notifications.read-all') }}"
        method="POST"
        class="mb-3"
    >
        @csrf

        <button
            type="submit"
            class="btn btn-success"
        >
            Marcar todas como lidas
        </button>
    </form>

    <div class="card shadow-sm">

        <div class="card-body">

            @forelse($notifications as $notification)

                <div
                    class="border rounded p-3 mb-3
                    {{ !$notification->read ? 'bg-light' : '' }}"
                >

                    <div class="d-flex justify-content-between">

                        <div>

                            <h5 class="mb-1">
                                {{ $notification->title }}
                            </h5>

                            <p class="mb-1">
                                {{ $notification->message }}
                            </p>

                            <small class="text-muted">
                                {{ $notification->created_at->diffForHumans() }}
                            </small>

                        </div>

                        @if(!$notification->read)

                            <span class="badge bg-primary">
                                Não lida
                            </span>

                        @endif

                    </div>

                    <div class="mt-2">

                        <a
                            href="{{ route('notifications.show', $notification) }}"
                            class="btn btn-sm btn-outline-primary"
                        >
                            Abrir
                        </a>

                    </div>

                </div>

            @empty

                <p class="text-muted mb-0">
                    Nenhuma notificação encontrada.
                </p>

            @endforelse

        </div>

    </div>

    <div class="mt-4">

        {{ $notifications->links() }}

    </div>

</div>

@endsection