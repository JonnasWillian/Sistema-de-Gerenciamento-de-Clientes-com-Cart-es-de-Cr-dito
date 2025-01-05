<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class Users extends Controller
{
    public function store(Request $request)
    {
        $user = User::create([
            'nome' => $request['nome'],
            'sobrenome' => $request['sobrenome'],
            'email' => $request['email'],
            'endereco' => $request['endereco'],
            'telefone' => $request['telefone'],
            'data_nascimento' => $request['data_nascimento'],
        ]);

        return response()->json($user, 201);
    }


    public function update(Request $request, $id)
    {
        // Validação dos dados recebidos
        $validatedData = [
            'nome' => $request['nome'],
            'sobrenome' => $request['sobrenome'],
            'email' => $request['email'],
            'endereco' => $request['endereco'],
            'telefone' => $request['telefone'],
            'data_nascimento' => $request['data_nascimento'],
        ];

        $user = User::findOrFail($id);

        // if ($request->has('password')) {
        //     $validatedData['password'] = bcrypt($validatedData['password']);
        // }

        $user->update($validatedData);

        return response()->json([
            'message' => 'Usuário atualizado com sucesso!',
            'user' => $user,
        ], 200);
    }


    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json([
            'message' => 'Usuário excluído com sucesso!',
        ], 200);
    }
}
