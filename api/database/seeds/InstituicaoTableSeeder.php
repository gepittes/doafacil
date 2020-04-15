<?php

use App\Models\Endereco;
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

        $endereco_data = [
            'logradouro' => 'Tatooine',
            'bairro' => 'Casa dos Skywalker',
            'complemento' => 'Logo ali',
            'cep' => '56569-164',
            'longitude' => '-47.875',
            'latitude' => '-15.795',
            'cidade_id' => 805
        ];

        $endereco = Endereco::store($endereco_data);

        Instituicao::create([
            "nome" => "Ajuda os DOGS",
            "telefone" => "(61)99855-6546",
            "hora_open" => "08:00",
            "hora_close" => "18:00",
            "usuario_id" => 1,
            "endereco_id" => $endereco->id
        ]);
    }
}
