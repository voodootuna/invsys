<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index()
    {
        $locations = Location::withCount('equipmentItems')
            ->orderBy('name')
            ->paginate(20);
            
        return view('admin.locations.index', compact('locations'));
    }

    public function create()
    {
        return view('admin.locations.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:locations',
            'address' => 'nullable|string|max:500',
            'type' => 'required|in:warehouse,client,job_site',
            'is_active' => 'boolean',
        ]);

        Location::create([
            'name' => $request->name,
            'address' => $request->address,
            'type' => $request->type,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.locations.index')
            ->with('success', 'Lieu créé avec succès');
    }

    public function edit(Location $location)
    {
        return view('admin.locations.edit', compact('location'));
    }

    public function update(Request $request, Location $location)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:locations,name,' . $location->id,
            'address' => 'nullable|string|max:500',
            'type' => 'required|in:warehouse,client,job_site',
            'is_active' => 'boolean',
        ]);

        $location->update([
            'name' => $request->name,
            'address' => $request->address,
            'type' => $request->type,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.locations.index')
            ->with('success', 'Lieu modifié avec succès');
    }

    public function destroy(Location $location)
    {
        // Check if location has equipment
        if ($location->equipmentItems()->exists()) {
            return redirect()->back()
                ->with('error', 'Impossible de supprimer un lieu contenant des équipements');
        }

        $location->delete();

        return redirect()->route('admin.locations.index')
            ->with('success', 'Lieu supprimé avec succès');
    }
}