<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
     /**
     * Mostrar la página de registro/login
     */
    public function showLoginRegistrar()
    {
        return view('auth.LoginRegistrar');
    }

    /**
     * Registrar usurio
     */
    public function registrar(Request $request)
    {
        // Validar usuario
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:8'
        ]);

        // Crear usuario
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Loguear usuario
        auth()->attempt($request->only('email', 'password'));

        // Redirigir
        return redirect()->route('home');        
    }

    /**
     * Loguear usurio
     */
    public function login(Request $request)
    {
        // Validar usuario
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Loguear usuario
        if (!auth()->attempt($request->only('email', 'password'))) {
            return back()->with('status', 'Usuario o contraseña invalido');
        }

        // Redirigir
        return redirect()->route('home');
    }
}
