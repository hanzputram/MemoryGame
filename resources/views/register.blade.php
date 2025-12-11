<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Memory Game</title>

    <style>
        body {
            font-family: system-ui;
            background: #0f172a;
            color: #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            padding: 16px;
        }

        .container {
            background: #111827;
            padding: 24px 28px;
            border-radius: 16px;
            width: 100%;
            max-width: 360px;
            box-sizing: border-box;
        }

        h1 {
            margin-top: 0;
            margin-bottom: 12px;
            font-size: 1.6rem;
            text-align: center;
        }

        label {
            font-size: 0.9rem;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px 12px;
            border-radius: 8px;
            border: 1px solid #4b5563;
            background: #020617;
            color: #e5e7eb;
            font-size: 1rem;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 10px 0;
            border-radius: 999px;
            border: none;
            background: linear-gradient(135deg, #22c55e, #22d3ee);
            color: #0b1120;
            font-weight: 600;
            cursor: pointer;
            font-size: 1rem;
            margin-top: 6px;
        }

        .error {
            background: #7f1d1d;
            padding: 8px 10px;
            border-radius: 8px;
            font-size: 0.85rem;
            margin-bottom: 10px;
            text-align: center;
        }

        p {
            text-align: center;
            font-size: 0.9rem;
        }

        .small-link {
            margin-top: 6px;
            font-size: 0.82rem;
            color: #9ca3af;
        }

        a {
            color: #a5b4fc;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        /* Extra responsive tweaks untuk layar sangat kecil */
        @media (max-width: 360px) {
            .container {
                padding: 20px;
            }

            h1 {
                font-size: 1.4rem;
            }

            button {
                font-size: 0.9rem;
            }
        }
    </style>
</head>

<body>

<div class="container">
    <h1>Register</h1>

    @if($errors->any())
        <div class="error">
            {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('register.post') }}" method="POST">
        @csrf

        <div style="margin-bottom: 12px;">
            <label>Nama</label><br>
            <input type="text" name="name" value="{{ old('name') }}" required>
        </div>

        <div style="margin-bottom: 12px;">
            <label>Email</label><br>
            <input type="email" name="email" value="{{ old('email') }}" required>
        </div>

        <div style="margin-bottom: 12px;">
            <label>Password</label><br>
            <input type="password" name="password" required>
        </div>

        <div style="margin-bottom: 12px;">
            <label>Konfirmasi Password</label><br>
            <input type="password" name="password_confirmation" required>
        </div>

        <button type="submit">Register</button>
    </form>

    <p style="margin-top: 12px;">
        Sudah punya akun?
        <a href="{{ route('login') }}">Login</a>
    </p>

    <p class="small-link">
        <a href="{{ route('memory.landing') }}">← Kembali ke Landing</a>
    </p>
</div>

</body>
</html>
