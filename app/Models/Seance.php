<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Cour;
use App\Models\Etudiant;

class Seance extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $dates = ['date_debut','date_fin'];

    

    //1:* 
    public function cour(){
        return $this->belongsTo(Cour::class,'cours_id');//pas de pivot
    }

    //*:*
    public function etudiants(){
        return $this->belongsToMany(Etudiant::class,'presences','seance_id','etudiant_id');
    }
}
