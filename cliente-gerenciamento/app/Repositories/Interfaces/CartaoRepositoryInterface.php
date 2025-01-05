<?php

namespace App\Repositories\Interfaces;

interface CartaoRepositoryInterface
{
    public function getAllCartoes();

    public function getCartaoById(int $id);

    public function createCartao(array $data);

    public function updateCartao(int $id, array $data);

    public function deleteCartao(int $id);
}