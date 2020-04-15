<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PontoDeDoacao extends Model
{
    protected $table = 'app.ponto_de_doacoes';

    protected $fillable = [
        'nome',
        'descricao',
        'hora_open',
        'hora_close',
        'instituicao_id',
        'endereco_id',
        'image'
    ];

    public static function getPontoByInst($id)
    {
        return PontoDeDoacao::where('instituicao_id', '=', $id)->get();
    }
}
