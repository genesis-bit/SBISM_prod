<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Devolucao extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'bibliotecario_id',
        'data'
    ];
    public function Biblioteca()
    {
       return $this->hasOne(User::class, 'id', 'bibliotecario_id');
    }
    public function Emprestimo()
    {
       return $this->hasOne(Emprestimo::class, 'id', 'id');
    }
}
