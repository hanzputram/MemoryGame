<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Memory Game</title>

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

        label {
            font-size: 0.9rem;
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
            font-size: 0.9rem;
            margin-top: 10px;
            text-align: center;
        }

        a {
            color: #a5b4fc;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .small-link {
            margin-top: 6px;
            font-size: 0.82rem;
            color: #9ca3af;
        }

        /* Responsiveness for very small devices */
        @media (max-width: 360px) {
            .container {
                padding: 18px 20px;
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
    <h1>Login</h1>

    @if($errors->any())
        <div class="error">
            {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('login.post') }}" method="POST">
        @csrf

        <div style="margin-bottom: 12px;">
            <label>Email</label><br>
            <input type="email" name="email" value="{{ old('email') }}" required>
        </div>

        <div style="margin-bottom: 12px;">
            <label>Password</label><br>
            <input type="password" name="password" required>
        </div>

        <div style="margin-bottom: 14px; font-size: 0.85rem;">
            <label>
                <input type="checkbox" name="remember"> Remember me
            </label>
        </div>

        <button type="submit">Login</button>
    </form>

    <p>
        Belum punya akun?
        <a href="{{ route('register') }}">Register</a>
    </p>
    <p class="small-link">
        <a href="{{ route('memory.landing') }}">← Kembali ke Landing</a>
    </p>
</div>

</body>
</html>
