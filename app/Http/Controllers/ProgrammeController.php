<?php

namespace App\Http\Controllers;
use App\Models\Programme;
use Inertia\Inertia;

use Illuminate\Http\Request;

class ProgrammeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
          $programmes = Programme::latest()->get();

        return Inertia::render('programmes/index', [
            'programmes' => $programmes,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('programmes/create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'schedule' => 'required|string|max:255',
            'activities' => 'required|string',
            'outcomes' => 'required|string',
        ]);

        Programme::create($validated);

        return redirect()->route('programmes.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Programme $programme)
    {
         return Inertia::render('programmes/edit', [
            'programme' => $programme,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Programme $programme)
    {
            $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'schedule' => 'required|string|max:255',
            'activities' => 'required|string',
            'outcomes' => 'required|string',
        ]);

        $programme->update($validated);

        return redirect()->route('programmes.index');
    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Programme $programme)
    {
         $programme->delete();

        return redirect()->route('programmes.index');
    }
}
