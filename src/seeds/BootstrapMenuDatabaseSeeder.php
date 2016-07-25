<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $this->call(UserTableSeeder::class);
        $this->command->info('User table has been seeded!');
        $this->call(MenuTableSeeder::class);
        $this->command->info('Menu table has been seeded!');
         
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    }
}


class UserTableSeeder extends Seeder {

    public function run()
    {
        DB::table('users')->truncate();

        DB::table('users')->insert([
            'name' => 'Administrador',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('123456'),
            'created_at' => new DateTime,
            'updated_at' => new DateTime
        ]);
    }

}

class MenuTableSeeder extends Seeder {

    public function run()
    {

        DB::table('menu')->truncate();

        DB::table('menu')->insert([
            'id' => 1,
            'titulo' => 'Dashboard',
            'icono' => 'fa fa-dashboard',
            'link' => '/home',
            'slug' => 'home',
            'anterior' => "0",
            'padre' => "0",
            'created_at' => new DateTime,
            'updated_at' => new DateTime
        ]);

        DB::table('menu')->insert([
            'id' => 2,
            'titulo' => 'Seguridad',
            'icono' => 'fa fa-lock',
            'link' => '/home2',
            'slug' => 'home2',
            'anterior' => "1",
            'padre' => "0",
            'created_at' => new DateTime,
            'updated_at' => new DateTime
        ]);

        DB::table('menu')->insert([
            'id' => 3,
            'titulo' => 'Usuarios',
            'icono' => 'fa fa-user',
            'link' => '/seguridad/usuarios',
            'slug' => 'seguridad.usuarios',
            'anterior' => "0",
            'padre' => "2",
            'created_at' => new DateTime,
            'updated_at' => new DateTime
        ]);

        DB::table('menu')->insert([
            'id' => 4,
            'titulo' => 'Perfiles',
            'icono' => 'fa fa-users',
            'link' => '/seguridad/perfiles',
            'slug' => 'seguridad.perfiles',
            'anterior' => "3",
            'padre' => "2",
            'created_at' => new DateTime,
            'updated_at' => new DateTime
        ]);

        DB::table('menu')->insert([
            'id' => 5,
            'titulo' => 'Permisos',
            'icono' => 'fa fa-ban',
            'link' => '/seguridad/permisos',
            'slug' => 'seguridad.permisos',
            'anterior' => "4",
            'padre' => "2",
            'created_at' => new DateTime,
            'updated_at' => new DateTime
        ]);
    }

}