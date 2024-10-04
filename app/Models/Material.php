<?php

namespace App\Models;

use App\Enums\TipoResiduo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    protected $fillable = [
        'descricao',
        'tipo',
    ];

    protected $casts = ['tipo'=> TipoResiduo::class];

}
