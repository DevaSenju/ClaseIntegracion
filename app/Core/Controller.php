<?php

declare(strict_types=1);

namespace App\Core;

abstract class Controller
{
    public function __construct(protected array $config)
    {
    }

    protected function render(string $view, array $data = []): void
    {
        $viewPath = $this->config['paths']['views'] . '/' . str_replace('.', '/', $view) . '.php';
        $layoutPath = $this->config['paths']['views'] . '/layouts/main.php';

        extract($data, EXTR_SKIP);

        ob_start();
        require $viewPath;
        $content = ob_get_clean();

        require $layoutPath;
    }

    protected function redirect(string $route): void
    {
        header('Location: ?route=' . $route);
        exit;
    }

    protected function setFlash(string $type, string $message): void
    {
        $_SESSION['flash'] = [
            'type' => $type,
            'message' => $message,
        ];
    }

    protected function getFlash(): ?array
    {
        $flash = $_SESSION['flash'] ?? null;
        unset($_SESSION['flash']);

        return $flash;
    }

    protected function request(string $key, mixed $default = null): mixed
    {
        return $_POST[$key] ?? $_GET[$key] ?? $default;
    }
}
