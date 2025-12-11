<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Memory Flip Card - {{ ucfirst($level) }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        /* ================= GLOBAL ================= */
        body {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background: #0f172a;
            color: #e5e7eb;
            margin: 0;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        a.back-link {
            color: #a5b4fc;
            font-size: 0.95rem;
            text-decoration: none;
            margin-bottom: 8px;
            text-align: center;
        }

        h1 {
            margin-bottom: 0.8rem;
            text-align: center;
            font-size: clamp(1.3rem, 3vw, 2rem);
        }

        /* ================= INFO BAR ================= */
        .info-bar {
            display: flex;
            gap: 1rem;
            align-items: center;
            margin-bottom: 1rem;
            flex-wrap: wrap;
            justify-content: center;
            text-align: center;
        }

        .badge {
            padding: 6px 12px;
            border-radius: 999px;
            background: #1f2937;
            font-size: clamp(0.7rem, 1.8vw, 0.9rem);
            text-transform: uppercase;
            letter-spacing: .08em;
        }

        .btn {
            padding: 8px 16px;
            border-radius: 999px;
            background: #22c55e;
            border: none;
            font-weight: 600;
            cursor: pointer;
            font-size: clamp(0.8rem, 2vw, 1rem);
        }

        .btn:hover {
            filter: brightness(1.05);
        }

        /* ================= GAME GRID RESPONSIVE ================= */
        .game-container {
            display: grid;
            gap: 10px;
            justify-content: center;
            max-width: 100%;
            padding: 10px;
        }

        .game-container.easy {
            grid-template-columns: repeat(auto-fit, minmax(70px, 1fr));
            max-width: 500px;
        }

        .game-container.medium {
            grid-template-columns: repeat(auto-fit, minmax(65px, 1fr));
            max-width: 650px;
        }

        .game-container.hard {
            grid-template-columns: repeat(auto-fit, minmax(55px, 1fr));
            max-width: 900px;
        }

        /* ================= CARD ================= */
        .card {
            width: 100%;
            padding-top: 130%;
            position: relative;
            perspective: 900px;
            cursor: pointer;
        }

        .card-inner {
            position: absolute;
            inset: 0;
            transform-style: preserve-3d;
            transition: transform 0.4s ease;
        }

        .card.flipped .card-inner {
            transform: rotateY(180deg);
        }

        .card-face {
            position: absolute;
            inset: 0;
            border-radius: 8px;
            backface-visibility: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: clamp(0.8rem, 3.5vw, 1.4rem);
            font-weight: 600;
        }

        .card-back {
            background: linear-gradient(135deg, #22c55e, #22d3ee);
            border: 2px solid #a7f3d0;
        }

        .card-front {
            background: #111827;
            border: 2px solid #4b5563;
            transform: rotateY(180deg);
        }

        /* MATCH ANIMATION */
        .card.matched .card-inner {
            animation: pulse 0.5s ease;
        }

        @keyframes pulse {
            0% {
                transform: rotateY(180deg) scale(1);
            }

            50% {
                transform: rotateY(180deg) scale(1.08);
            }

            100% {
                transform: rotateY(180deg) scale(1);
            }
        }

        /* ================= RESULT BOX ================= */
        .result-box {
            margin-top: 16px;
            padding: 14px 18px;
            background: #1f2937;
            border-radius: 10px;
            max-width: 95%;
            text-align: center;
            font-size: clamp(0.9rem, 2vw, 1.1rem);
        }

        /* ================= MUSIC BUTTON ================= */
        #musicToggle {
            position: fixed;
            right: 14px;
            bottom: 14px;
            padding: 8px 14px;
            font-size: clamp(0.75rem, 2vw, 0.95rem);
            background: rgba(15, 23, 42, 0.85);
            border: 1px solid rgba(148, 163, 184, 0.6);
            border-radius: 999px;
            color: #f1f5f9;
            display: flex;
            align-items: center;
            gap: 6px;
            backdrop-filter: blur(4px);
        }

        /* ================= BREAKPOINTS ================= */
        @media (max-width: 430px) {
            .game-container.easy {
                grid-template-columns: repeat(auto-fit, minmax(55px, 1fr));
            }

            .game-container.medium {
                grid-template-columns: repeat(auto-fit, minmax(50px, 1fr));
            }

            .game-container.hard {
                grid-template-columns: repeat(auto-fit, minmax(45px, 1fr));
            }

            #musicToggle {
                right: 8px;
                bottom: 8px;
                padding: 6px 10px;
            }
        }

        @media (max-width: 768px) {
            .game-container.hard {
                max-width: 95vw;
            }
        }

        @media (min-width: 1400px) {
            .game-container.easy {
                max-width: 600px;
            }

            .game-container.medium {
                max-width: 800px;
            }

            .game-container.hard {
                max-width: 1100px;
            }

            .card-face {
                font-size: clamp(1.2rem, 2vw, 2rem);
            }
        }
    </style>
</head>

<body>
    <a href="{{ route('memory.landing') }}" class="back-link">← Kembali ke Landing Page</a>

    <h1>Memory Flip Card - {{ ucfirst($level) }}</h1>

    <div class="info-bar">
        <span class="badge">Level: {{ ucfirst($level) }}</span>
        <span class="badge">Cards: {{ $totalCards }}</span>
        <span>Waktu: <span id="time-display">0.0</span> detik</span>
        <button class="btn" onclick="restartGame()">Restart</button>
    </div>

    <div class="game-container {{ $level }}">
        @foreach ($cards as $index => $value)
            <div class="card" data-index="{{ $index }}" data-value="{{ $value }}">
                <div class="card-inner">
                    <div class="card-face card-back">?</div>
                    <div class="card-face card-front">{{ $value }}</div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="status-bar">
        <span>Pasangan ditemukan: <span id="matched-count">0</span> / {{ $totalCards / 2 }}</span>
    </div>

    <div id="result" class="result-box" style="display:none;"></div>

    <!-- 🎵 GAME MUSIC -->
    <audio id="gameMusic" loop>
        <source src="{{ asset('audio/mmry.mp3') }}" type="audio/mpeg">
    </audio>

    <!-- 🎛 TOGGLE -->
    <button id="musicToggle">
        <span id="musicIcon">🔊</span>
        <span id="musicLabel">Music: ON</span>
    </button>

    <script>
        /** ================= GAME LOGIC ================= **/

        const cards = document.querySelectorAll('.card');
        const totalCards = {{ $totalCards }};
        const matchedDisplay = document.getElementById('matched-count');
        const timeDisplay = document.getElementById('time-display');
        const resultBox = document.getElementById('result');

        const GAME_LEVEL = '{{ $level }}';

        let firstCard = null;
        let secondCard = null;
        let lockBoard = false;
        let matchedPairs = 0;
        let gameFinished = false;

        let startTime = performance.now();
        let timerInterval = setInterval(() => {
            if (gameFinished) return;
            const now = performance.now();
            const elapsed = (now - startTime) / 1000;
            timeDisplay.textContent = elapsed.toFixed(1);
        }, 100);

        function flipCard() {
            if (lockBoard || gameFinished) return;
            if (this.classList.contains('flipped')) return;

            this.classList.add('flipped');

            if (!firstCard) {
                firstCard = this;
                return;
            }

            secondCard = this;
            checkForMatch();
        }

        function checkForMatch() {
            const isMatch = firstCard.dataset.value === secondCard.dataset.value;
            if (isMatch) {
                disableCards();
            } else {
                unflipCards();
            }
        }

        function disableCards() {
            firstCard.classList.add('matched');
            secondCard.classList.add('matched');

            firstCard.removeEventListener('click', flipCard);
            secondCard.removeEventListener('click', flipCard);

            matchedPairs++;
            matchedDisplay.textContent = matchedPairs;

            resetTurn();

            if (matchedPairs * 2 === totalCards) {
                finishGame();
            }
        }

        function unflipCards() {
            lockBoard = true;
            setTimeout(() => {
                firstCard.classList.remove('flipped');
                secondCard.classList.remove('flipped');
                resetTurn();
            }, 800);
        }

        function resetTurn() {
            [firstCard, secondCard] = [null, null];
            lockBoard = false;
        }

        function finishGame() {
            gameFinished = true;
            clearInterval(timerInterval);

            const endTime = performance.now();
            const elapsed = (endTime - startTime) / 1000;

            sendResultToServer(elapsed);
        }

        function sendResultToServer(elapsedSeconds) {
            const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch('/memory/finish', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrf,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        elapsed_seconds: elapsedSeconds,
                        level: GAME_LEVEL,
                    })
                })
                .then(async res => {
                    let data;
                    try {
                        data = await res.json();
                    } catch {
                        throw new Error('Response bukan JSON');
                    }

                    resultBox.style.display = 'block';

                    if (data.success) {
                        resultBox.innerHTML = `
                <strong>🎉 Game Selesai!</strong><br>
                Level: ${data.level}<br>
                Waktu: ${data.elapsed_seconds.toFixed(1)} detik<br>
                Point: ${data.points}
            `;
                    } else {
                        resultBox.innerHTML = data.message || 'Terjadi kesalahan saat menyimpan skor.';
                    }
                })
                .catch(() => {
                    resultBox.style.display = 'block';
                    resultBox.innerHTML = '❌ Terjadi kesalahan koneksi ke server.';
                });
        }

        function restartGame() {
            window.location.reload();
        }

        cards.forEach(card => card.addEventListener('click', flipCard));

        /** ================= MUSIC CONTROLLER ================= **/

        const music = document.getElementById('gameMusic');
        const toggleBtn = document.getElementById('musicToggle');
        const musicIcon = document.getElementById('musicIcon');
        const musicLabel = document.getElementById('musicLabel');

        let muted = localStorage.getItem('memoryMusicMuted') === 'true';

        function applyMusicState() {
            music.muted = muted;
            if (!muted && music.paused) music.play().catch(() => {});
            musicIcon.textContent = muted ? '🔇' : '🔊';
            musicLabel.textContent = muted ? 'Music: OFF' : 'Music: ON';
        }

        applyMusicState();

        toggleBtn.onclick = () => {
            muted = !muted;
            localStorage.setItem('memoryMusicMuted', muted);
            applyMusicState();
        };

        // Autoplay after first interaction
        ['click', 'keydown', 'touchstart', 'scroll'].forEach(evt => {
            document.addEventListener(evt, () => {
                if (!muted && music.paused) {
                    music.play().catch(() => {});
                }
            }, {
                once: true
            });
        });
    </script>
</body>

</html>
