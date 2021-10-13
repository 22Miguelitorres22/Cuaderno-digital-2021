<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class RegisterController extends Controller
{
    public function __construct() {
        $this->middleware('guest');
    }

    public function index() {
        return view('auth.register');
    }

    public function register(Request $request) {
        // Valido; si falla, lanza una excepción
        $this->validate($request, [
            'name' => 'required|max:255',
            'username' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed' // Confirmed hace que el validador mire el campo con _confirmation
        ]);

        // Grabo
        $usuario = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);


        // Asigno rol por defecto "ALUMNO"
        $rolAlumno = Role::findByName('Alumno');
        $usuario->assignRole($rolAlumno);

        // Redirecciono
        return redirect()->route('login');
    }
}
