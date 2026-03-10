<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SchoolClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $classes = [
            ['name' => 'JSS 1', 'level' => 'Junior Secondary'],
            ['name' => 'JSS 2', 'level' => 'Junior Secondary'],
            ['name' => 'JSS 3', 'level' => 'Junior Secondary'],
            ['name' => 'SS 1', 'level' => 'Senior Secondary'],
            ['name' => 'SS 2', 'level' => 'Senior Secondary'],
            ['name' => 'SS 3', 'level' => 'Senior Secondary'],
        ];

        foreach ($classes as $class) {
            \App\Models\SchoolClass::firstOrCreate(
                ['name' => $class['name']],
                ['level' => $class['level'], 'is_active' => true]
            );
        }
    }
}
