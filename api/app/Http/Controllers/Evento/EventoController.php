<?php

namespace App\Http\Controllers\Evento;

use App\Models\Evento;
use App\Services\Evento\EventoServices;
use Laravel\Lumen\Routing\Controller;
use Psr\Http\Message\ServerRequestInterface;

class EventoController extends Controller
{
    public function get($id = null)
    {
        if (!empty(trim($id))) return response()->json(EventoServices::get($id));

        return response()->json(Evento::all(), 200);
    }

    public function post(ServerRequestInterface $request)
    {
        try {
            $data = $request->getParsedBody();
            return response()->json(EventoServices::post($data));
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    public function patch(ServerRequestInterface $request, $id)
    {
        try {
            $request = $request->getParsedBody();
            $evento = EventoServices::patch($request, $id);
            return response()->json($evento, 200);
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    public function delete($id)
    {
        try {
            return response()->json(EventoServices::delete($id), 200);
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    public function getEventosByInsti($id)
    {
        $eventos = Evento::getEventosByInsti($id);
        return response()->json($eventos, 200);
    }
}
