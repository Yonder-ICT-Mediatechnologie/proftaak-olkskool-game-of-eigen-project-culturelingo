<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 2rem; background: #0f172a; color: #e5eefb; }
        a { color: #93c5fd; text-decoration: none; }
        .card { background: #111827; border: 1px solid #334155; border-radius: 14px; padding: 1rem; margin-bottom: 1rem; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border-bottom: 1px solid #334155; padding: 0.75rem; text-align: left; }
        .btn { display: inline-block; padding: 0.45rem 0.75rem; border-radius: 8px; border: 1px solid #38bdf8; color: #eff6ff; background: #1e293b; margin-right: 0.35rem; cursor: pointer; }
        .btn.primary { background: #2563eb; border-color: #2563eb; }
        .btn.danger { background: #991b1b; border-color: #991b1b; }
        .flash { padding: 0.75rem; border-radius: 8px; background: #14532d; color: #dcfce7; margin-bottom: 1rem; }
    </style>
</head>
<body>
    <div class="card">
        <h1>User Account Management</h1>
        <p>Review and manage active registered player accounts.</p>
        <a class="btn primary" href="{{ route('users.create') }}">Create New Account</a>
        <a class="btn" href="{{ route('cultures.index') }}">Go to Culture Management</a>
    </div>

    @if (session('success'))
        <div class="flash">{{ session('success') }}</div>
    @endif

    <div class="card">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->created_at }}</td>
                        <td>
                            <a class="btn" href="{{ route('users.edit', $user) }}">Edit</a>
                            <form action="{{ route('users.destroy', $user) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button class="btn danger" type="submit" onclick="return confirm('Are you sure you want to delete this account?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>