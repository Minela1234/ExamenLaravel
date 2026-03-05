<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cours extends Model
{
    protected $table='cours';
    protected $fillable=['libelle','professeur','volume_horaire'];
    public function etudiants(){
        return $this->belongsToMany(Etudiant::class);
    }
}
