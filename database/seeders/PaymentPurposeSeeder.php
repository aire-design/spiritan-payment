<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PaymentPurposeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $purposes = [
            ['name' => 'Tuition Fee', 'description' => 'Regular term academic fee'],
            ['name' => 'PTA Levy', 'description' => 'Parent-Teacher Association termly levy'],
            ['name' => 'Uniforms', 'description' => 'Payment for school uniforms and sportswear'],
            ['name' => 'Hostel Fee', 'description' => 'Accommodation fee for boarding students'],
            ['name' => 'Excursion', 'description' => 'Payment for academic field trips'],
            ['name' => 'Graduation Fee', 'description' => 'Fee for finalizing graduation process'],
        ];

        foreach ($purposes as $purpose) {
            \App\Models\PaymentPurpose::firstOrCreate(
                ['name' => $purpose['name']],
                $purpose
            );
        }
    }
}
