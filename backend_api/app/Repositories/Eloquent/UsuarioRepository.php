<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Interfaces\UsuarioRepositoryInterface;
use App\Models\Usuario;

class UsuarioRepository implements UsuarioRepositoryInterface
{
    public function getAllUsuarios()
    {
        try {
            $usuarios = Usuario::all()->load('cartoes');
            return $usuarios;
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Erro ao recuperar a lista de usuários',
                'details' => $e->getMessage(),
            ], 500);
        }
    }

    public function getUsuarioById(int $id)
    {
        try {
            $usuario = Usuario::findOrFail($id);
            return $usuario;
    
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Usuário não encontrado'], 404);
        }
    }

    public function createUsuario(array $data)
    {
        try {
            $usuario = Usuario::create($data);
            return $usuario;
    
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Erro inesperado',
                'details' => $e->getMessage(),
            ], 500);
        }
    }

    public function updateUsuario(int $id, array $data)
    {
        try {
            $usuario = Usuario::findOrFail($id);
            $usuario->update($data);
            return $usuario;
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Usuário não encontrado'], 404);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Erro inesperado',
                'details' => $e->getMessage(),
            ], 500);
        }
    }

    public function deleteUsuario(int $id)
    {
        try {
            $usuario = Usuario::findOrFail($id);
            $usuario->delete();
    
            return response()->json(['message' => 'Usuário deletado com sucesso'], 204);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Usuário não encontrado'], 404);
        }
    }
}