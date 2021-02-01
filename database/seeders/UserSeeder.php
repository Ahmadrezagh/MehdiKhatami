<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
              'name' => 'Super Admin',
              'type_id' => '1',
              'email'=>'superadmin@site.com',
              'password'=>'$2y$10$2phjXNKL.ZNYP.3ANw4Z3uej1NfrO5VpkdjWCHuz5cIbJU.CKy/Ky'
            ],
            [
                'name' => 'Admin',
                'type_id' => '2',
                'email'=>'admin@site.com',
                'password'=>'$2y$10$2phjXNKL.ZNYP.3ANw4Z3uej1NfrO5VpkdjWCHuz5cIbJU.CKy/Ky'
            ],
            [
                'name' => 'User',
                'type_id' => '3',
                'email'=>'user@site.com',
                'password'=>'$2y$10$2phjXNKL.ZNYP.3ANw4Z3uej1NfrO5VpkdjWCHuz5cIbJU.CKy/Ky'
            ],
        ];
        foreach ($users as $user)
        {
            User::create($user);
        }
    }
}
