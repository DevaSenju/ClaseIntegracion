<?php

declare(strict_types=1);

namespace App\Core;

use RuntimeException;

final class Router
{
    private array $routes = [];

    public function add(string $method, string $path, array $handler): void
    {
        $normalizedPath = $this->normalizePath($path);
        $this->routes[strtoupper($method)][$normalizedPath] = $handler;
    }

    public function dispatch(string $path, string $method, array $config): void
    {
        $normalizedPath = $this->normalizePath($path);
        $normalizedMethod = strtoupper($method);
        $handler = $this->routes[$normalizedMethod][$normalizedPath] ?? null;

        if ($handler === null) {
            http_response_code(404);
            echo 'Ruta no encontrada';
            return;
        }

        [$controllerClass, $action] = $handler;
        $controller = new $controllerClass($config);

        if (!method_exists($controller, $action)) {
            throw new RuntimeException('Accion no encontrada.');
        }

        $controller->{$action}();
    }

    private function normalizePath(string $path): string
    {
        $cleanPath = trim(parse_url($path, PHP_URL_PATH) ?: '/', '/');
        return '/' . $cleanPath;
    }
}
