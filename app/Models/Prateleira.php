<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prateleira extends Model
{
    use HasFactory;
    protected $fillable = [
        'descricao'
    ];
   
    public function Livros()
    { 
        return $this->belongsToMany(Livro::class,'prateleira_livros','prateleira_id','livro_id');
    }
   
}
