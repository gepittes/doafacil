<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cidade extends Model
{
  protected $table = 'app.cidades';

  protected $fillable = ['nm_cidade', 'estado_id'];
}
