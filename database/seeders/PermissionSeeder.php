<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'Admin',
            'Category',
            'User',
            'Setting'
        ];
        foreach ($permissions as $permission)
        {
            Permission::create([
                'name' => $permission,
                'english_name' => $permission
            ]);
        }
    }
}
