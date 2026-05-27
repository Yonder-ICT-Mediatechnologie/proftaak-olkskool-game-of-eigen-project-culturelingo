<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Culture CRUD</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 2rem; background: #0f172a; color: #e5eefb; }
        a { color: #93c5fd; text-decoration: none; }
        .card { background: #111827; border: 1px solid #334155; border-radius: 14px; padding: 1rem; margin-bottom: 1rem; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border-bottom: 1px solid #334155; padding: 0.75rem; text-align: left; vertical-align: top; }
        .btn { display: inline-block; padding: 0.45rem 0.75rem; border-radius: 8px; border: 1px solid #38bdf8; color: #eff6ff; background: #1e293b; margin-right: 0.35rem; }
        .btn.primary { background: #2563eb; border-color: #2563eb; }
        .btn.danger { background: #991b1b; border-color: #991b1b; }
        .flash { padding: 0.75rem; border-radius: 8px; background: #14532d; color: #dcfce7; margin-bottom: 1rem; }
    </style>
</head>
<body>
    <div class="card">
        <h1>Laravel CRUD for CultureLingo</h1>
        <p>Manage the culture records used by the main app.</p>
        <a class="btn primary" href="{{ route('cultures.create') }}">Add culture</a>
        <a class="btn" href="http://127.0.0.1/CultureLingo/">Back to main app</a>
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
                    <th>Emoji</th>
                    <th>Flag</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cultures as $culture)
                    <tr>
                        <td>{{ $culture->id }}</td>
                        <td>{{ $culture->name }}</td>
                        <td>{{ $culture->emoji }}</td>
                        <td>{{ $culture->flag_path }}</td>
                        <td>{{ $culture->description }}</td>
                        <td>
                            <a class="btn" href="{{ route('cultures.edit', $culture) }}">Edit</a>
                            <form action="{{ route('cultures.destroy', $culture) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button class="btn danger" type="submit" onclick="return confirm('Delete this culture?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
