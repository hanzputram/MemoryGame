<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Rules & Cara Bermain - Memory Flip Card</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 24px;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background: radial-gradient(circle at top, #1d4ed8, #020617 55%);
            color: #e5e7eb;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            background: rgba(15, 23, 42, 0.92);
            border-radius: 18px;
            padding: 20px 22px 28px;
            border: 1px solid rgba(148, 163, 184, 0.4);
            box-shadow: 0 18px 50px rgba(15, 23, 42, 0.9);
        }

        a.back-link {
            color: #a5b4fc;
            font-size: 0.85rem;
            text-decoration: none;
            display: inline-block;
            margin-bottom: 10px;
        }

        h1 {
            margin: 0 0 4px;
            font-size: 1.8rem;
        }

        .subtitle {
            font-size: 0.9rem;
            color: #9ca3af;
            margin-bottom: 16px;
        }

        h2 {
            font-size: 1.2rem;
            margin-top: 18px;
            margin-bottom: 6px;
        }

        h3 {
            font-size: 1rem;
            margin-top: 14px;
            margin-bottom: 4px;
        }

        p {
            font-size: 0.9rem;
            line-height: 1.5;
            margin: 4px 0 8px;
        }

        ul {
            font-size: 0.9rem;
            margin: 4px 0 10px 20px;
            padding-left: 0;
        }

        li {
            margin-bottom: 4px;
        }

        code {
            background: #020617;
            padding: 2px 6px;
            border-radius: 6px;
            font-size: 0.8rem;
        }

        .pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 4px 10px;
            border-radius: 999px;
            background: rgba(15, 23, 42, 0.7);
            border: 1px solid rgba(148, 163, 184, 0.6);
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: .08em;
            margin-bottom: 10px;
        }

        .levels-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 10px;
            margin-top: 8px;
        }

        .level-card {
            background: rgba(15, 23, 42, 0.95);
            border-radius: 12px;
            padding: 10px 12px;
            border: 1px solid rgba(148, 163, 184, 0.5);
            font-size: 0.85rem;
        }

        .level-card strong {
            display: block;
            margin-bottom: 2px;
        }

        .note {
            font-size: 0.8rem;
            color: #9ca3af;
            font-style: italic;
        }

        .btn-primary {
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
            margin-top: 12px;
        }

        hr {
            border: none;
            border-top: 1px solid rgba(55, 65, 81, 0.9);
            margin: 12px 0 16px;
        }
    </style>
</head>

<body>
    <div class="container">
        <a href="{{ route('memory.landing') }}" class="back-link">← Kembali ke Game</a>

        <div class="pill">
            <span>🧠 Memory Flip Card</span>
            <span>Rules & Cara Bermain</span>
        </div>

        <h1>Aturan & Cara Bermain</h1>
        <p class="subtitle">
            Halaman ini menjelaskan cara kerja game, perhitungan poin, dan aturan leaderboard
            agar semua pemain bermain dengan adil.
        </p>

        <h2>1. Tujuan Game</h2>
        <p>
            Tujuan utama <strong>Memory Flip Card</strong> adalah menemukan semua pasangan kartu
            yang sama dalam waktu sesingkat mungkin. Semakin cepat kamu menyelesaikan level,
            semakin besar poin yang kamu dapatkan.
        </p>

        <h2>2. Cara Bermain</h2>
        <ul>
            <li>Klik salah satu kartu untuk membalik dan melihat isinya.</li>
            <li>Kemudian klik kartu kedua untuk mencoba mencari pasangan yang sama.</li>
            <li>
                Jika <strong>angka kedua kartu sama</strong>, pasangan tersebut akan tetap terbuka
                dan dihitung sebagai <em>matched</em>.
            </li>
            <li>
                Jika <strong>angka tidak sama</strong>, kedua kartu akan tertutup kembali
                setelah animasi singkat dan kamu bisa mencoba lagi.
            </li>
            <li>Game berakhir ketika semua pasangan kartu sudah ditemukan.</li>
            <li>Timer berjalan otomatis sejak level dimulai, dan berhenti saat level selesai.</li>
        </ul>

        <h2>3. Level & Jumlah Kartu</h2>
        <div class="levels-grid">
            <div class="level-card">
                <strong>Easy</strong>
                <div>• 20 kartu (10 pasang)</div>
                <div>• Cocok untuk pemanasan & pemain baru</div>
            </div>
            <div class="level-card">
                <strong>Medium</strong>
                <div>• 30 kartu (15 pasang)</div>
                <div>• Butuh fokus lebih & daya ingat yang baik</div>
            </div>
            <div class="level-card">
                <strong>Hard</strong>
                <div>• 50 kartu (25 pasang)</div>
                <div>• Mode tantangan untuk pemain yang sudah mahir</div>
            </div>
        </div>

        <h2>4. Sistem Poin</h2>
        <p>
            Poin dihitung berdasarkan kecepatan kamu menyelesaikan game.
            Rumus yang digunakan saat ini:
        </p>
        <p>
            <code>poin = max(0, 1000 - (waktu_dalam_detik × 10))</code>
        </p>
        <ul>
            <li>Semakin cepat waktu selesai, nilai <code>1000 - (waktu × 10)</code> makin besar.</li>
            <li>Jika hasil perhitungan <strong>kurang dari 0</strong>, poin akan dianggap <strong>0</strong>.</li>
            <li>
                Contoh:
                <ul>
                    <li>Waktu 43,3 detik → poin = 1000 - 433 = <strong>567</strong></li>
                    <li>Waktu 86,7 detik → poin = 1000 - 867 = <strong>133</strong></li>
                    <li>Waktu 478 detik → poin = 1000 - 4780 (&lt; 0) → <strong>0 (tidak dihitung)</strong></li>
                </ul>
            </li>
        </ul>
        <p class="note">
            Hanya permainan yang selesai dan menghasilkan poin &gt; 0 yang akan
            muncul di leaderboard.
        </p>

        <h2>5. Leaderboard & High Score</h2>
        <ul>
            <li>Leaderboard menampilkan <strong>Top 5 skor tertinggi</strong> per level.</li>
            <li>Urutan ditentukan dari:
                <ul>
                    <li>Poin terbesar (lebih tinggi lebih baik).</li>
                    <li>Jika poin sama, waktu tercepat akan berada di posisi lebih atas.</li>
                </ul>
            </li>
            <li>
                Skor dengan poin <strong>0</strong> tidak akan ditampilkan di leaderboard
                (dianggap tidak valid / terlalu lama).
            </li>
            <li>Nama pemain diambil dari nama akun yang digunakan saat login.</li>
        </ul>

        <h2>6. Login & Penyimpanan Skor</h2>
        <ul>
            <li>Untuk bermain dan masuk leaderboard, kamu harus <strong>login / register</strong> terlebih dahulu.</li>
            <li>Setiap kali selesai satu game, hasil waktu & poin akan otomatis tersimpan di database.</li>
            <li>Skor bisa digunakan untuk melihat progres kamu dari waktu ke waktu.</li>
        </ul>

        <h2>7. Fair Play</h2>
        <ul>
            <li>Dilarang memanipulasi timer atau merubah script game di browser.</li>
            <li>Jika terdeteksi aktivitas mencurigakan, skor bisa dihapus dari leaderboard.</li>
            <li>Tujuan game ini adalah latihan fokus & memori, bukan sekadar mengejar angka.</li>
        </ul>

        <h2>8. Tips Bermain</h2>
        <ul>
            <li>Mulai dari level Easy untuk membiasakan pola dan animasi.</li>
            <li>Fokus pada area tertentu papan, jangan acak seluruh layar sekaligus.</li>
            <li>Ingat posisi kartu yang sering kamu buka meskipun belum menemukan pasangannya.</li>
            <li>Jika ingin mencoba waktu lebih cepat, gunakan tombol <strong>Restart</strong> di halaman game.</li>
        </ul>

        <hr>

        <p class="note">
            Aturan dapat diperbarui sewaktu-waktu jika ada penyesuaian sistem poin atau fitur baru
            (mode permainan tambahan, badge, achievement, dan lain-lain).
        </p>

        <a href="{{ route('memory.landing') }}" class="btn-primary">
            Kembali ke Halaman Game
        </a>
    </div>
</body>

</html>
