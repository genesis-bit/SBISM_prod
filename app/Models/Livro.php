<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Livro extends Model
{
    use HasFactory;
    protected $fillable = [
        'titulo',
        'autor',
        'editora',
        'ano_edicao',
        'genero_livro_id',
        'observacao',
    ];
    public function GeneroLivro()
    {
       return $this->hasOne(GeneroLivro::class, 'id', 'genero_livro_id');
    }
}
