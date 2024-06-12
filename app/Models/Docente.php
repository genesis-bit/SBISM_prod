<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Docente extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'nome',
        'grau_academico_id',
        'especialidade_id',
        'numero_professor',
        'numero_bilhete',
        'contacto',
    ];
    public function GrauAcademico()
    {
       return $this->hasOne(GrauAcademico::class, 'id', 'grau_academico_id');
    }
    public function Especialidade()
    {
       return $this->hasOne(Especialidade::class, 'id', 'especialidade_id');
    }
    public function Usuario()
    {
       return $this->hasOne(User::class, 'id', 'id');
    }
}
