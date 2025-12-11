<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - Memory Game</title>
</head>
<body style="font-family:system-ui;background:#0f172a;color:#e5e7eb;display:flex;align-items:center;justify-content:center;min-height:100vh;">
<div style="background:#111827;padding:24px 28px;border-radius:16px;width:320px;">
    <h1 style="margin-top:0;margin-bottom:12px;font-size:1.4rem;">Login</h1>

    @if($errors->any())
        <div style="background:#7f1d1d;padding:8px 10px;border-radius:8px;font-size:0.85rem;margin-bottom:10px;">
            {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('login.post') }}" method="POST">
        @csrf
        <div style="margin-bottom:10px;">
            <label>Email</label><br>
            <input type="email" name="email" value="{{ old('email') }}" required
                   style="width:100%;padding:6px 8px;border-radius:8px;border:1px solid #4b5563;background:#020617;color:#e5e7eb;">
        </div>
        <div style="margin-bottom:10px;">
            <label>Password</label><br>
            <input type="password" name="password" required
                   style="width:100%;padding:6px 8px;border-radius:8px;border:1px solid #4b5563;background:#020617;color:#e5e7eb;">
        </div>
        <div style="margin-bottom:10px;font-size:0.85rem;">
            <label>
                <input type="checkbox" name="remember"> Remember me
            </label>
        </div>
        <button type="submit" style="
            width:100%;
            padding:8px 0;
            border-radius:999px;
            border:none;
            background:linear-gradient(135deg,#22c55e,#22d3ee);
            color:#0b1120;
            font-weight:600;
            cursor:pointer;
        ">
            Login
        </button>
    </form>

    <p style="margin-top:12px;font-size:0.85rem;">
        Belum punya akun?
        <a href="{{ route('register') }}" style="color:#a5b4fc;">Register</a>
    </p>
    <p style="margin-top:4px;font-size:0.8rem;">
        <a href="{{ route('memory.landing') }}" style="color:#9ca3af;">← Kembali ke Landing</a>
    </p>
</div>
</body>
</html>
