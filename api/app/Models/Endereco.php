<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{
  protected $table = 'app.enderecos';

  protected $fillable = [
    'logradouro', 'bairro', 'complemento', 'cep', 'logitude', 'latitude', 'cidade_id'
  ];

  public static function store($data)
  {
    try {
      return Endereco::create($data);
    } catch (\Exception $exception) {
      throw $exception;
    }
  }


  public static function patch($id, $data)
  {
    try {
      Endereco::findOrfail($id)->update($data);
      return Endereco::findOrFail($id);
    } catch (\Exception $exception) {
      throw $exception;
    }
  }
}
