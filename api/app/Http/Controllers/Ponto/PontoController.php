<?php

namespace App\Http\Controllers\Ponto;

use App\Models\PontoDeDoacao;
use App\Services\Ponto\PontoServices;
use Psr\Http\Message\ServerRequestInterface;
use Laravel\Lumen\Routing\Controller;

class PontoController extends Controller
{
    public function get($id = null)
    {
        if (!empty(trim($id))) {
            return response()->json(PontoServices::get($id));
        }

        return response()->json(PontoServices::get());
    }

    public function post(ServerRequestInterface $request)
    {
        $data = $request->getParsedBody();
        return response()->json(PontoServices::post($data));
    }

    public function patch(ServerRequestInterface $request, $id = null)
    {
        $data = $request->getParsedBody();
        return response()->json(PontoServices::patch($id, $data));
    }

    public function delete($id)
    {
        return response()->json(PontoServices::delete($id));
    }

    public function getPontosByInst($id)
    {
        return response()->json(PontoServices::get(null, $id));
    }
}
