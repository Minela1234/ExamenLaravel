<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Etudiant extends Model
{
    protected $fillable = ['prenom','nom','email','date_naissance'];
    public function cours(){
    return $this->belongsToMany(Cours::class);
}   
}
