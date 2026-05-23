<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\InventoryRepository;
use App\Models\MovementRepository;
use App\Models\ProductRepository;
use App\Services\InventoryService;
use Throwable;

final class ProductController extends Controller
{
    public function index(): void
    {
        $this->render('products.index', [
            'flash' => $this->getFlash(),
            'products' => $this->service()->productsWithStock(),
        ]);
    }

    public function create(): void
    {
        $this->render('products.create', [
            'flash' => $this->getFlash(),
            'values' => [
                'sku' => '',
                'name' => '',
                'price' => '0.00',
                'initial_stock' => '0',
                'active' => '1',
            ],
        ]);
    }

    public function store(): void
    {
        try {
            $this->service()->createProduct($_POST);
            $this->setFlash('success', 'Producto creado correctamente.');
            $this->redirect('/products');
        } catch (Throwable $exception) {
            $this->render('products.create', [
                'flash' => ['type' => 'error', 'message' => $exception->getMessage()],
                'values' => $_POST,
            ]);
        }
    }

    public function edit(): void
    {
        $id = (int) $this->request('id', 0);
        $product = $this->repository()->find($id);

        if ($product === null) {
            $this->setFlash('error', 'Producto no encontrado.');
            $this->redirect('/products');
        }

        $this->render('products.edit', [
            'flash' => $this->getFlash(),
            'product' => $product,
            'stock' => $this->inventoryRepository()->getStock($id),
        ]);
    }

    public function update(): void
    {
        $id = (int) $this->request('id', 0);

        try {
            $this->service()->updateProduct($id, $_POST);
            $this->setFlash('success', 'Producto actualizado correctamente.');
            $this->redirect('/products');
        } catch (Throwable $exception) {
            $product = $this->repository()->find($id);

            $this->render('products.edit', [
                'flash' => ['type' => 'error', 'message' => $exception->getMessage()],
                'product' => $product === null ? $_POST : array_merge($product, $_POST),
                'stock' => $this->inventoryRepository()->getStock($id),
            ]);
        }
    }

    private function service(): InventoryService
    {
        return new InventoryService(
            $this->repository(),
            $this->inventoryRepository(),
            new MovementRepository($this->config['paths']['storage'] . '/movements.txt')
        );
    }

    private function repository(): ProductRepository
    {
        return new ProductRepository($this->config['paths']['storage'] . '/products.txt');
    }

    private function inventoryRepository(): InventoryRepository
    {
        return new InventoryRepository($this->config['paths']['storage'] . '/inventory.txt');
    }
}
