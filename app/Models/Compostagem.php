<?php

namespace App\Models;

use App\Enums\TipoResiduo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compostagem extends Model
{
    use HasFactory;

    protected $fillable = [
        'data',
        'user_id',
        'material',
        'descricao',
        'volume',
        'tipo',
        'foto',
    ];

    protected $casts = [
        'volume' => 'array',
        'material' => 'array',
        'foto' => 'array',
        'tipo' => TipoResiduo::class
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
