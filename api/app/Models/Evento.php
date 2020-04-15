<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    protected $table = 'app.eventos';

    protected $fillable = [
        'nome', 'descricao', 'data', 'hora', 'longitude', 'latitude',
        'image', 'instituicao_id', 'endereco_id'
    ];

    public static function getEventosByInsti($id)
    {
        return Evento::all()->where('instituicao_id', '=', $id);
    }
}
