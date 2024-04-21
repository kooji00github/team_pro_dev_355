<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Type;

class TypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = ['食料品', '衛生用品', '衣料品', '医療品', '電子機器', 'その他'];

        foreach ($types as $type) {
            Type::create(['name' => $type]);
        }
    }
}
