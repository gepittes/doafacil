<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Instituicao extends Model
{
    protected $table = 'app.instituicao';

    protected $fillable = [
        'nome', 'telefone', 'hora_open', 'hora_close', 'usuario_id', 'endereco_id'
    ];
}
