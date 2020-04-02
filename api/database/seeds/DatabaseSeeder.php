<?php

use Illuminate\Database\Eloquent\Model;
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
        Model::unguard();
        // $this->call(UsuarioTableSeeder::class);
        // $this->call(InstituicaoTableSeeder::class);
        // $this->call(EventoTableSeeder::class);
        // $this->call(ItemTableSeeder::class);
        Model::reguard();
    }
}
