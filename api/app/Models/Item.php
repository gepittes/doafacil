<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
  protected $table = 'app.itens';

  protected $fillable = ['nome', 'quantidade', 'instituicao_id'];

  public static function getItensByInsti($id)
  {
    return Item::all()->where('instituicao_id', $id);
  }
}
