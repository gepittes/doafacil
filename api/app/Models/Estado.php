<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
  protected $table = 'app.estados';

  protected $fillable = ['nm_estado', 'sg_estado'];
}
