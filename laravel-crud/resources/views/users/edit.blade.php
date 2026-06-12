<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Account</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 2rem; background: #0f172a; color: #e5eefb; }
        .card { background: #111827; border: 1px solid #334155; border-radius: 14px; padding: 1rem; max-width: 720px; }
        label { display:block; margin-top: 0.75rem; color: #bfdbfe; }
        input { width: 100%; box-sizing: border-box; padding: 0.6rem; border-radius: 8px; border: 1px solid #334155; background: #020617; color: #eff6ff; margin-bottom: 0.5rem; }
        .btn { display: inline-block; padding: 0.55rem 0.9rem; border-radius: 8px; border: 1px solid #38bdf8; color: #eff6ff; background: #1e293b; margin-top: 1rem; cursor: pointer; text-decoration: none; }
        .btn.primary { background: #2563eb; border-color: #2563eb; }
        .error { color: #fecaca; font-size: 0.92rem; }
    </style>
</head>
<body>
    <div class="card">
        <h1>Edit Account Details</h1>
        <form action="{{ route('users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')

            <label for="name">Username / Name</label>
            <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required>
            @error('name')<div class="error">{{ $message }}</div>@enderror

            <label for="email">Email Address</label>
            <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required>
            @error('email')<div class="error">{{ $message }}</div>@enderror

            <label for="password">New Password (leave blank to keep current)</label>
            <input id="password" name="password" type="password">
            @error('password')<div class="error">{{ $message }}</div>@enderror

            <label for="password_confirmation">Confirm New Password</label>
            <input id="password_confirmation" name="password_confirmation" type="password">

            <button class="btn primary" type="submit">Update Account</button>
            <a class="btn" href="{{ route('users.index') }}">Cancel</a>
        </form>
    </div>
</body>
</html>