<?php

namespace piecing\routing;

use Throwable;

class Router
{
    protected array $routes = [];
    protected array $errorHandler = [];

    /**
     * Adiciona uma nova rota ao roteador.
     *
     * @param string $method Método HTTP da rota (GET, POST, etc.).
     * @param string $path Caminho da rota.
     * @param callable $handler Função de tratamento da rota.
     * @return Route Retorna a instância da rota criada.
     */
    public function add(string $method, string $path, callable $handler): Route
    {
        $route = $this->routes[] = new Route($method, $path, $handler);
        return $route;
    }

    /**
     * Despacha a solicitação atual para a rota correspondente.
     *
     * @return mixed Retorno do handler da rota ou mensagem de erro.
     */
    public function dispatch()
    {
        $paths = $this->paths();

        $requestMethod = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $requestPath = $_SERVER['REQUEST_URI'] ?? '/';

        // Procura uma rota correspondente
        $matching = $this->match($requestMethod, $requestPath);
        if ($matching) {
            try {
                return $matching->dispatch();
            } catch (Throwable $e) {
                // Log do erro (pode ser ajustado para usar um sistema de logging)
                error_log($e->getMessage());
                return $this->dispatchError();
            }
        }

        // Verifica se a rota existe mas o método HTTP não é permitido
        if (in_array($requestPath, $paths)) {
            return $this->dispatchNotAllowed();
        }

        // Retorna 404 se a rota não for encontrada
        return $this->dispatchNotFound();
    }

    /**
     * Obtém todos os caminhos registrados.
     *
     * @return array Lista de caminhos registrados.
     */
    private function paths(): array
    {
        $paths = [];
        foreach ($this->routes as $route) {
            $paths[] = $route->path();
        }
        return $paths;
    }

    /**
     * Encontra uma rota correspondente ao método e caminho fornecidos.
     *
     * @param string $method Método HTTP.
     * @param string $path Caminho solicitado.
     * @return Route|null Rota correspondente ou null se não encontrado.
     */
    private function match(string $method, string $path): ?Route
    {
        foreach ($this->routes as $route) {
            if ($route->matches($method, $path)) {
                return $route;
            }
        }
        return null;
    }

    /**
     * Define um manipulador de erros para um código HTTP específico.
     *
     * @param int $code Código HTTP.
     * @param callable $handler Função de tratamento de erro.
     */
    public function errorHandler(int $code, callable $handler)
    {
        $this->errorHandler[$code] = $handler;
    }

    /**
     * Manipula erros de "Método Não Permitido" (405).
     *
     * @return mixed Mensagem de erro ou retorno do handler.
     */
    public function dispatchNotAllowed()
    {
        $this->errorHandler[405] ??= fn() => "Método não permitido";
        return $this->errorHandler[405]();
    }

    /**
     * Manipula erros de "Página Não Encontrada" (404).
     *
     * @return mixed Mensagem de erro ou retorno do handler.
     */
    public function dispatchNotFound()
    {
        $this->errorHandler[404] ??= fn() => "Página não encontrada";
        return $this->errorHandler[404]();
    }

    /**
     * Manipula erros de servidor (500).
     *
     * @return mixed Mensagem de erro ou retorno do handler.
     */
    public function dispatchError()
    {
        $this->errorHandler[500] ??= fn() => "Erro interno do servidor";
        return $this->errorHandler[500]();
    }

    /**
     * Redireciona para outro caminho.
     *
     * @param string $path Caminho para redirecionar.
     */
    public function redirect($path)
    {
        header("Location: {$path}", true, 301);
        exit;
    }
}
