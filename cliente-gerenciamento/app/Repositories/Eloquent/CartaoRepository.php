<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Interfaces\CartaoRepositoryInterface;
use App\Models\Cartao;

class CartaoRepository implements CartaoRepositoryInterface
{
    public function getAllCartoes()
    {
        try {
            $cartoes = Cartao::all();
            return $cartoes;
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Erro ao recuperar a lista de usuários',
                'details' => $e->getMessage(),
            ], 500); // Código HTTP 500
        }
    }

    public function getCartaoById(int $id)
    {
        try {
            $cartao = Cartao::findOrFail($id); // Lança 404 se o usuário não for encontrado
            return $cartao;
    
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Usuário não encontrado'], 404); // Código HTTP 404
        }
    }

    public function createCartao(array $data)
    {
        try {
            $cartao = Cartao::create($data);
            return $cartao;
    
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Erro inesperado',
                'details' => $e->getMessage(),
            ], 500); // Código HTTP 500
        }
    }

    public function updateCartao(int $id, array $data)
    {
        //return "upd";
        try {
            $cartao = Cartao::findOrFail($id);
            $cartao->update($data);
            return $cartao; // Código HTTP 200
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Usuário não encontrado'], 404);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Erro inesperado',
                'details' => $e->getMessage(),
            ], 500);
        }
    }

    public function deleteCartao(int $id)
    {
        try {
            $cartao = Cartao::findOrFail($id);
            $cartao->delete();
    
            return response()->json(['message' => 'Usuário deletado com sucesso'], 204);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Usuário não encontrado'], 404);
        }
    }
}