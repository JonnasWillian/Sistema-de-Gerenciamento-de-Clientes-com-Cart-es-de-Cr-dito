<?php

namespace App\Repositories\Interfaces;

interface UsuarioRepositoryInterface
{
    public function getAllUsuarios();

    public function getUsuarioById(int $id);

    public function createUsuario(array $data);

    public function updateUsuario(int $id, array $data);

    public function deleteUsuario(int $id);
}