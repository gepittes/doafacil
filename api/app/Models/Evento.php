<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    protected $table = 'app.eventos';

    protected $fillable = ['nome', 'descricao', 'data', 'hora', 'longitude', 'latitude', 'image'];

    public static function storeEvento($request)
    {
        $evento = new Evento();
        $evento->nome = $request['nome'];
        $evento->descricao = $request['descricao'];
        $evento->data = $request['data'];
        $evento->hora = $request['hora'];
        if (isset($request['localizacao'])) {
            $evento->longitude = $request['localizacao']['longitude'];
            $evento->latitude = $request['localizacao']['latitude'];
        }
        $evento->instituicao_id = $request['instituicao_id'];
        $evento->save();

        return $evento;
    }

    public static function updateEvento($request, $id)
    {
        $evento = Evento::findOrFail($id);
        $evento->nome = $request['nome'];
        $evento->descricao = $request['descricao'];
        $evento->data = $request['data'];
        $evento->hora = $request['hora'];
        if (isset($request['localizacao'])) {
            $evento->longitude = $request['localizacao']['longitude'];
            $evento->latitude = $request['localizacao']['latitude'];
        }
        $evento->instituicao_id = $request['instituicao_id'];
        $evento->save();

        return $evento;
    }

    public static function getEventosByInsti($id)
    {
        return Evento::all()->where('instituicao_id', '=', $id);
    }
}
