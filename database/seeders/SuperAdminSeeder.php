<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminRecords=[
            [
                'id'=>1, 'name'=>'admin', 'email'=>'admin@admin.com'
                ,'password'=>'$2y$10$q2FSxlv.fSjOb0fsa0IuneduPS8fGV4hDzYIgu8zkGsosbD2D/P0G','status'=>1,
                
            ],
          
        ];
        $admin=[
            [
        'super_admin_id'=>1,'role_id'=>1,
            ],
        ];
        
        DB::table('super_admins')->insert($adminRecords);
        DB::table('users_roles')->insert($admin);
    }
}
