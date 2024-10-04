<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pessoa extends Model
{
    use HasFactory;

    protected $fillable = ['nome_completo', 'user_id', 'data_nascimento', ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function compostagem()
    {
        return $this->hasMany(Compostagem::class);
    }

    public function telefone()
    {
        return $this->hasMany(Telefone::class);
    }

    public function enderecos()
    {
        return $this->hasMany(Endereco::class);
    }

}
