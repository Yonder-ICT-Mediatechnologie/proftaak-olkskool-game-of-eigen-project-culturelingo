<?php

namespace App\Http\Controllers;

use App\Models\Culture;
use Illuminate\Http\Request;

class CultureController extends Controller
{
    public function index()
    {
        $cultures = Culture::orderBy('name')->get();

        return view('cultures.index', compact('cultures'));
    }

    public function create()
    {
        return view('cultures.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id' => ['required', 'string', 'max:50', 'unique:cultures,id'],
            'name' => ['required', 'string', 'max:100'],
            'emoji' => ['required', 'string', 'max:10'],
            'flag_path' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
        ]);

        Culture::create($data);

        return redirect()->route('cultures.index')->with('success', 'Culture created successfully.');
    }

    public function edit(Culture $culture)
    {
        return view('cultures.edit', compact('culture'));
    }
    public function updateProgress(Request $request)
{
    $user = auth()->user();
    
    // Voeg de XP en streak toe
    $user->xp += $request->xp_earned;
    $user->streak += 1; 
    $user->save();

    return response()->json(['success' => true, 'new_streak' => $user->streak]);
}

    public function update(Request $request, Culture $culture)
    {
        $data = $request->validate([
            'id' => ['required', 'string', 'max:50', 'unique:cultures,id,' . $culture->id . ',id'],
            'name' => ['required', 'string', 'max:100'],
            'emoji' => ['required', 'string', 'max:10'],
            'flag_path' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
        ]);

        if ($data['id'] !== $culture->id) {
            $culture->forceFill(['id' => $data['id']]);
        }

        $culture->fill($data);
        $culture->save();

        return redirect()->route('cultures.index')->with('success', 'Culture updated successfully.');
    }

    public function destroy(Culture $culture)
    {
        $culture->delete();

        return redirect()->route('cultures.index')->with('success', 'Culture deleted successfully.');
    }
    public function apiIndex()
{
    // Haalt alle culturen op uit je database
    return \App\Models\Culture::all();
}

}
