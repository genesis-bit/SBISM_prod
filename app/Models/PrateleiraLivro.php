<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrateleiraLivro extends Model
{
    use HasFactory;
    protected $fillable = [
        'livro_id',
        'prateleira_id',
        'posicao',
        'quantidade_livro',
    ];
    public function Livro()
    {
       return $this->hasOne(Livro::class, 'id', 'livro_id');
    }
    public function Prateleira()
    {
       return $this->hasOne(Prateleira::class, 'id', 'prateleira_id');
    }
}
