<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ScholarshipRequirement;

class ScholarshipRequirementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ScholarshipRequirement::create([
            'name' => 'Birth Certificate',
            'description' => 'NSO or PSA Certified Copy',
        ]);

        ScholarshipRequirement::create([
            'name' => 'Barangay Clearance',
            'description' => 'Valid within the last 3 months',
        ]);
    }
}
