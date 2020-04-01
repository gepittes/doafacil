<?php

use App\Models\Usuario;
use Illuminate\Database\Seeder;

class UsuarioTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $pass = password_hash(123456789, PASSWORD_BCRYPT);

        Usuario::create([
            'nome' => 'Admin',
            'is_ativo' => true,
            'is_admin' => true,
            'email' => 'admin@gmail.com',
            'password' => $pass
        ]);
    }
}
