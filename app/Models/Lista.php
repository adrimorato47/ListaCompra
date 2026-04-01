<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lista extends Model
{
    protected $fillable = ['producto', 'comprado', 'supermercado_id'];

    public function supermercado()
    {
        return $this->belongsTo(Supermercado::class);
    }
}
