<?php

namespace App\Services\Evento;

use App\Models\Evento;

class EventoServices
{

    public static function get($id)
    {
        try {
            return Evento::findOrFail($id);
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    public static function post($request)
    {
        try {
            return Evento::storeEvento(($request));
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    public static function patch($request, $id)
    {
        try {
            return Evento::updateEvento($request, $id);
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
