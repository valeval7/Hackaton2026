<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
          
        </x-slot>

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <h2 style="font-size: 1.25rem; font-weight: 600; color: #D9E1F1; margin-bottom: 1.5rem;">
                Crear cuenta
            </h2>

            <div>
                <x-label for="name" value="{{ __('Nombre') }}" style="color: #8FB3E2;" />
                <x-input id="name" class="block mt-1 w-full" type="text" name="name"
                    :value="old('name')" required autofocus autocomplete="name"
                    style="background-color: #192338; border-color: #31487A; color: #D9E1F1;" />
            </div>

            <div class="mt-4">
                <x-label for="email" value="{{ __('Correo electrónico') }}" style="color: #8FB3E2;" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email"
                    :value="old('email')" required autocomplete="username"
                    style="background-color: #192338; border-color: #31487A; color: #D9E1F1;" />
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('Contraseña') }}" style="color: #8FB3E2;" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password"
                    required autocomplete="new-password"
                    style="background-color: #192338; border-color: #31487A; color: #D9E1F1;" />
            </div>

            <div class="mt-4">
                <x-label for="password_confirmation" value="{{ __('Confirmar contraseña') }}" style="color: #8FB3E2;" />
                <x-input id="password_confirmation" class="block mt-1 w-full" type="password"
                    name="password_confirmation" required autocomplete="new-password"
                    style="background-color: #192338; border-color: #31487A; color: #D9E1F1;" />
            </div>

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <x-label for="terms">
                        <div class="flex items-center">
                            <x-checkbox name="terms" id="terms" required />
                            <div class="ms-2" style="color: #8FB3E2; font-size: 0.875rem;">
                                {!! __('Acepto los :terms_of_service y la :privacy_policy', [
                                    'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" style="color: #8FB3E2; text-decoration: underline;">'.__('Términos de servicio').'</a>',
                                    'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" style="color: #8FB3E2; text-decoration: underline;">'.__('Política de privacidad').'</a>',
                                ]) !!}
                            </div>
                        </div>
                    </x-label>
                </div>
            @endif

            <div class="flex items-center justify-end mt-6">
                <a class="underline text-sm rounded-md"
                    style="color: #8FB3E2;"
                    href="{{ route('login') }}">
                    ¿Ya tienes cuenta? Inicia sesión
                </a>

                <x-button class="ms-4" style="background-color: #31487A; color: #D9E1F1; border: none;">
                    {{ __('Registrarse') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>