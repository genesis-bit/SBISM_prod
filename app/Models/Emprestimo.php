<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Emprestimo extends Model
{
    use HasFactory;
    protected $fillable = [
        'livro_id',
        'user_id',
        'tipo_emprestimo_id',
        'bibliotecario_id',
        'data_emprestimo',
    ];
    public function Livro()
    {
       return $this->hasOne(Livro::class, 'id', 'livro_id');
    }
    public function Emprestante()
    {
       return $this->hasOne(User::class, 'id', 'user_id');
    }
    public function Bibliotecario()
    {
       return $this->hasOne(User::class, 'id', 'bibliotecario_id');
    }
    public function TipoE()
    {
       return $this->hasOne(TipoEmprestimo::class, 'id', 'tipo_emprestimo_id');
    }
    public function Devolucao()
    {
       return $this->hasOne(Devolucao::class, 'id', 'id');
    }
}
