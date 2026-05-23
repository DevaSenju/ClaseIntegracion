<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\InventoryRepository;
use App\Models\MovementRepository;
use App\Models\ProductRepository;
use App\Services\InventoryService;
use Throwable;

final class MovementController extends Controller
{
    public function index(): void
    {
        $this->render('movements.index', [
            'flash' => $this->getFlash(),
            'movements' => $this->service()->movementsWithProducts(),
        ]);
    }

    public function create(): void
    {
        $this->render('movements.create', [
            'flash' => $this->getFlash(),
            'products' => $this->service()->activeProductsWithStock(),
            'values' => [
                'product_id' => '',
                'type' => 'restock',
                'quantity' => '1',
                'note' => '',
            ],
        ]);
    }

    public function store(): void
    {
        try {
            $this->service()->registerMovement($_POST);
            $this->setFlash('success', 'Movimiento registrado y existencias actualizadas.');
            $this->redirect('/movements');
        } catch (Throwable $exception) {
            $this->render('movements.create', [
                'flash' => ['type' => 'error', 'message' => $exception->getMessage()],
                'products' => $this->service()->activeProductsWithStock(),
                'values' => $_POST,
            ]);
        }
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
