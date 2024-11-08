<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            PaisesTableSeeder::class,
            RegionesTableSeeder::class,
            ComunasTableSeeder::class,
            GroupsTableSeeder::class,
            EmpresasTableSeeder::class,
            AfpsTableSeeder::class,
            BancosTableSeeder::class,
            PrevisionesTableSeeder::class,
            TipoContratosTableSeeder::class,
            TipoCuentasTableSeeder::class,
            UsersTableSeeder::class,
            TipoAsistenciasTableSeeder::class,
            RolesTableSeeder::class,
            NotifyRolesTableSeeder::class,
        ]);
    }
}
