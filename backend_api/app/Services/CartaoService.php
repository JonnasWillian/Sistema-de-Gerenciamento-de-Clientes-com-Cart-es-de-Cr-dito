<?php

namespace App\Services;

use App\Repositories\Interfaces\CartaoRepositoryInterface;

class CartaoService
{
    protected $cartaoRepository;

    public function __construct(CartaoRepositoryInterface $cartaoRepository)
    {
        $this->cartaoRepository = $cartaoRepository;
    }

    public function getAllCartoes()
    {
        return $this->cartaoRepository->getAllCartoes();
    }

    public function getCartaoById(int $id)
    {
        return $this->cartaoRepository->getCartaoById($id);
    }

    public function createCartao(array $data)
    {
        return $this->cartaoRepository->createCartao($data);
    }

    public function updateCartao(int $id, array $data)
    {
        return $this->cartaoRepository->updateCartao($id, $data);
    }

    public function deleteCartao(int $id)
    {
        return $this->cartaoRepository->deleteCartao($id);
    }
}