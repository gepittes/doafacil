<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PontoDeDoacao extends Model
{
    protected $table = 'app.ponto_de_doacoes';

    protected $fillable = [
        'nome', 'descricao', 'hora_open', 'hora_close',
        'instituicao_id', 'endereco_id', 'image'
    ];

    public $queryColumns = [
        'ponto.id as id',
        'ponto.nome',
        'ponto.descricao',
        'ponto.hora_open',
        'ponto.hora_close',
        'ponto.image',
        'ponto.instituicao_id',
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
        $ponto = new PontoDeDoacao();

        if ($id != null) {
            return DB::table('app.ponto_de_doacoes AS ponto')

                ->join('app.enderecos AS end', 'ponto.endereco_id', '=', 'end.id')
                ->join('app.cidades AS cid', 'end.cidade_id', '=', 'cid.id')
                ->join('app.estados AS est', 'cid.estado_id', '=', 'est.id')

                ->select($ponto->queryColumns)
                ->where('ponto.id', $id)
                ->first();
        }

        if ($instituicao_id != null) {
            return DB::table('app.ponto_de_doacoes AS ponto')

                ->join('app.enderecos AS end', 'ponto.endereco_id', '=', 'end.id')
                ->join('app.cidades AS cid', 'end.cidade_id', '=', 'cid.id')
                ->join('app.estados AS est', 'cid.estado_id', '=', 'est.id')

                ->select($ponto->queryColumns)
                ->where('ponto.instituicao_id', $instituicao_id)

                ->orderBy('ponto.id')
                ->get();
        }

        return DB::table('app.ponto_de_doacoes AS ponto')

            ->join('app.enderecos AS end', 'ponto.endereco_id', '=', 'end.id')
            ->join('app.cidades AS cid', 'end.cidade_id', '=', 'cid.id')
            ->join('app.estados AS est', 'cid.estado_id', '=', 'est.id')

            ->select($ponto->queryColumns)
            ->orderBy('ponto.id')
            ->get();
    }
}
