<?php

namespace App\Http\Controllers\Localidades;

use App\Models\Cidade;
use App\Models\Estado;
use Laravel\Lumen\Routing\Controller;


class LocalidadesController extends Controller
{
  public function getEstados()
  {
    return response()->json(Estado::all());
  }

  public function getCidadesByEstado($id)
  {
    $cidades = Cidade::where('estado_id', $id)->get();
    return response()->json($cidades);
  }
}
