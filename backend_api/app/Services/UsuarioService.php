<?php

namespace App\Services;

use App\Repositories\Interfaces\UsuarioRepositoryInterface;

class UsuarioService
{
    protected $usuarioRepository;

    public function __construct(UsuarioRepositoryInterface $usuarioRepository)
    {
        $this->usuarioRepository = $usuarioRepository;
    }

    public function getAllUsuarios()
    {
        return $this->usuarioRepository->getAllUsuarios();
    }

    public function getUsuarioById(int $id)
    {
        return $this->usuarioRepository->getUsuarioById($id);
    }

    public function createUsuario(array $data)
    {
        return $this->usuarioRepository->createUsuario($data);
    }

    public function updateUsuario(int $id, array $data)
    {
        return $this->usuarioRepository->updateUsuario($id, $data);
    }

    public function deleteUsuario(int $id)
    {
        return $this->usuarioRepository->deleteUsuario($id);
    }
}