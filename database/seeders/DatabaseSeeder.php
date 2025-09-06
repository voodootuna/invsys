<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Location;
use App\Models\EquipmentItem;
use App\Models\Rental;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create users
        $users = [
            ['name' => 'Aldo Zamudio', 'email' => 'admin@example.com', 'role' => 'admin'],
            ['name' => 'Pierre Dubois', 'email' => 'pierre@example.com', 'role' => 'employee'],
            ['name' => 'Marie Leroy', 'email' => 'marie@example.com', 'role' => 'employee'],
            ['name' => 'Jean Martin', 'email' => 'jean@example.com', 'role' => 'employee'],
            ['name' => 'Sophie Laurent', 'email' => 'sophie@example.com', 'role' => 'employee'],
        ];

        foreach ($users as $userData) {
            User::create([
                'name' => $userData['name'],
                'email' => $userData['email'],
                'password' => Hash::make('password'),
                'role' => $userData['role'],
                'phone' => '230 5' . rand(100, 999) . ' ' . rand(1000, 9999),
            ]);
        }

        // Create locations
        $locations = [
            ['name' => 'Office', 'type' => 'warehouse'],
            ['name' => 'Shandrani', 'type' => 'client'],
            ['name' => 'Montmartre', 'type' => 'job_site'],
            ['name' => 'Helvetia', 'type' => 'client'],
            ['name' => 'IADG', 'type' => 'client'],
            ['name' => 'Mon Piton', 'type' => 'job_site'],
        ];

        foreach ($locations as $locationData) {
            Location::create($locationData);
        }

        $office = Location::where('name', 'Office')->first();

        // Create equipment items with photo mappings
        $equipmentItems = [
            ['name' => 'Ponceuse 1', 'type' => 'sander', 'photo_path' => 'equipment/ponceuse.jpg'],
            ['name' => 'Ponceuse 2', 'type' => 'sander', 'photo_path' => 'equipment/ponceuse.jpg'],
            ['name' => 'Petite ponceuse jaune', 'type' => 'sander', 'status' => 'broken', 'notes' => 'ne marche plus', 'photo_path' => 'equipment/petite ponceuse jaune.jpg'],
            ['name' => 'Karcher F1', 'type' => 'karcher', 'photo_path' => 'equipment/karcher f1.jpg'],
            ['name' => 'Karcher électrique', 'type' => 'karcher'],
            ['name' => 'Rallonge 100mt', 'type' => 'cable'],
            ['name' => 'Échelle double 8m', 'type' => 'ladder', 'photo_path' => 'equipment/echelle double.jpg'],
            ['name' => 'Échelle triple no1', 'type' => 'ladder'],
            ['name' => 'Escabeau 3m', 'type' => 'ladder', 'photo_path' => 'equipment/escabeau-3m.jpeg'],
            ['name' => 'Gros grinder total 9"', 'type' => 'grinder', 'photo_path' => 'equipment/grinder 9.jpeg'],
            ['name' => 'Perceuse Bosch', 'type' => 'drill', 'photo_path' => 'equipment/perceuse bosch.jpg'],
            ['name' => 'Perceuse Makita', 'type' => 'drill', 'photo_path' => 'equipment/perceuse makita.jpg'],
            ['name' => 'Tuyau d\'arrosage nb5', 'type' => 'hose', 'photo_path' => 'equipment/tuyeau arosage nb5.jpg'],
            ['name' => 'Tuyau d\'arrosage nb6', 'type' => 'hose', 'photo_path' => 'equipment/tuyeau arosage nb6.jpg'],
            ['name' => 'Compresseur', 'type' => 'compressor', 'photo_path' => 'equipment/compresseur.jpg'],
        ];

        foreach ($equipmentItems as $item) {
            EquipmentItem::create(array_merge(
                ['current_location_id' => $office->id],
                $item
            ));
        }

        // Create some active rentals
        $activeRentals = [
            [
                'equipment' => 'Ponceuse 1',
                'user' => 'Pierre Dubois',
                'to_location' => 'Shandrani',
                'days_ago' => 2,
            ],
            [
                'equipment' => 'Rallonge 100mt',
                'user' => 'Jean Martin',
                'to_location' => 'Montmartre',
                'days_ago' => 1,
            ],
            [
                'equipment' => 'Karcher électrique',
                'user' => 'Aldo Zamudio',
                'to_location' => 'Helvetia',
                'days_ago' => 3,
            ],
            [
                'equipment' => 'Échelle triple no1',
                'user' => 'Marie Leroy',
                'to_location' => 'IADG',
                'days_ago' => 0,
            ],
        ];

        foreach ($activeRentals as $rentalData) {
            $equipment = EquipmentItem::where('name', $rentalData['equipment'])->first();
            $user = User::where('name', $rentalData['user'])->first();
            $toLocation = Location::where('name', $rentalData['to_location'])->first();

            // Create rental
            Rental::create([
                'equipment_item_id' => $equipment->id,
                'user_id' => $user->id,
                'from_location_id' => $office->id,
                'to_location_id' => $toLocation->id,
                'taken_date' => now()->subDays($rentalData['days_ago']),
                'status' => 'active',
            ]);

            // Update equipment status and location
            $equipment->update([
                'status' => 'rented',
                'current_location_id' => $toLocation->id,
            ]);
        }

        // Create some historical rentals (returned)
        $historicalRentals = [
            [
                'equipment' => 'Perceuse Bosch',
                'user' => 'Sophie Laurent',
                'to_location' => 'Mon Piton',
                'taken_days_ago' => 10,
                'returned_days_ago' => 5,
            ],
            [
                'equipment' => 'Compresseur',
                'user' => 'Jean Martin',
                'to_location' => 'Shandrani',
                'taken_days_ago' => 7,
                'returned_days_ago' => 3,
            ],
        ];

        foreach ($historicalRentals as $rentalData) {
            $equipment = EquipmentItem::where('name', $rentalData['equipment'])->first();
            $user = User::where('name', $rentalData['user'])->first();
            $toLocation = Location::where('name', $rentalData['to_location'])->first();

            Rental::create([
                'equipment_item_id' => $equipment->id,
                'user_id' => $user->id,
                'from_location_id' => $office->id,
                'to_location_id' => $toLocation->id,
                'taken_date' => now()->subDays($rentalData['taken_days_ago']),
                'returned_date' => now()->subDays($rentalData['returned_days_ago']),
                'returned_by_user_id' => $user->id,
                'status' => 'returned',
            ]);
        }
    }
}
