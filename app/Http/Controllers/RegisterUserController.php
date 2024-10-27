<?php

namespace App\Http\Controllers;

use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;

use App\Models\User;

class RegisterUserController extends Controller
{

    public function user_register_form(){ 
        return view('auth.auth_reg_form');
    }

    public function user_register(Request $request){ 
        $valid = $request->validate([
            'nom' => 'required|string|min:1|max:40',
            'prenom' => 'required|string|min:1|max:40',
            'login' => 'required|string|min:1|max:30|unique:users',
            'mdp' => 'required|confirmed|min:1|max:60'
        ]);

        $user = new User();
        $user->nom = $valid['nom'];
        $user->prenom = $valid['prenom'];
        $user->login = $valid['login'];
        $user->mdp = Hash::make($valid['mdp']); 
        $user->save();

        $request->session()->flash('etat','Votre demande a été enregistrée, veuillez patienter qu\'un admin valide votre compte !');
        //Auth::login($user); 

        return redirect()->route('pageIndex');

    }
}
