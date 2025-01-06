<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Mockery;
use App\Services\CartaoService;
use App\Repositories\Interfaces\CartaoRepositoryInterface;

class CartaoServiceTest extends TestCase
{
    protected $cartaoService;
    protected $cartaoRepositoryMock;

    protected function setUp(): void
    {
        parent::setUp();

        // Mock do CartaoRepositoryInterface
        $this->cartaoRepositoryMock = Mockery::mock(CartaoRepositoryInterface::class);
        $this->cartaoService = new CartaoService($this->cartaoRepositoryMock);
    }

    public function testGetAllCartoes()
    {
        $cartoes = [
            ['id' => 1, 'numero' => '15698532654895215', 'data_validade' => '2027-08-03', 'cvv' => '2257'],
            ['id' => 2, 'numero' => '36985845455652121', 'data_validade' => '2025-02-15'], 'cvv' => '2506'];

        $this->cartaoRepositoryMock
            ->shouldReceive('getAllCartoes')
            ->once()
            ->andReturn($cartoes);

        $result = $this->cartaoService->getAllCartoes();
        $this->assertEquals($cartoes, $result);
    }

    public function testCreateCartao()
    {
        $cartaoData = ['numero' => '15698532654895215', 'data_validade' => '2027-08-03', 'cvv' => '2257'];
        $createdCartao = ['id' => 1, 'numero' => '15698532654895215', 'data_validade' => '2027-08-03', 'cvv' => '2257'];

        $this->cartaoRepositoryMock
            ->shouldReceive('createCartao')
            ->once()
            ->with($cartaoData)
            ->andReturn($createdCartao);

        $result = $this->cartaoService->createCartao($cartaoData);
        $this->assertEquals($createdCartao, $result);
    }

    public function testDeleteCartao()
    {
        $cartaoId = 1;

        $this->cartaoRepositoryMock
            ->shouldReceive('deleteCartao')
            ->once()
            ->with($cartaoId)
            ->andReturn(true);

        $result = $this->cartaoService->deleteCartao($cartaoId);
        $this->assertTrue($result);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
