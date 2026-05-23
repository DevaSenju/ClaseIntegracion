<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\InventoryRepository;
use App\Models\MovementRepository;
use App\Models\ProductRepository;
use App\Services\InventoryService;

final class HomeController extends Controller
{
    public function index(): void
    {
        $service = $this->service();
        $products = $service->productsWithStock();
        usort($products, static fn (array $a, array $b): int => $a['stock'] <=> $b['stock']);

        $this->render('home.index', [
            'flash' => $this->getFlash(),
            'summary' => $service->summary(),
            'lowStockProducts' => array_slice($products, 0, 5),
        ]);
    }

    private function service(): InventoryService
    {
        return new InventoryService(
            new ProductRepository($this->config['paths']['storage'] . '/products.txt'),
            new InventoryRepository($this->config['paths']['storage'] . '/inventory.txt'),
            new MovementRepository($this->config['paths']['storage'] . '/movements.txt')
        );
    }
}
