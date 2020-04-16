<?php

use App\Models\Endereco;
use App\Models\Evento;
use Illuminate\Database\Seeder;

class EventoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $endereco_data = [
            'logradouro' => 'Roma Center',
            'bairro' => 'Império Romano',
            'complemento' => 'Salão Vermelho',
            'cep' => '88569-164',
            'longitude' => '-47.575',
            'latitude' => '-15.295',
            'cidade_id' => 805
        ];

        $endereco = Endereco::store($endereco_data);

        Evento::create([
            "nome" => "Eventos de Comida",
            "descricao" => "Muita Comida",
            "data" => "2019-10-30",
            "hora" => "05:30",
            "longitude" => "-47.875",
            "latitude" => "-15.795",
            "instituicao_id" => 1,
            "endereco_id" => $endereco->id
        ]);
    }
}
