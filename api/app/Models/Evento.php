<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Evento extends Model
{
    protected $table = 'app.eventos';

    protected $fillable = [
        'nome', 'descricao', 'data', 'hora', 'longitude', 'latitude',
        'image', 'instituicao_id', 'endereco_id'
    ];

    public $queryColumns = [
        'evento.id as id',
        'evento.nome',
        'evento.descricao',
        'evento.data',
        'evento.hora',
        'evento.instituicao_id',
        'end.logradouro',
        'end.bairro',
        'end.complemento',
        'end.cep',
        'end.longitude',
        'end.latitude',
        'cid.nm_cidade',
        'est.nm_estado',
        'est.sg_estado',
    ];

    public static function get($id = null, $instituicao_id = null)
    {
        $eventos = new Evento();

        if ($id != null) {
            return DB::table('app.eventos AS evento')

                ->join('app.enderecos AS end', 'evento.endereco_id', '=', 'end.id')
                ->join('app.cidades AS cid', 'end.cidade_id', '=', 'cid.id')
                ->join('app.estados AS est', 'cid.estado_id', '=', 'est.id')

                ->select($eventos->queryColumns)
                ->where('evento.id', $id)
                ->first();
        }

        if ($instituicao_id != null) {
            return DB::table('app.eventos AS evento')

                ->join('app.enderecos AS end', 'evento.endereco_id', '=', 'end.id')
                ->join('app.cidades AS cid', 'end.cidade_id', '=', 'cid.id')
                ->join('app.estados AS est', 'cid.estado_id', '=', 'est.id')

                ->select($eventos->queryColumns)
                ->where('evento.instituicao_id', $instituicao_id)

                ->orderBy('evento.id')
                ->get();
        }

        return DB::table('app.eventos AS evento')

            ->join('app.enderecos AS end', 'evento.endereco_id', '=', 'end.id')
            ->join('app.cidades AS cid', 'end.cidade_id', '=', 'cid.id')
            ->join('app.estados AS est', 'cid.estado_id', '=', 'est.id')

            ->select($eventos->queryColumns)
            ->orderBy('evento.id')
            ->get();
    }
}
