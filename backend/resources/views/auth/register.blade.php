<x-guest-layout>

    <div class="text-center mb-6">

        <h1 class="text-2xl font-bold">
            HelpDesk Inteligente
        </h1>

        <p class="mt-2 text-sm text-gray-600">
            Crie uma conta para acessar o portal de suporte.
        </p>

    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="'Nome'" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="'E-mail'" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="'Senha'" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="'Confirmar senha'" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="mt-4 text-center">

            <x-primary-button class="ms-4">
                Criar conta
            </x-primary-button>

        </div>

        <div class="mt-4 text-center">

            <p class="text-sm text-gray-600">

                Já possui uma conta?

                <a
                    href="{{ route('login') }}"
                    class="font-medium text-indigo-600 hover:text-indigo-500">

                    Entrar

                </a>

            </p>

        </div>
    </form>
</x-guest-layout>
