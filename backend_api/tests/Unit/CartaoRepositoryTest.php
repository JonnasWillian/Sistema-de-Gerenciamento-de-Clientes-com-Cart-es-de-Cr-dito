<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Repositories\Eloquent\CartaoRepository;
use App\Models\Usuario;
use App\Models\Cartao;

class CartaoRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected $cartaoRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->cartaoRepository = new CartaoRepository();
    }

    public function testGetAllCartoes()
    {
        Cartao::factory()->count(3)->create();
        $cartoes = $this->cartaoRepository->getAllCartoes();

        $this->assertCount(3, $cartoes);
    }

    public function testGetCartaoById()
    {
        $cartao = Cartao::factory()->create();
        $retrievedCartao = $this->cartaoRepository->getCartaoById($cartao->id);

        $this->assertEquals($cartao->id, $retrievedCartao->id);
    }

    public function testCreateCartao()
    {
        $usuario = Usuario::factory()->create();
        $cartaoData = [
            'usuario_id' => $usuario->id,
            'numero' => '15698532654895215',
            'data_validade' => '2027-08-03',
            'cvv' => '2257'
            ];
        $cartao = $this->cartaoRepository->createCartao($cartaoData);

        $this->assertDatabaseHas('cartoes', ['data_validade' => '2027-08-03']);
        $this->assertEquals($cartaoData['cvv'], $cartao->cvv);
    }

    public function testUpdateCartao()
    {
        $cartao = Cartao::factory()->create(['numero' => '1111222233334444']);
        $updatedData = ['numero' => '5555666677778888'];

        $updatedCartao = $this->cartaoRepository->updateCartao($cartao->id, $updatedData);

        $this->assertEquals('5555666677778888', $updatedCartao->numero);
    }

    public function testDeleteCartao()
    {
        $cartao = Cartao::factory()->create();
        $result = $this->cartaoRepository->deleteCartao($cartao->id);

        $this->assertDatabaseMissing('cartoes', ['id' => $cartao->id]);
    }
}
