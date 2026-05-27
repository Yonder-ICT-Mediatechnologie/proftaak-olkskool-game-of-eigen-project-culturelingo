<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Culture</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 2rem; background: #0f172a; color: #e5eefb; }
        .card { background: #111827; border: 1px solid #334155; border-radius: 14px; padding: 1rem; max-width: 720px; }
        label { display:block; margin-top: 0.75rem; color: #bfdbfe; }
        input, textarea { width: 100%; box-sizing: border-box; padding: 0.6rem; border-radius: 8px; border: 1px solid #334155; background: #020617; color: #eff6ff; }
        .btn { display: inline-block; padding: 0.55rem 0.9rem; border-radius: 8px; border: 1px solid #38bdf8; color: #eff6ff; background: #1e293b; margin-top: 1rem; }
        .btn.primary { background: #2563eb; border-color: #2563eb; }
        .error { color: #fecaca; font-size: 0.92rem; }
    </style>
</head>
<body>
    <div class="card">
        <h1>Edit Culture</h1>
        <form action="{{ route('cultures.update', $culture) }}" method="POST">
            @csrf
            @method('PUT')
            <label for="id">ID</label>
            <input id="id" name="id" type="text" value="{{ old('id', $culture->id) }}" required>
            @error('id')<div class="error">{{ $message }}</div>@enderror

            <label for="name">Name</label>
            <input id="name" name="name" type="text" value="{{ old('name', $culture->name) }}" required>
            @error('name')<div class="error">{{ $message }}</div>@enderror

            <label for="emoji">Emoji</label>
            <input id="emoji" name="emoji" type="text" value="{{ old('emoji', $culture->emoji) }}" required>
            @error('emoji')<div class="error">{{ $message }}</div>@enderror

            <label for="flag_path">Flag path</label>
            <input id="flag_path" name="flag_path" type="text" value="{{ old('flag_path', $culture->flag_path) }}" required>
            @error('flag_path')<div class="error">{{ $message }}</div>@enderror

            <label for="description">Description</label>
            <textarea id="description" name="description" rows="5" required>{{ old('description', $culture->description) }}</textarea>
            @error('description')<div class="error">{{ $message }}</div>@enderror

            <button class="btn primary" type="submit">Update</button>
            <a class="btn" href="{{ route('cultures.index') }}">Cancel</a>
        </form>
    </div>
</body>
</html>
