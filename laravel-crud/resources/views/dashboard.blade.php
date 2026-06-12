<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('CultureLingo') }}
        </h2>
    </x-slot>

    {{-- Hier laden we jouw assets via Laravel Vite --}}
    @vite(['resources/css/style.css', 'resources/js/game.js'])

    {{-- Game Container --}}
    <div class="game-wrapper">
        <header class="site-header">
            <div class="brand">
              <div class="logo">🌍</div>
              <div>
                <h1>CultureLingo</h1>
                <p>Learn cultures through fun micro-lessons.</p>
              </div>
            </div>
            <div class="header-actions">
              <div class="streak">🔥 Streak: <span id="streakValue">5</span> days</div>
              <button id="resetButton" class="btn secondary">Reset</button>
            </div>
        </header>

        <main>
            <section class="hero">
              <div>
                <h2>Trade language learning for cultural discovery.</h2>
              </div>
              <div class="hero-card">
                <div class="hero-card__stat">
                  <strong id="xpValue">320</strong>
                  <span>XP earned</span>
                </div>
              </div>
            </section>

            <section class="culture-grid-section">
              <div id="cultureGrid" class="culture-grid"></div>
            </section>
        </main>
    </div>
</x-app-layout>