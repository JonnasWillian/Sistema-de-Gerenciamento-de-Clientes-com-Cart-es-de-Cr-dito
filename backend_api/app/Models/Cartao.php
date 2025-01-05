<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cartao extends Model
{
    protected $table = 'cartoes';

    /** @use HasFactory<\Database\Factories\CartaoFactory> */
    use HasFactory;

    protected $fillable = [
        'usuario_id',
        'numero',
        'data_validade',
        'cvv'
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }
}
