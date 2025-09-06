<?php

namespace App\Http\Controllers;

use App\Models\EquipmentItem;
use App\Models\Location;
use App\Models\User;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    public function index(Request $request)
    {
        $query = EquipmentItem::with('currentLocation');
        
        // Search functionality
        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        
        // Filter by status
        if ($request->status) {
            $query->where('status', $request->status);
        }
        
        // Filter by type
        if ($request->type) {
            $query->where('type', $request->type);
        }
        
        $equipment = $query->orderBy('name')->get();
        $types = EquipmentItem::distinct('type')->pluck('type');
        
        return view('equipment.index', compact('equipment', 'types'));
    }
    
    public function show(EquipmentItem $equipment)
    {
        $equipment->load([
            'currentLocation', 
            'activeRental.user', 
            'rentals' => function($query) {
                $query->latest()->limit(10)->with(['user', 'fromLocation', 'toLocation']);
            }
        ]);
        
        return view('equipment.show', compact('equipment'));
    }
    
    public function take()
    {
        // Get available equipment
        $availableEquipment = EquipmentItem::where('status', 'available')
            ->with('currentLocation')
            ->orderBy('name')
            ->get();
        
        // Get client/job site locations (not warehouse)
        $locations = Location::where('type', '!=', 'warehouse')
            ->orderBy('name')
            ->get();
        
        // Get users for admin assignment (only if user is admin)
        $users = collect();
        if (auth()->user()->role === 'admin') {
            $users = User::where('role', '!=', 'admin')
                ->orWhere('id', auth()->id())
                ->orderBy('name')
                ->get();
        }
        
        return view('equipment.take', compact('availableEquipment', 'locations', 'users'));
    }
}