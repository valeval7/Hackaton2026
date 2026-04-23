<div style="min-height: 100vh; display: flex; flex-direction: column; justify-content: center; align-items: center; background-color: #192338;">

    @if(trim($logo))
    <div style="width: 100%; max-width: 45rem; padding: 2rem 2.5rem; border-radius: 0.75rem 0.75rem 0 0; background-color: #31487A; display: flex; align-items: center; justify-content: center; gap: 1.5rem;">
        <img src="https://raw.githubusercontent.com/valeval7/Hackaton2026/d90e160d6449a7da57c2a9f46a86a9160d201cbc/logo_tareas.svg"
            style="width: 8rem; height: 8rem; flex-shrink: 0;" alt="Logo">
        <div style="text-align: left;">{{ $logo }}</div>
    </div>
    @endif


    <div style="width: 100%; max-width: 45rem; padding: 2.5rem; box-shadow: 0 10px 25px rgba(0,0,0,0.5); border-radius: {{ trim($logo) ? '0 0 0.75rem 0.75rem' : '0.75rem' }}; background-color: #1E2E4F;">
        <div>{{ $slot }}</div>
    </div>

</div>