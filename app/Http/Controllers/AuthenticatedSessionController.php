<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthenticatedSessionController extends Controller
{
    public function user_login_form(){ 
        return view('auth.auth_log_form');
    }

    public function user_login(Request $request){

        $request->validate([
            'login' => 'required|string|max:40|min:1',
            'mdp' => 'required|max:40|min:1',
        ]);

        $credit = [
            'login' => $request->input('login'),
            'password' => $request->input('mdp')
        ];
        
        $user = User::where('login', '=', $request->login)->first();
        if ($user) {
            if ($user->type == null) {
                return redirect()->route('pageIndex')->with('etat', 'L\'admin n\'a pas validé votre compte');
            }
        }

        if (Auth::attempt($credit)) {
            $request->session()->regenerate();
            $request->session()->flash('etat', 'Login validé !');

            if ($request->user()->isAdmin()) {
                return redirect()->intended('/admin_index');
            }
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'login' => 'Les informations saisies ne sont pas correctes!',
        ]);
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        $request->session()->flash('etat', 'Déconnecté !');
        return redirect('/');
    }
}
