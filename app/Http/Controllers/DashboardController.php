<?php

namespace App\Http\Controllers;

use App\Models\EquipmentItem;
use App\Models\Rental;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Get available equipment with location
        $availableEquipment = EquipmentItem::where('status', 'available')
            ->with('currentLocation')
            ->orderBy('name')
            ->get();

        // Get active rentals with relationships
        $activeRentals = Rental::where('status', 'active')
            ->with(['equipment', 'user', 'toLocation'])
            ->orderBy('taken_date', 'desc')
            ->get();

        // Get broken equipment
        $brokenEquipment = EquipmentItem::where('status', 'broken')
            ->get();

        // Stats for dashboard
        $stats = [
            'total' => EquipmentItem::count(),
            'available' => EquipmentItem::where('status', 'available')->count(),
            'rented' => EquipmentItem::where('status', 'rented')->count(),
            'broken' => EquipmentItem::where('status', 'broken')->count(),
            'active_rentals' => Rental::where('status', 'active')->count(),
        ];

        return view('dashboard', compact('availableEquipment', 'activeRentals', 'brokenEquipment', 'stats'));
    }
}