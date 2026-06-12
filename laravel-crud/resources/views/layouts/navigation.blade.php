<nav style="
    background: rgba(255,255,255,0.9);
    backdrop-filter: blur(10px);
    border-bottom: 1px solid rgba(31,158,110,0.15);
    padding: 0.75rem 1.5rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-family: 'Segoe UI', sans-serif;
    position: sticky;
    top: 0;
    z-index: 100;
">
    <a href="{{ route('dashboard') }}" style="font-weight:700; color:#1f9e6e; text-decoration:none; font-size:1.1rem;">
        🌍 CultureLingo
    </a>
    <div style="display:flex; align-items:center; gap:1rem;">
        <span style="color:#6b7280; font-size:0.9rem;">{{ Auth::user()->name }}</span>
        <a href="{{ route('cultures.index') }}" style="color:#2563eb; font-size:0.85rem; text-decoration:none; padding:0.4rem 0.8rem; border:1px solid #2563eb; border-radius:8px;">
            Cultures beheren
        </a>
        <form method="POST" action="{{ route('logout') }}" style="margin:0;">
            @csrf
            <button type="submit" style="background:#ef4444; color:white; border:none; padding:0.45rem 1rem; border-radius:8px; cursor:pointer; font-size:0.85rem; font-family:inherit;">
                Uitloggen
            </button>
        </form>
    </div>
</nav>