<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MateriasXUsuario extends Model
{
    //use HasFactory;
    public $timestamps = false;

    protected $table = 'materias_x_usuarios';

    protected $fillable = [
        'materia_id',
        'users_id'
    ];

    public function materia(){
        return $this->belongsTo(Materia::class, 'materias_id');
    }

    public function users(){
        return $this->belongsTo(User::class, 'users_id');
    }

    public function calificaciones(){
        return $this->hasMany(Calificacion::class, 'materias_x_usuarios_id');
    }
}