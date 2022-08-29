<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert(
            [
                'name' => 'Administrador',
                'email' => 'admin@bluemedical.com',
                'password' => Hash::make('Blue123'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        );
        DB::table('types')->insert(
            [
                'name' => 'Oficial',
                'rate' => '0',
                'invoice' => '0',
                'monthly' => '0',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        );
        DB::table('types')->insert(
            [
                'name' => 'Residente',
                'rate' => '0.05',
                'invoice' => '1',
                'monthly' => '1',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        );
        DB::table('types')->insert(
            
            [
                'name' => 'No Residente',
                'rate' => '0.50',
                'invoice' => '1',
                'monthly' => '0',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        );
    }
}
