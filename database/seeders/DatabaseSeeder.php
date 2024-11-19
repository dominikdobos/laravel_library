<?php

namespace Database\Seeders;

use App\Models\book;
use App\Models\copy;
use App\Models\Lending;
use App\Models\Reservation;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();

        book::factory(10)->create();

        copy::factory(10)->create();

        Lending::factory(10)->create();
        
        Reservation::factory(5)->create();
    }
}
