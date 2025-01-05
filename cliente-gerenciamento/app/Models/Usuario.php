<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    /** @use HasFactory<\Database\Factories\UsuarioFactory> */
    use HasFactory;

    protected $fillable = [
        'nome',
        'sobrenome',
        'email',
        'data_nascimento',
        'endereco',
        'telefone'
        
    ];

    public function cartoes()
    {
        return $this->hasMany(Cartao::class);
    }
}