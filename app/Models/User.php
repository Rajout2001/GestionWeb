<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use App\Models\Cour;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;


    public $timestamps = false; 

    protected $hidden = ['mdp']; 

    protected $fillable = ['nom','prenom','login','mdp','type']; 

    protected $attributes = ['type' => null]; 

    public function getAuthPassword(){
        return $this->mdp;
    }

    public function isAdmin(){
        return $this->type == 'admin';
    }

    public function isGestionnaire(){
        return $this->type == 'gestionnaire' || $this->type == 'admin';
    }

    //*:* 
    public function cours(){
        return $this->belongsToMany(Cour::class,'cours_users','user_id','cours_id');//pas de pivot
    }
}
