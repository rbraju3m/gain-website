<?php

namespace Database\Seeders;

use App\Models\District;
use App\Models\Division;
use Illuminate\Database\Seeder;

class DistrictsSeeder extends Seeder
{
    public function run(): void
    {
        // The bd-districts.json file lists 64 districts with their lat/lng
        // and a numeric division_id; the mapping below converts that numeric
        // id to our division.key.
        $divIdToKey = [
            '1' => 'barisal',
            '2' => 'chittagong',
            '3' => 'dhaka',
            '4' => 'khulna',
            '5' => 'rajshahi',
            '6' => 'rongpur',
            '7' => 'sylhet',
            '8' => 'mymensingh',
        ];

        // Seed the same 30 active districts used by the original hardcoded partial.
        $activeNames = [
            'Barishal', 'Bhola', 'Patuakhali',
            'Chattogram', "Cox's Bazar", 'Cumilla', 'Noakhali', 'Bandarban',
            'Dhaka', 'Gazipur', 'Tangail', 'Kishoreganj', 'Faridpur', 'Manikganj',
            'Khulna', 'Jashore', 'Satkhira', 'Bagerhat',
            'Rajshahi', 'Bogura', 'Pabna', 'Sirajgonj',
            'Rangpur', 'Dinajpur', 'Kurigram',
            'Sylhet', 'Sunamganj', 'Maulvibazar',
            'Mymensingh', 'Jamalpur',
        ];

        $path = storage_path('app/bd-districts.json');
        if (! file_exists($path)) {
            $this->command?->warn("[DistrictsSeeder] missing $path; skipping.");
            return;
        }

        $raw = json_decode(file_get_contents($path), true)['districts'] ?? [];

        // Build a lookup of division key -> id for fast resolution.
        $divisions = Division::pluck('id', 'key');

        foreach ($raw as $row) {
            $divisionKey = $divIdToKey[$row['division_id']] ?? null;
            if (! $divisionKey || ! isset($divisions[$divisionKey])) {
                continue;
            }

            District::updateOrCreate(
                ['name' => $row['name']],
                [
                    'division_id' => $divisions[$divisionKey],
                    'lat'         => (float) $row['lat'],
                    'lng'         => (float) $row['long'],
                    'is_active'   => in_array($row['name'], $activeNames, true),
                ]
            );
        }
    }
}
