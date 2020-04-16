<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Instituicao extends Model
{
    protected $table = 'app.instituicao';

    protected $fillable = [
        'nome', 'telefone', 'hora_open', 'hora_close', 'usuario_id', 'endereco_id'
    ];

    public $queryColumns = [
        'insti.id as id',
        'insti.nome',
        'insti.telefone',
        'insti.hora_open',
        'insti.hora_close',
        'insti.usuario_id',
        'insti.image',
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

    public static function get($id = null, $user_id = null)
    {

        $instituicao = new Instituicao();

        if ($id != null) {
            return DB::table('app.instituicao AS insti')

                ->join('app.enderecos AS end', 'insti.endereco_id', '=', 'end.id')
                ->join('app.cidades AS cid', 'end.cidade_id', '=', 'cid.id')
                ->join('app.estados AS est', 'cid.estado_id', '=', 'est.id')

                ->select($instituicao->queryColumns)
                ->where('insti.id', $id)
                ->first();
        }

        if ($user_id != null) {
            return DB::table('app.instituicao AS insti')

                ->join('app.enderecos AS end', 'insti.endereco_id', '=', 'end.id')
                ->join('app.cidades AS cid', 'end.cidade_id', '=', 'cid.id')
                ->join('app.estados AS est', 'cid.estado_id', '=', 'est.id')

                ->select($instituicao->queryColumns)
                ->where('insti.usuario_id', $user_id)

                ->orderBy('insti.id')
                ->get();
        }

        return DB::table('app.instituicao AS insti')

            ->join('app.enderecos AS end', 'insti.endereco_id', '=', 'end.id')
            ->join('app.cidades AS cid', 'end.cidade_id', '=', 'cid.id')
            ->join('app.estados AS est', 'cid.estado_id', '=', 'est.id')

            ->select($instituicao->queryColumns)
            ->orderBy('insti.id')
            ->get();
    }
}
