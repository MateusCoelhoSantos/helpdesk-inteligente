<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-12">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                <div class="p-6 text-gray-900">

                    <h1 class="text-2xl font-bold mb-2">
                        Bem-vindo, {{ auth()->user()->name }}
                    </h1>

                    <p class="text-gray-600 mb-6">
                        Gerencie seus chamados de suporte através do HelpDesk Inteligente.
                    </p>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">

                        <div class="bg-gray-100 rounded-lg p-4">

                            <a
                                href="{{ route('tickets.index') }}"
                                class="block bg-gray-100 rounded-lg p-4 hover:bg-gray-200 transition">

                                <h3 class="text-sm text-gray-500">
                                    Total de Chamados
                                </h3>

                                <p class="text-3xl font-bold">
                                    {{ $totalTickets }}
                                </p>

                            </a>

                        </div>

                        <div class="bg-gray-100 rounded-lg p-4">

                            <a
                                href="{{ route('tickets.index', ['status' => 'open']) }}"
                                class="block bg-gray-100 rounded-lg p-4 hover:bg-gray-200 transition">

                                <h3 class="text-sm text-gray-500">
                                    Chamados Abertos
                                </h3>

                                <p class="text-3xl font-bold text-red-600">
                                    {{ $openTickets }}
                                </p>

                            </a>

                        </div>

                        <div class="bg-gray-100 rounded-lg p-4">

                            <a
                                href="{{ route('tickets.index', ['status' => 'resolved']) }}"
                                class="block bg-gray-100 rounded-lg p-4 hover:bg-gray-200 transition">

                                <h3 class="text-sm text-gray-500">
                                    Chamados Resolvidos
                                </h3>

                                <p class="text-3xl font-bold text-green-600">
                                    {{ $resolvedTickets }}
                                </p>

                            </a>

                        </div>

                    </div>

                    <div class="flex flex-wrap gap-4">

                        <a href="{{ route('tickets.index') }}">
                            <x-primary-button>
                                Acessar Meus Chamados
                            </x-primary-button>
                        </a>

                    </div>

                    <div class="mt-8">

                        <h2 class="text-lg font-semibold mb-4">
                            Últimos Chamados
                        </h2>

                        <div class="bg-gray-50 rounded-lg divide-y">

                            @forelse ($recentTickets as $ticket)

                                <div class="p-4">

                                    <div class="flex justify-between items-center">

                                        <div>

                                            <a href="{{ route('tickets.show', $ticket) }}"
                                            class="font-medium text-indigo-600 hover:text-indigo-500">

                                                #{{ $ticket->id }} - {{ $ticket->title }}

                                            </a>
                                                                        
                                            <p class="text-sm text-gray-500">
                                                Categoria: {{ $ticket->category_label }}
                                            </p>

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

    </div>

</x-app-layout>