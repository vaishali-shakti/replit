<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;
class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

     private $permissions = [
        'role-list',
        'role-create',
        'role-edit',
        'role-delete',
        'sales-party-list',
        'sales-party-create',
        'sales-party-edit',
        'sales-party-delete',
        'company-list',
        'company-create',
        'company-edit',
        'company-delete',
        'order-list',
        'order-create',
        'order-edit',
        'order-delete',
        'user-list',
        'user-create',
        'user-edit',
        'user-delete',
        'PR',
        'SR',
        'SNR',
        'PC',
        'generate-report',
    ];
    public function run()
    {
        foreach ($this->permissions as $permission) {
            Permission::create(['name' => $permission,"guard_name" => 'web']);
        }
    }
}
