
<?php

use PHPUnit\Framework\TestCase;
use Slim\Psr7\Factory\ServerRequestFactory;

class UsuarioTeste extends TestCase
{
    private function criarApp()
    {
        require __DIR__ . '/../src/app.php';
        return $app;
    }

    public function testGetStatus(): void
    {
        $app = $this->criarApp();

        $request = (new ServerRequestFactory())
            ->createServerRequest('GET', '/status');

        $response = $app->handle($request);

        $this->assertEquals(200, $response->getStatusCode());

        $corpo = json_decode((string) $response->getBody(), true);

        $this->assertEquals('API funcionando', $corpo['status']);
    }

    public function testGetListaUsuarios(): void
    {
        $app = $this->criarApp();

        $request = (new ServerRequestFactory())
            ->createServerRequest('GET', '/usuarios');

        $response = $app->handle($request);

        $this->assertEquals(200, $response->getStatusCode());

        $corpo = json_decode((string) $response->getBody(), true);

        $this->assertCount(5, $corpo);
        $this->assertEquals('João Silva', $corpo[0]['nome']);
    }

    public function testGetBuscaUsuario(): void
    {
        $app = $this->criarApp();

        $request = (new ServerRequestFactory())
            ->createServerRequest('GET', '/usuarios/1');

        $response = $app->handle($request);

        $this->assertEquals(200, $response->getStatusCode());

        $corpo = json_decode((string) $response->getBody(), true);

        $this->assertEquals('João Silva', $corpo['nome']);
    }

    public function testPostCriaUsuario(): void
    {
        $app = $this->criarApp();

        $dados = [
            'nome' => 'Francisco',
            'email' => 'francisco@email.com',
            'senha' => '123456'
        ];

        $request = (new ServerRequestFactory())
            ->createServerRequest('POST', '/usuarios')
            ->withHeader('Content-Type', 'application/json');

        $request->getBody()->write(json_encode($dados));
        $request->getBody()->rewind();

        $response = $app->handle($request);

        $this->assertEquals(201, $response->getStatusCode());

        $corpo = json_decode((string) $response->getBody(), true);

        $this->assertEquals('Francisco', $corpo['nome']);
        $this->assertEquals('francisco@email.com', $corpo['email']);
        $this->assertEquals(6, $corpo['id']);
    }

    public function testPutAtualizaUsuario(): void
    {
        $app = $this->criarApp();

        $dados = [
            'nome' => 'João Atualizado',
            'email' => 'joao.novo@email.com',
            'senha' => '654321'
        ];

        $request = (new ServerRequestFactory())
            ->createServerRequest('PUT', '/usuarios/1')
            ->withHeader('Content-Type', 'application/json');

        $request->getBody()->write(json_encode($dados));
        $request->getBody()->rewind();

        $response = $app->handle($request);

        $this->assertEquals(200, $response->getStatusCode());

        $corpo = json_decode((string) $response->getBody(), true);

        $this->assertEquals('João Atualizado', $corpo['nome']);
        $this->assertEquals('joao.novo@email.com', $corpo['email']);
    }

    public function testDeleteExcluiUsuario(): void
    {
        $app = $this->criarApp();

        $request = (new ServerRequestFactory())
            ->createServerRequest('DELETE', '/usuarios/1');

        $response = $app->handle($request);

        // A sua API retorna 200, não 204.
        $this->assertEquals(200, $response->getStatusCode());

        $corpo = json_decode((string) $response->getBody(), true);

        $this->assertEquals(
            'Usuário excluído com sucesso',
            $corpo['mensagem']
        );
    }

    public function testPostLogin(): void
    {
        $app = $this->criarApp();

        $dados = [
            'email' => 'joao@email.com',
            'senha' => '123456'
        ];

        $request = (new ServerRequestFactory())
            ->createServerRequest('POST', '/login')
            ->withHeader('Content-Type', 'application/json');

        $request->getBody()->write(json_encode($dados));
        $request->getBody()->rewind();

        $response = $app->handle($request);

        $this->assertEquals(200, $response->getStatusCode());

        $corpo = json_decode((string) $response->getBody(), true);

        $this->assertEquals(
            'Login realizado com sucesso',
            $corpo['mensagem']
        );

        $this->assertArrayNotHasKey('senha', $corpo['usuario']);
    }
}
