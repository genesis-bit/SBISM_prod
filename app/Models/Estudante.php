<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estudante extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'nome',
        'curso_id',
        'numero_estudante',
        'numero_bilhete',
        'contacto',
    ];
    public function Curso()
    {
       return $this->hasOne(Curso::class, 'id', 'curso_id');
    }
    public function Usuario()
    {
       return $this->hasOne(User::class, 'id', 'id');
    }
}
