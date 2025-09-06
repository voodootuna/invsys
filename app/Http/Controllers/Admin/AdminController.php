<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EquipmentItem;
use App\Models\Location;
use App\Models\Rental;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        $stats = [
            'total_equipment' => EquipmentItem::count(),
            'total_users' => User::count(),
            'total_locations' => Location::count(),
            'active_rentals' => Rental::where('status', 'active')->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}