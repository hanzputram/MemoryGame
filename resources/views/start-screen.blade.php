<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Memory Game — Start</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            height: 100vh;
            background: radial-gradient(circle at center, #1e293b, #0f172a 60%);
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: "Consolas", monospace;
            overflow: hidden;
            color: #e5e7eb;
        }

        .wrapper {
            text-align: center;
            animation: fadeIn 1.5s ease-out;
        }

        h1 {
            font-size: 3rem;
            color: #38bdf8;
            letter-spacing: 4px;
            text-shadow: 0 0 12px rgba(56, 189, 248, 0.75);
            margin-bottom: 30px;
        }

        .prompt {
            color: #e5e7eb;
            font-size: 1.2rem;
            opacity: 0;
            animation: blink 1.2s infinite ease-in-out alternate;
            letter-spacing: 3px;
        }

        .fadeout {
            animation: fadeOut 0.6s forwards;
        }

        @keyframes blink {
            from {
                opacity: 0.2;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.96);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes fadeOut {
            from {
                opacity: 1;
            }

            to {
                opacity: 0;
                transform: scale(1.08);
            }
        }

        /* Tombol mute */
        .music-toggle {
            position: fixed;
            right: 16px;
            bottom: 16px;
            padding: 6px 12px;
            border-radius: 999px;
            border: 1px solid rgba(148, 163, 184, 0.6);
            background: rgba(15, 23, 42, 0.9);
            color: #e5e7eb;
            font-size: 0.8rem;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .music-toggle span.icon {
            font-size: 1rem;
        }
    </style>
</head>

<body>

    <div class="wrapper" id="startScreen">
        <h1>MEMORY GAME</h1>
        <div class="prompt">PRESS <strong>SPACE</strong> TO START</div>
    </div>

    <!-- Audio -->
    <audio id="bgMusic" loop>
        <source src="{{ asset('audio/mmry.mp3') }}" type="audio/mpeg">
    </audio>

    <button class="music-toggle" id="musicToggle">
        <span class="icon" id="musicIcon">🔊</span>
        <span id="musicLabel">Music: ON</span>
    </button>

    <script>
        const startScreen = document.getElementById('startScreen');
        const bgMusic = document.getElementById('bgMusic');
        const musicToggle = document.getElementById('musicToggle');
        const musicIcon = document.getElementById('musicIcon');
        const musicLabel = document.getElementById('musicLabel');

        let isMuted = localStorage.getItem('memoryGameMuted') === 'true';

        function applyMuteState() {
            bgMusic.muted = isMuted;
            musicIcon.textContent = isMuted ? '🔇' : '🔊';
            musicLabel.textContent = isMuted ? 'Music: OFF' : 'Music: ON';
        }
        applyMuteState();

        musicToggle.addEventListener('click', () => {
            isMuted = !isMuted;
            localStorage.setItem('memoryGameMuted', isMuted);
            applyMuteState();
            if (!isMuted && bgMusic.paused) bgMusic.play().catch(() => {});
        });

        // Start music (allowed after user interaction)
        const userActivationEvents = ['click', 'keydown', 'touchstart'];

        function activateMusic() {
            if (!isMuted && bgMusic.paused) bgMusic.play().catch(() => {});
            userActivationEvents.forEach(e => document.removeEventListener(e, activateMusic));
        }
        userActivationEvents.forEach(e => document.addEventListener(e, activateMusic));

        // Trigger NEXT PAGE ONLY when SPACE pressed
        document.addEventListener('keydown', (e) => {
            if (e.code === 'Space') {
                startScreen.classList.add('fadeout');
                setTimeout(() => {
                    window.location.href = "{{ route('memory.landing') }}";
                }, 600);
            }
        });
    </script>

</body>

</html>
