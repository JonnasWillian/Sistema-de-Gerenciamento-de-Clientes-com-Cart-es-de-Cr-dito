<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Repositories\Eloquent\UsuarioRepository;
use App\Models\Usuario;

class UsuarioRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected $usuarioRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->usuarioRepository = new UsuarioRepository();
    }

    public function testGetAllUsuarios()
    {
        Usuario::factory()->count(3)->create();
        $usuarios = $this->usuarioRepository->getAllUsuarios();

        $this->assertCount(3, $usuarios);
    }

    public function testGetUsuarioById()
    {
        $usuario = Usuario::factory()->create();
        $retrievedUsuario = $this->usuarioRepository->getUsuarioById($usuario->id);

        $this->assertEquals($usuario->id, $retrievedUsuario->id);
    }

    public function testCreateUsuario()
    {
        $usuarioData = ['nome' => 'John', 'sobrenome' => 'Doe', 'email' => 'john@example.com', 'data_nascimento' => '1995-05-22', 'endereco' => 'Avenida PHP Online', 'telefone' => '71986932254'];
        $usuario = $this->usuarioRepository->createUsuario($usuarioData);

        $this->assertDatabaseHas('usuarios', ['email' => 'john@example.com']);
        $this->assertEquals($usuarioData['nome'], $usuario->nome);
    }

    public function testUpdateUsuario()
    {
        $usuario = Usuario::factory()->create(['nome' => 'Nome Antigo']);
        $updatedData = ['nome' => 'Novo Nome'];

        $updatedUsuario = $this->usuarioRepository->updateUsuario($usuario->id, $updatedData);

        $this->assertEquals('Novo Nome', $updatedUsuario->nome);
    }

    public function testDeleteUsuario()
    {
        $usuario = Usuario::factory()->create();
        $this->usuarioRepository->deleteUsuario($usuario->id);

        $this->assertDatabaseMissing('usuarios', ['id' => $usuario->id]);
    }
}
