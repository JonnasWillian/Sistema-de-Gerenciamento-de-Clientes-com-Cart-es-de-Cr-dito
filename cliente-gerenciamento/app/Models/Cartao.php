<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cartao extends Model
{
    protected $table = 'cartoes';
    
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
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
