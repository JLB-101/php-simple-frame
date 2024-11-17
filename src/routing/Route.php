<?php
namespace piecing\routing;

class Route {
    // Propriedades protegidas para armazenar o método HTTP, o caminho e o handler da rota.
    protected string $method;
    protected string $path;
    protected $handler;

    /**
     * Construtor para inicializar a rota.
     *
     * @param string $method Método HTTP da rota (GET, POST, etc.).
     * @param string $path Caminho associado à rota.
     * @param callable $handler Função ou método responsável por processar a rota.
     */
    public function __construct(string $method, string $path, callable $handler) {
        $this->method = $method;
        $this->path = $path;
        $this->handler = $handler;
    }

    /**
     * Obtém o método HTTP da rota.
     *
     * @return string Método HTTP.
     */
    public function method(): string {
        return $this->method;
    }

    /**
     * Obtém o caminho da rota.
     *
     * @return string Caminho da rota.
     */
    public function path(): string {
        return $this->path;
    }

    /**
     * Verifica se o método e o caminho correspondem à rota.
     *
     * @param string $method Método HTTP a ser verificado.
     * @param string $path Caminho a ser verificado.
     * @return bool Retorna true se corresponder, false caso contrário.
     */
    public function matches(string $method, string $path): bool {
        return $this->method === $method && $this->path === $path;
    }

    /**
     * Executa o handler associado à rota.
     *
     * @return mixed Retorno do handler.
     */
    public function dispatch() {
        return call_user_func($this->handler);
    }
}
