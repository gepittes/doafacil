<?php

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
        Evento::create([
            "nome" => "Eventos de Comida",
            "descricao" => "Muita Comida",
            "data" => "2019-10-30",
            "hora" => "05:30",
            "longitude" => "-47.875",
            "latitude" => "-15.795",
            "instituicao_id" => 1
        ]);
    }
}
