<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCartaoRequest;
use App\Http\Requests\UpdateCartaoRequest;
use App\Services\CartaoService;
use App\Models\Cartao;

class CartaoController extends Controller
{
    protected $cartaoService;

    public function __construct(CartaoService $cartaoService)
    {
        $this->cartaoService = $cartaoService;
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->cartaoService->getAllCartoes();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCartaoRequest $request)
    {
        return $this->cartaoService->createCartao($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        return $this->cartaoService->getCartaoById($id);
    }

    /**
     * Update the specified resource in storage.
     */
    /* public function update(UpdateCartaoRequest $request, Cartao $cartao) */
    public function update(UpdateCartaoRequest $request, int $id)
    {
        return $this->cartaoService->updateCartao($id, $request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    /* public function destroy(Cartao $cartao) */
    public function destroy(int $id)
    {
        return $this->cartaoService->deleteCartao($id);
    }
}
