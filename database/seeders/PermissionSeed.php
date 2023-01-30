<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pageData = [
//            'AccouontRequests',
//            'Admins',
//            'Users',
//            'suppliers',
//            'Company',
//            'Categories',
//            'Products',
//            'Setting',
//            'regions',
//            'Cities',
//            'District',
//            'workDays',
//            'AddEditDelete',
//            'ActiveDeactive'
        ];

        foreach ($pageData as $item) {
            $permission = Permission::create(['name' => $item,
                'guard_name' => 'admins'
            ]);
        }


    }
}
