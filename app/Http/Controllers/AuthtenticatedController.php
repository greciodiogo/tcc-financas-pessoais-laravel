<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function authenticate(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('authToken')->accessToken;

            return response()->json([
                'user' => $user,
                'token' => $token,
                'message' => 'Seja Bem-vindo Sr(a)'
            ], 200);
        }

        return response()->json([
            'message' => 'Nome de utilizador ou Password Inválido, ou consulte o administrador para verificar se a sua conta está ativa'
        ], 401);
    }

    public function signup(Request $request)
{
    $request->validate([
        'username' => 'required|string|unique:users,username',
        'password' => 'required|string|confirmed',
        'name' => 'required|string'
    ]);

    try {
        // Criar novo usuário
        $user = User::create([
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'name' => $request->name,
        ]);

        // Criar conta associada
        $user->conta()->create([
            'contaDescricao' => 'Conta',
            'moeda_id' => 1,
            'saldo_actual' => 0,
        ]);

        // Autenticar e gerar token
        $credentials = $request->only('username', 'password');
        if (Auth::attempt($credentials)) {
            $token = $user->createToken('authToken')->accessToken;
            return response()->json([
                'user' => $user,
                'token' => $token,
                'message' => 'Seja Bem-vindo Sr(a)'
            ], 200);
        }

    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Falha na autenticação. Consulte o administrador para resolver o problema.',
            'error' => $e->getMessage()
        ], 401);
    }
}

}
