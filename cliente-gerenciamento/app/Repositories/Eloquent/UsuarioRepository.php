<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Interfaces\UsuarioRepositoryInterface;
use App\Models\Usuario;

class UsuarioRepository implements UsuarioRepositoryInterface
{
    public function getAllUsuarios()
    {
        try {
            $usuarios = Usuario::all();
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
            $usuario = Usuario::findOrFail($id); // Lança 404 se o usuário não for encontrado
            return $usuario;
    
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Usuário não encontrado'], 404); // Código HTTP 404
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
            ], 500); // Código HTTP 500
        }
    }

    public function updateUsuario(int $id, array $data)
    {
        try {
            $usuario = Usuario::findOrFail($id);
            $usuario->update($data);
            return $usuario; // Código HTTP 200
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