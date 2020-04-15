<?php

namespace App\Http\Controllers\Instituicao;

use App\Services\Instituicao\InstituicaoServices;
use Laravel\Lumen\Routing\Controller;
use Psr\Http\Message\ServerRequestInterface;


class InstituicaoController extends Controller
{
    public function get($id = null)
    {
        if (!empty(trim($id))) {
            return response()->json(InstituicaoServices::get($id));
        }

        return response()->json(InstituicaoServices::get());
    }

    public function post(ServerRequestInterface $request)
    {
        $data = $request->getParsedBody();
        return response()->json(InstituicaoServices::store($data));
    }

    public function patch(ServerRequestInterface $request, $id)
    {
        $data = $request->getParsedBody();
        return response()->json(InstituicaoServices::update($id, $data));
    }

    public function delete($id)
    {
        return response()->json(InstituicaoServices::delete($id));
    }

    public function getInstisUser($id)
    {
        return response()->json(InstituicaoServices::get($id, 'usuario_id'));
    }
}
