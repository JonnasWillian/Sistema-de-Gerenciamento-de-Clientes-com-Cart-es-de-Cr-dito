<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cartao;
use App\Models\User;

class Cartoes extends Controller
{
    public function view ()
    {
        $users = User::with('cartao')->get();
        return response()->json($users);
    }


    public function store(Request $request)
    {
        // Validação dos dados recebidos
        $validatedData = [
            'numero' => $request->numero,
            'data_validade' => $request->data_validade,
            'cvv' => $request->cvv,
            'user_id' => $request->user_id,
        ];

        // Criar o cartão
        $cartao = Cartao::create($validatedData);

        return response()->json([
            'message' => 'Cartão criado com sucesso!',
            'cartao' => $cartao,
        ], 201);
    }


    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'numero' => 'nullable|string|size:16|unique:cartao,numero,' . $id,
            'data_validade' => 'nullable|date',
            'cvv' => 'nullable|string|size:3',
        ]);

        $cartao = Cartao::findOrFail($id);
        $cartao->update($validatedData);

        return response()->json([
            'message' => 'Cartão atualizado com sucesso!',
            'cartao' => $cartao,
        ], 200);
    }


    public function destroy($id)
    {
        $cartao = Cartao::findOrFail($id);
        $cartao->delete();

        return response()->json([
            'message' => 'Cartão excluído com sucesso!',
        ], 200);
    }
}