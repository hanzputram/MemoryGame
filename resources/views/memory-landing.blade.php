<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Memory Flip Card Game</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            padding: 24px;
            transition: background 0.3s ease, color 0.3s ease;
        }

        /* === THEMES === */
        body.theme-dark-neon {
            background: radial-gradient(circle at top, #1d4ed8, #020617 55%);
            color: #e5e7eb;
        }

        body.theme-cyberpunk {
            background: radial-gradient(circle at top, #f97316, #4c1d95 55%);
            color: #f9fafb;
        }

        body.theme-minimal {
            background: #f3f4f6;
            color: #111827;
        }

        .container {
            max-width: 1100px;
            margin: 0 auto;
        }

        .hero {
            display: grid;
            grid-template-columns: minmax(0, 2fr) minmax(0, 1.5fr);
            gap: 32px;
            align-items: center;
            margin-bottom: 40px;
        }

        @media (max-width: 900px) {
            .hero {
                grid-template-columns: 1fr;
            }
        }

        .hero-title {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 8px;
        }

        .hero-subtitle {
            font-size: 1rem;
            color: #cbd5f5;
            max-width: 480px;
        }

        body.theme-minimal .hero-subtitle {
            color: #4b5563;
        }

        .pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 4px 12px;
            border-radius: 999px;
            background: rgba(15, 23, 42, 0.6);
            border: 1px solid rgba(148, 163, 184, 0.6);
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: .08em;
            margin-bottom: 12px;
        }

        body.theme-minimal .pill {
            background: #e5e7eb;
            border-color: #d1d5db;
            color: #111827;
        }

        body.theme-cyberpunk .pill {
            background: rgba(17, 24, 39, 0.8);
            border-color: rgba(236, 72, 153, 0.6);
            color: #f9a8d4;
        }

        .levels {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            margin-top: 24px;
        }

        .level-card {
            background: rgba(15, 23, 42, 0.9);
            border-radius: 16px;
            padding: 16px 18px;
            border: 1px solid rgba(148, 163, 184, 0.4);
            box-shadow: 0 18px 40px rgba(15, 23, 42, 0.7);
        }

        body.theme-minimal .level-card {
            background: #ffffff;
            border-color: #e5e7eb;
            box-shadow: 0 8px 20px rgba(15, 23, 42, 0.08);
        }

        body.theme-cyberpunk .level-card {
            background: rgba(17, 24, 39, 0.95);
            border-color: rgba(236, 72, 153, 0.7);
            box-shadow: 0 22px 40px rgba(88, 28, 135, 0.85);
        }

        .level-header {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            margin-bottom: 6px;
        }

        .level-name {
            font-size: 1.25rem;
            font-weight: 700;
        }

        .level-badge {
            font-size: 0.7rem;
            padding: 3px 8px;
            border-radius: 999px;
            background: rgba(56, 189, 248, 0.15);
            border: 1px solid rgba(56, 189, 248, 0.5);
            text-transform: uppercase;
        }

        .level-meta {
            font-size: 0.85rem;
            color: #9ca3af;
            margin-bottom: 12px;
        }

        body.theme-minimal .level-meta {
            color: #6b7280;
        }

        .btn-play {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 8px 14px;
            border-radius: 999px;
            border: none;
            background: linear-gradient(135deg, #22c55e, #22d3ee);
            font-weight: 600;
            font-size: 0.9rem;
            cursor: pointer;
            text-decoration: none;
            color: #0b1120;
            margin-top: 4px;
        }

        .btn-play:hover {
            filter: brightness(1.05);
        }

        .scores-wrapper {
            margin-top: 40px;
            background: rgba(15, 23, 42, 0.9);
            border-radius: 16px;
            padding: 18px 20px;
            border: 1px solid rgba(148, 163, 184, 0.4);
        }

        body.theme-minimal .scores-wrapper {
            background: #ffffff;
            border-color: #e5e7eb;
            box-shadow: 0 8px 20px rgba(15, 23, 42, 0.08);
        }

        .scores-header {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            margin-bottom: 12px;
        }

        .scores-header h2 {
            margin: 0;
            font-size: 1.2rem;
        }

        .score-grids {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 16px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.8rem;
        }

        th,
        td {
            padding: 4px 6px;
            text-align: left;
        }

        th {
            font-weight: 600;
            border-bottom: 1px solid rgba(148, 163, 184, 0.5);
        }

        tr:nth-child(even) td {
            background: rgba(15, 23, 42, 0.8);
        }

        body.theme-minimal tr:nth-child(even) td {
            background: #f9fafb;
        }

        .empty-state {
            font-size: 0.8rem;
            color: #9ca3af;
            font-style: italic;
        }

        body.theme-minimal .empty-state {
            color: #6b7280;
        }

        .jarak {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
        }

        .theme-selector {
            margin: 10px 0 18px;
            font-size: 0.8rem;
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        .theme-btn {
            padding: 4px 10px;
            border-radius: 999px;
            border: 1px solid rgba(148, 163, 184, 0.6);
            background: rgba(15, 23, 42, 0.8);
            color: #e5e7eb;
            cursor: pointer;
            font-size: 0.8rem;
        }

        .theme-btn.active-theme {
            border-color: #22c55e;
            box-shadow: 0 0 0 1px rgba(34, 197, 94, 0.7);
        }

        body.theme-minimal .theme-btn {
            background: #e5e7eb;
            color: #111827;
        }

        /* Music toggle */
        #musicToggle {
            position: fixed;
            right: 20px;
            bottom: 20px;
            padding: 8px 14px;
            font-size: 0.85rem;
            background: rgba(15, 23, 42, 0.8);
            border: 1px solid rgba(148, 163, 184, 0.6);
            border-radius: 999px;
            cursor: pointer;
            color: #f1f5f9;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        body.theme-minimal #musicToggle {
            background: #111827;
            color: #f9fafb;
        }

        /* ===== AUTH AREA (Login/Register responsive) ===== */

        .auth-wrapper {
            display: flex;
            align-items: center;
            gap: 8px;
            position: relative;
        }

        .auth-desktop {
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .auth-link-login {
            color: #a5b4fc;
            text-decoration: none;
            font-size: 0.85rem;
            margin-right: 4px;
        }

        .auth-link-register {
            padding: 4px 10px;
            border-radius: 999px;
            border: none;
            background: #22c55e;
            color: #0b1120;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.85rem;
        }

        /* Mobile icon */
        .auth-mobile {
            display: none;
            position: relative;
        }

        .auth-icon-btn {
            border-radius: 999px;
            border: 1px solid rgba(148, 163, 184, 0.9);
            background: rgba(15, 23, 42, 0.9);
            color: #e5e7eb;
            width: 36px;
            height: 36px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 1.1rem;
        }

        body.theme-minimal .auth-icon-btn {
            background: #111827;
            color: #f9fafb;
        }

        .auth-dropdown {
            position: absolute;
            right: 0;
            top: 115%;
            background: rgba(15, 23, 42, 0.98);
            border-radius: 12px;
            border: 1px solid rgba(148, 163, 184, 0.7);
            min-width: 140px;
            padding: 6px 0;
            box-shadow: 0 15px 30px rgba(15, 23, 42, 0.9);
            display: none;
            z-index: 30;
        }

        body.theme-minimal .auth-dropdown {
            background: #ffffff;
            border-color: #e5e7eb;
            box-shadow: 0 10px 25px rgba(15, 23, 42, 0.15);
        }

        .auth-dropdown a {
            display: block;
            padding: 6px 12px;
            font-size: 0.85rem;
            color: #e5e7eb;
            text-decoration: none;
        }

        body.theme-minimal .auth-dropdown a {
            color: #111827;
        }

        .auth-dropdown a:hover {
            background: rgba(55, 65, 81, 0.8);
        }

        body.theme-minimal .auth-dropdown a:hover {
            background: #f3f4f6;
        }

        .auth-dropdown.open {
            display: block;
        }

        /* RESPONSIVE: di mobile pakai icon, di desktop pakai teks biasa */
        @media (max-width: 640px) {
            .auth-desktop {
                display: none;
            }

            .auth-mobile {
                display: inline-flex;
            }
        }
    </style>
</head>

<body id="body" class="theme-dark-neon">
    <div class="container">
        <div class="jarak">
            <div class="pill">
                <span>🧠 Memory Flip Card</span>
                <span>★ Waktu = Poin</span>
            </div>
            <div class="jarak">
                <div class="pill">
                    <span>🧠 Memory Flip Card</span>
                    <span>★ Waktu = Poin</span>
                </div>
                <div class="auth-wrapper">
                    @auth
                        <span>Hi, <strong>{{ auth()->user()->name }}</strong></span>
                        <form action="{{ route('logout') }}" method="POST" style="margin:0; display:inline-block;">
                            @csrf
                            <button type="submit"
                                style="padding:4px 10px;border-radius:999px;border:none;background:#ef4444;color:#fff;cursor:pointer;font-size:0.8rem;">
                                Logout
                            </button>
                        </form>
                    @else
                        {{-- Desktop: teks Login / Register biasa --}}
                        <div class="auth-desktop">
                            <a href="{{ route('login') }}" class="auth-link-login">Login</a>
                            <a href="{{ route('register') }}" class="auth-link-register">Register</a>
                        </div>

                        {{-- Mobile: ikon profil + dropdown --}}
                        <div class="auth-mobile">
                            <button type="button" class="auth-icon-btn" id="authToggle" aria-label="Auth menu">
                                👤
                            </button>
                            <div class="auth-dropdown" id="authDropdown">
                                <a href="{{ route('login') }}">Login</a>
                                <a href="{{ route('register') }}">Register</a>
                            </div>
                        </div>
                    @endauth
                </div>
            </div>

        </div>

        {{-- Theme Selector --}}
        <div class="theme-selector">
            <span style="color:#9ca3af;">Theme:</span>
            <button type="button" class="theme-btn" data-theme="theme-dark-neon">Dark Neon</button>
            <button type="button" class="theme-btn" data-theme="theme-cyberpunk">Cyberpunk</button>
        </div>

        <header class="hero">
            <div>
                <h1 class="hero-title">Latih fokus & kecepatanmu.</h1>
                <p class="hero-subtitle">
                    Cocokkan pasangan kartu secepat mungkin. Setiap level punya jumlah kartu yang berbeda.
                    Poin dihitung dari waktu penyelesaian game — semakin cepat, semakin tinggi skor kamu.
                </p>
                <div class="levels">
                    <div class="level-card">
                        <div class="level-header">
                            <div class="level-name">Easy</div>
                            <div class="level-badge">20 kartu</div>
                        </div>
                        <div class="level-meta">
                            10 pasang kartu. Cocok untuk pemanasan dan user baru.
                        </div>
                        <a href="{{ route('memory.index', ['level' => 'easy']) }}" class="btn-play">
                            Mulai Easy
                        </a>
                    </div>
                    <div class="level-card">
                        <div class="level-header">
                            <div class="level-name">Medium</div>
                            <div class="level-badge">30 kartu</div>
                        </div>
                        <div class="level-meta">
                            15 pasang kartu. Butuh fokus lebih dan hafalan yang kuat.
                        </div>
                        <a href="{{ route('memory.index', ['level' => 'medium']) }}" class="btn-play">
                            Mulai Medium
                        </a>
                    </div>
                    <div class="level-card">
                        <div class="level-header">
                            <div class="level-name">Hard</div>
                            <div class="level-badge">50 kartu</div>
                        </div>
                        <div class="level-meta">
                            25 pasang kartu. Mode hardcore untuk yang mau tantangan maksimal.
                        </div>
                        <a href="{{ route('memory.index', ['level' => 'hard']) }}" class="btn-play">
                            Mulai Hard
                        </a>
                    </div>
                </div>
            </div>
            <div>
                {{-- Cara Bermain (placeholder menuju /rules) --}}
                <div
                    style="
            background: rgba(15,23,42,0.9);
            border-radius: 18px;
            padding: 16px 18px;
            border: 1px solid rgba(148,163,184,0.5);
            box-shadow: 0 22px 60px rgba(15,23,42,0.9);
        ">
                    <div style="font-size:0.8rem; color:#9ca3af; margin-bottom:6px;">
                        Panduan singkat
                    </div>

                    <h2 style="font-size:1.1rem; margin:0 0 8px; font-weight:600;">
                        Cara Bermain Memory Flip Card
                    </h2>

                    <p style="font-size:0.9rem; color:#e5e7eb; margin:0 0 10px;">
                        Cocokkan pasangan kartu dengan mengingat posisi setiap kartu.
                        Setiap level punya jumlah kartu dan tingkat kesulitan yang berbeda.
                    </p>

                    <ul style="font-size:0.85rem; color:#9ca3af; padding-left:18px; margin:0 0 14px;">
                        <li>Balik dua kartu untuk mencari pasangan yang sama.</li>
                        <li>Jika salah, kartu akan tertutup kembali.</li>
                        <li>Skor ditentukan dari kecepatan menyelesaikan level.</li>
                    </ul>

                    <p style="font-size:0.8rem; color:#9ca3af; margin:0 0 12px;">
                        Halaman ini hanya placeholder. Aturan lengkap akan ada di halaman khusus.
                    </p>

                    <a href="{{ url('/rules') }}"
                        style="
                display:inline-flex;
                align-items:center;
                justify-content:center;
                gap:6px;
                padding:8px 14px;
                border-radius:999px;
                background:linear-gradient(135deg,#22c55e,#22d3ee);
                color:#0b1120;
                font-size:0.85rem;
                font-weight:600;
                text-decoration:none;
           ">
                        Lihat Aturan Lengkap
                    </a>
                </div>
            </div>
        </header>

        <section class="scores-wrapper">
            <div class="scores-header">
                <h2>High Score Terbaru</h2>
                <span style="font-size:0.8rem; color:#9ca3af;">
                    Top 5 skor tertinggi per level (poin terbesar & waktu tercepat)
                </span>
            </div>

            <div class="score-grids">
                {{-- EASY --}}
                <div>
                    <h3 style="font-size:0.95rem; margin-bottom:4px;">Easy</h3>
                    @php
                        $easyScores = $bestEasy->where('points', '>', 0);
                    @endphp

                    @if ($easyScores->isEmpty())
                        <div class="empty-state">Belum ada skor. Jadilah yang pertama!</div>
                    @else
                        <table>
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Player</th>
                                    <th>Waktu (detik)</th>
                                    <th>Poin</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($easyScores as $i => $score)
                                    <tr>
                                        <td>{{ $i + 1 }}</td>
                                        <td>{{ $score->user?->name ?? 'Guest' }}</td>
                                        <td>{{ number_format($score->time_seconds, 1) }}</td>
                                        <td>{{ $score->points }}</td>
                                        <td>{{ $score->created_at->format('d/m H:i') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>

                {{-- MEDIUM --}}
                <div>
                    <h3 style="font-size:0.95rem; margin-bottom:4px;">Medium</h3>
                    @php
                        $mediumScores = $bestMedium->where('points', '>', 0);
                    @endphp

                    @if ($mediumScores->isEmpty())
                        <div class="empty-state">Belum ada skor di level ini.</div>
                    @else
                        <table>
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Player</th>
                                    <th>Waktu (detik)</th>
                                    <th>Poin</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($mediumScores as $i => $score)
                                    <tr>
                                        <td>{{ $i + 1 }}</td>
                                        <td>{{ $score->user?->name ?? 'Guest' }}</td>
                                        <td>{{ number_format($score->time_seconds, 1) }}</td>
                                        <td>{{ $score->points }}</td>
                                        <td>{{ $score->created_at->format('d/m H:i') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>

                {{-- HARD --}}
                <div>
                    <h3 style="font-size:0.95rem; margin-bottom:4px;">Hard</h3>
                    @php
                        $hardScores = $bestHard->where('points', '>', 0);
                    @endphp

                    @if ($hardScores->isEmpty())
                        <div class="empty-state">Belum ada skor di level ini.</div>
                    @else
                        <table>
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Player</th>
                                    <th>Waktu (detik)</th>
                                    <th>Poin</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($hardScores as $i => $score)
                                    <tr>
                                        <td>{{ $i + 1 }}</td>
                                        <td>{{ $score->user?->name ?? 'Guest' }}</td>
                                        <td>{{ number_format($score->time_seconds, 1) }}</td>
                                        <td>{{ $score->points }}</td>
                                        <td>{{ $score->created_at->format('d/m H:i') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>


        </section>
    </div>

    <!-- MUSIC -->
    <audio id="landingMusic" loop>
        <source src="{{ asset('audio/mmry.mp3') }}" type="audio/mpeg">
    </audio>

    <button id="musicToggle">
        <span id="musicIcon">🔊</span>
        <span id="musicLabel">Music: ON</span>
    </button>

    <script>
        // ===== AUTH DROPDOWN (mobile) =====
        const authToggle = document.getElementById('authToggle');
        const authDropdown = document.getElementById('authDropdown');

        if (authToggle && authDropdown) {
            authToggle.addEventListener('click', (e) => {
                e.stopPropagation();
                authDropdown.classList.toggle('open');
            });

            // klik di luar dropdown -> tutup
            document.addEventListener('click', () => {
                authDropdown.classList.remove('open');
            });
        }

        // THEME SWITCHER
        const bodyEl = document.getElementById('body');
        const themeBtns = document.querySelectorAll('.theme-btn');
        let savedTheme = localStorage.getItem('memoryTheme') || 'theme-dark-neon';

        function applyTheme(theme) {
            bodyEl.classList.remove('theme-dark-neon', 'theme-cyberpunk', 'theme-minimal');
            bodyEl.classList.add(theme);

            themeBtns.forEach(btn => {
                if (btn.dataset.theme === theme) {
                    btn.classList.add('active-theme');
                } else {
                    btn.classList.remove('active-theme');
                }
            });

            localStorage.setItem('memoryTheme', theme);
        }

        applyTheme(savedTheme);

        themeBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                applyTheme(btn.dataset.theme);
            });
        });

        // MUSIC CONTROLLER
        const musicEl = document.getElementById('landingMusic');
        const toggleBtn = document.getElementById('musicToggle');
        const icon = document.getElementById('musicIcon');
        const label = document.getElementById('musicLabel');

        let muted = localStorage.getItem('memoryMusicMuted') === 'true';

        function applyMusicState() {
            musicEl.muted = muted;
            if (!muted && musicEl.paused) {
                musicEl.play().catch(() => {});
            }
            icon.textContent = muted ? '🔇' : '🔊';
            label.textContent = muted ? 'Music: OFF' : 'Music: ON';
        }

        applyMusicState();

        toggleBtn.addEventListener('click', () => {
            muted = !muted;
            localStorage.setItem('memoryMusicMuted', muted ? 'true' : 'false');
            applyMusicState();
        });

        // Mulai musik setelah ada interaksi user
        const userInteractionEvents = ['click', 'keydown', 'touchstart', 'scroll'];

        function enableMusicOnce() {
            if (!muted && musicEl.paused) {
                musicEl.play().catch(() => {});
            }
            userInteractionEvents.forEach(evt =>
                document.removeEventListener(evt, enableMusicOnce)
            );
        }
        userInteractionEvents.forEach(evt =>
            document.addEventListener(evt, enableMusicOnce)
        );
    </script>
</body>

</html>
