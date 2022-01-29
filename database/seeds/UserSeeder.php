<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $seeders = [
            [
                'name'      =>  'voxie user',
                'email'     =>  'test@voxie.com',
                'password'  =>  Hash::make('admin123')
            ]
        ];

        foreach ($seeders as $seeder)
        {
            User::create($seeder);
        }
    }
}
