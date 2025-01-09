<?php

namespace Database\Seeders;

use App\Models\Hobby;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $hobbies = Hobby::pluck('id');

        User::factory(10)->create()->each(function ($user) use ($hobbies) {
            $user->hobbies()->attach($hobbies->random(3)->toArray());
        });
    }
}
