<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EquipmentItem;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EquipmentController extends Controller
{
    public function index()
    {
        $equipment = EquipmentItem::with('currentLocation')
            ->orderBy('name')
            ->paginate(20);

        return view('admin.equipment.index', compact('equipment'));
    }

    public function create()
    {
        $locations = Location::orderBy('name')->get();
        return view('admin.equipment.create', compact('locations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:100',
            'serial_number' => 'nullable|string|max:100|unique:equipment_items',
            'status' => 'required|in:available,rented,broken,maintenance',
            'current_location_id' => 'required|exists:locations,id',
            'notes' => 'nullable|string|max:500',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only([
            'name', 'type', 'serial_number', 'status', 
            'current_location_id', 'notes'
        ]);

        if ($request->hasFile('photo')) {
            $data['photo_path'] = $request->file('photo')
                ->store('equipment', 'public');
        }

        EquipmentItem::create($data);

        return redirect()->route('admin.equipment.index')
            ->with('success', 'Équipement ajouté avec succès');
    }

    public function edit(EquipmentItem $equipment)
    {
        $locations = Location::orderBy('name')->get();
        return view('admin.equipment.edit', compact('equipment', 'locations'));
    }

    public function update(Request $request, EquipmentItem $equipment)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:100',
            'serial_number' => 'nullable|string|max:100|unique:equipment_items,serial_number,' . $equipment->id,
            'status' => 'required|in:available,rented,broken,maintenance',
            'current_location_id' => 'required|exists:locations,id',
            'notes' => 'nullable|string|max:500',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only([
            'name', 'type', 'serial_number', 'status', 
            'current_location_id', 'notes'
        ]);

        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($equipment->photo_path) {
                Storage::disk('public')->delete($equipment->photo_path);
            }
            
            $data['photo_path'] = $request->file('photo')
                ->store('equipment', 'public');
        }

        $equipment->update($data);

        return redirect()->route('admin.equipment.index')
            ->with('success', 'Équipement modifié avec succès');
    }

    public function destroy(EquipmentItem $equipment)
    {
        // Check if equipment has active rentals
        if ($equipment->activeRental) {
            return redirect()->back()
                ->with('error', 'Impossible de supprimer un équipement actuellement loué');
        }

        // Delete photo if exists
        if ($equipment->photo_path) {
            Storage::disk('public')->delete($equipment->photo_path);
        }

        $equipment->delete();

        return redirect()->route('admin.equipment.index')
            ->with('success', 'Équipement supprimé avec succès');
    }
}