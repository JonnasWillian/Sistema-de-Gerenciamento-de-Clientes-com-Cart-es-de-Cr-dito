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
                'error' => 'Erro ao recuperar a lista de cartoes',
                'details' => $e->getMessage(),
            ], 500);
        }
    }

    public function getCartaoById(int $id)
    {
        try {
            $cartao = Cartao::findOrFail($id);
            return $cartao;
    
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Cartão não encontrado'], 404);
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
            ], 500);
        }
    }

    public function updateCartao(int $id, array $data)
    {
        try {
            $cartao = Cartao::findOrFail($id);
            $cartao->update($data);
            return $cartao;
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Cartão não encontrado'], 404);
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
    
            return response()->json(['message' => 'Cartão deletado com sucesso'], 204);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Cartão não encontrado'], 404);
        }
    }
}