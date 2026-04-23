<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <h1 class="text-3xl font-bold" style="color: #D9E1F1;">
                Control de <span style="color: #8FB3E2;">TAREAS</span>
            </h1>
            <p class="text-sm mt-1" style="color: #8FB3E2;">Sistema de gestión</p>
        </x-slot>

        <x-validation-errors class="mb-4" />

        @session('status')
            <div class="mb-4 font-medium text-sm text-green-400">{{ $value }}</div>
        @endsession

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <h2 style="font-size: 1.25rem; font-weight: 600; color: #D9E1F1; margin-bottom: 1.5rem;">
                Acceso al Sistema
            </h2>

            <div>
                <x-label for="email" value="{{ __('Correo electrónico') }}" style="color: #8FB3E2;" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email"
                    :value="old('email')" required autofocus autocomplete="username"
                    placeholder="usuario@gmail.com"
                    style="background-color: #192338; border-color: #31487A; color: #D9E1F1;" />
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('Contraseña') }}" style="color: #8FB3E2;" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password"
                    required autocomplete="current-password" placeholder="••••••••"
                    style="background-color: #192338; border-color: #31487A; color: #D9E1F1;" />
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-checkbox id="remember_me" name="remember" />
                    <span class="ms-2 text-sm" style="color: #8FB3E2;">Mantener sesión iniciada</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-6">
                <x-button style="background-color: #31487A; color: #D9E1F1; border: none;">
                    {{ __('Iniciar Sesión') }}
                </x-button>
            </div>

            <div class="flex items-center justify-between mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm rounded-md"
                        style="color: #8FB3E2;"
                        href="{{ route('password.request') }}">
                        ¿Olvidaste tu contraseña?
                    </a>
                @endif

                @if (Route::has('register'))
                    <a class="underline text-sm rounded-md"
                        style="color: #8FB3E2;"
                        href="{{ route('register') }}">
                        Regístrate
                    </a>
                @endif
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>