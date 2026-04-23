<x-app-layout title="Dashboard">
    <div class="mb-8 border-b border-stone-200 p-6 bg-[#d9e1f1]">
        <h1 class="text-2xl font-semibold text-stone-800 tracking-tight">Resumen</h1>
        <p class="text-sm text-stone-400 mt-1">
            Tus tareas ordenadas por urgencia real.
        </p>
    </div>

    {{-- Componente Livewire del dashboard --}}
    @livewire('dashboard')
</x-app-layout>
