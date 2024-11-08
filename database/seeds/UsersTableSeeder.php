<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'rut' => '1-1',
            'empresa_id' => 1,
            'name' => "Administrador",
            'email' =>'admin@admin.com',
            'password' => bcrypt('lycans'),
            'cargo_id'=>1,
            'tipo_contrato_id'=>3,
            'imagen'=>'public/avatars/avatar.png',
        ]);
    }
}
