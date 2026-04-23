<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="font-sans antialiased bg-[#d9e1f1]">
    <x-banner />

    <div class="min-h-screen bg-[#d9e1f1]">
        @livewire('navigation-menu')

        @if (isset($header))
            <header class="bg-[#192338ff] shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <main>
            {{ $slot }}
        </main>
    </div>

    @stack('modals')
    @livewireScripts

    {{-- Toast de notificaciones --}}
    <div
        x-data="{ show: false, titulo: '', contenido: '' }"
        x-init="
            setTimeout(() => {
                window.Echo.channel('notificaciones.{{ auth()->id() }}')
                    .listen('.nueva.notificacion', (e) => {
                        titulo = e.notificacion.titulo;
                        contenido = e.notificacion.contenido;
                        show = true;
                        setTimeout(() => show = false, 5000);
                    })
            }, 1000)
        "
        x-show="show"
        x-transition
        style="display:none;"
        class="fixed bottom-6 right-6 z-50 bg-[#1E2E4F] border border-[#31487A] text-white
               rounded-xl shadow-2xl px-5 py-4 max-w-sm w-full">
        <div class="flex items-start gap-3">
            <div class="w-2 h-2 rounded-full bg-purple-400 mt-1.5 shrink-0"></div>
            <div>
                <p class="text-sm font-semibold" x-text="titulo"></p>
                <p class="text-xs text-[#8FB3E2] mt-0.5" x-text="contenido"></p>
            </div>
            <button @click="show = false" class="ml-auto text-[#8FB3E2] hover:text-white text-xs">✕</button>
        </div>
    </div>

</body>
</html>