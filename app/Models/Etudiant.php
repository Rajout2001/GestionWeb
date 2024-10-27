<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Cour;
use App\Models\Seance;

class Etudiant extends Model
{
    use HasFactory;

    //*:*
    public function seances(){
        return $this->belongsToMany(Seance::class,'presences','etudiant_id','seance_id');//pas de pivot
    }

    //*:*
    public function cours(){
        return $this->belongsToMany(Cour::class,'cours_etudiants','etudiant_id','cours_id');
    }
}
