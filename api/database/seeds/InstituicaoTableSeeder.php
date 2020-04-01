<?php

use App\Models\Instituicao;
use Illuminate\Database\Seeder;

class InstituicaoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Instituicao::create([
            "nome" => "Ajuda os DOGS",
            "telefone" => "(61)99855-6546",
            "localidade" => "Brasília",
            "uf" => "DF",
            "hora_open" => "08:00",
            "hora_close" => "18:00",
            "usuario_id" => 1
        ]);
    }
}
