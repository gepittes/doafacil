<?php

use App\Models\Endereco;
use App\Models\PontoDeDoacao;
use Illuminate\Database\Seeder;

class PontoDeDoacaoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $endereco_data = [
            'logradouro' => 'Demácia',
            'bairro' => 'Demaciolándia',
            'complemento' => 'Bar do Yulgar',
            'cep' => '88569-164',
            'longitude' => '-47.575',
            'latitude' => '-15.295',
            'cidade_id' => 805
        ];

        $endereco = Endereco::store($endereco_data);

        PontoDeDoacao::create([
            'nome' => 'Ponto de Doação',
            'descricao' => 'Descrição ponto de doação',
            'hora_open' => '23:55',
            'hora_close' => '11:55',
            'instituicao_id' => 1,
            'endereco_id' => $endereco->id
        ]);
    }
}
