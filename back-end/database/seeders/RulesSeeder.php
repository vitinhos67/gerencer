<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RulesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::create(['name' => 'admin']);
        $moderatorRole = Role::create(['name' => 'moderador']);
        $userRole = Role::create(['name' => 'user']);
    
        Permission::create(['name' => 'create-order']);
        Permission::create(['name' => 'manage-products']);
        Permission::create(['name' => 'manage-suppliers']);
    
        $adminRole->givePermissionTo(['create-order', 'manage-products', 'manage-suppliers']);
        $moderatorRole->givePermissionTo(['manage-products', 'manage-suppliers']);
        $userRole->givePermissionTo(['create-order']);
    }
}
