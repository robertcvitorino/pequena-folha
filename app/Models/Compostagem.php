<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compostagem extends Model
{
    use HasFactory;

    protected  $fillable = [
        'data',
        'pessoa_id',
        'material_id',
        'descricao',
        'volume',
        'tipo',
    ];

    public function pessoa()
    {
        return $this->belongsTo(Pessoa::class);
    }

    public function material()
    {
        return $this->belongsTo(Material::class, );
    }
}
