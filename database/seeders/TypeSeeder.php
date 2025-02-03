<?php

namespace Database\Seeders;

use App\Models\Advertisement;
use App\Models\Application;
use App\Models\Type;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = ['apartment','room','house','office'];
        for($i = 0; $i < count($types); $i++){
            Type::create(['name' => $types[$i]]);
        }
    }
}
