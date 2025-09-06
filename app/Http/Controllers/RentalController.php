<?php

namespace App\Http\Controllers;

use App\Models\EquipmentItem;
use App\Models\Location;
use App\Models\Rental;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RentalController extends Controller
{
    public function store(Request $request)
    {
        $validationRules = [
            'equipment_item_id' => 'required|exists:equipment_items,id',
            'to_location_id' => 'required|exists:locations,id',
            'expected_return_date' => 'nullable|date|after:today',
            'notes' => 'nullable|string|max:500'
        ];
        
        // Add user_id validation for admin users
        if (auth()->user()->role === 'admin') {
            $validationRules['user_id'] = 'required|exists:users,id';
        }
        
        $request->validate($validationRules);
        
        $equipment = EquipmentItem::findOrFail($request->equipment_item_id);
        
        // Check if equipment is still available
        if (!$equipment->isAvailable()) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Cet outil n\'est plus disponible');
        }
        
        DB::transaction(function() use ($request, $equipment) {
            // Determine user_id: use form value if admin submitted it, otherwise current user
            $assignedUserId = auth()->user()->role === 'admin' && $request->has('user_id') 
                ? $request->user_id 
                : auth()->id();
            
            // Create rental
            Rental::create([
                'equipment_item_id' => $equipment->id,
                'user_id' => $assignedUserId,
                'from_location_id' => $equipment->current_location_id,
                'to_location_id' => $request->to_location_id,
                'taken_date' => now(),
                'expected_return_date' => $request->expected_return_date,
                'notes' => $request->notes,
                'status' => 'active'
            ]);
            
            // Update equipment status and location
            $equipment->update([
                'status' => 'rented',
                'current_location_id' => $request->to_location_id
            ]);
        });
        
        $toLocation = Location::find($request->to_location_id);
        
        return redirect()->route('dashboard')
            ->with('success', $equipment->name . ' pris avec succès pour ' . $toLocation->name);
    }
    
    public function return(Rental $rental)
    {
        if (!$rental->isActive()) {
            return redirect()->back()->with('error', 'Cette location n\'est plus active');
        }
        
        DB::transaction(function() use ($rental) {
            // Update rental
            $rental->update([
                'returned_date' => now(),
                'returned_by_user_id' => auth()->id(),
                'status' => 'returned'
            ]);
            
            // Update equipment - return to Office (warehouse)
            $officeLocation = Location::where('type', 'warehouse')->first();
            
            $rental->equipment->update([
                'status' => 'available',
                'current_location_id' => $officeLocation->id
            ]);
        });
        
        return redirect()->route('dashboard')
            ->with('success', $rental->equipment->name . ' retourné avec succès');
    }
    
    public function active()
    {
        $activeRentals = Rental::where('status', 'active')
            ->with(['equipment', 'user', 'toLocation'])
            ->orderBy('taken_date', 'desc')
            ->get();
            
        return view('rentals.active', compact('activeRentals'));
    }
    
    public function history()
    {
        $pastRentals = Rental::where('status', 'returned')
            ->with(['equipment', 'user', 'toLocation', 'returnedByUser'])
            ->orderBy('returned_date', 'desc')
            ->paginate(20);
            
        return view('rentals.history', compact('pastRentals'));
    }
}