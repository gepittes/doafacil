<?php

namespace App\Services\Evento;

use App\Models\Endereco;
use App\Models\Evento;

class EventoServices
{
    public static function get($id = null, $instituicao_id = null)
    {
        $data = Evento::get();

        try {
            if (!empty(trim($id))) {
                $data = Evento::get($id);
            }

            if (!empty(trim($instituicao_id))) {
                $data = Evento::get(null, $instituicao_id);
            }

            return $data;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    public static function post($data)
    {
        try {
            $endereco = Endereco::store($data['endereco']);
            unset($data['endereco']);
            $data['endereco_id'] = $endereco->id;

            return Evento::create($data);
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    public static function patch($data, $id)
    {
        try {
            $evento = Evento::findOrFail($id);
            Endereco::patch($evento->endereco_id, $data['endereco']);
            unset($data['endereco']);

            Evento::findOrFail($id)->update($data);
            $evento = Evento::find($id);

            return $evento;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    public static function delete($id)
    {
        try {
            return Evento::findOrfail($id)->delete();
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    public static function setImage($id, $image)
    {
        $evento = Evento::find($id);
        $evento->image =  $image;
        $evento->update();

        return $evento;
    }
}
