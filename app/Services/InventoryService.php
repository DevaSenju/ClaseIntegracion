<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\InventoryRepository;
use App\Models\MovementRepository;
use App\Models\ProductRepository;
use InvalidArgumentException;
use RuntimeException;

final class InventoryService
{
    public function __construct(
        private ProductRepository $products,
        private InventoryRepository $inventory,
        private MovementRepository $movements
    ) {
    }

    public function createProduct(array $data): array
    {
        $sku = strtoupper(trim((string) ($data['sku'] ?? '')));
        $name = trim((string) ($data['name'] ?? ''));
        $price = (float) ($data['price'] ?? 0);
        $initialStock = (int) ($data['initial_stock'] ?? 0);
        $active = !empty($data['active']);

        if ($sku === '' || $name === '') {
            throw new InvalidArgumentException('SKU y nombre son obligatorios.');
        }

        if ($price < 0 || $initialStock < 0) {
            throw new InvalidArgumentException('Precio y stock inicial deben ser valores positivos.');
        }

        if ($this->products->findBySku($sku) !== null) {
            throw new InvalidArgumentException('El SKU ya existe.');
        }

        $product = $this->products->create([
            'sku' => $sku,
            'name' => $name,
            'price' => $price,
            'active' => $active,
        ]);

        $this->inventory->setStock((int) $product['id'], $initialStock);

        return $product;
    }

    public function updateProduct(int $id, array $data): array
    {
        $product = $this->products->find($id);
        if ($product === null) {
            throw new RuntimeException('Producto no encontrado.');
        }

        $sku = strtoupper(trim((string) ($data['sku'] ?? '')));
        $name = trim((string) ($data['name'] ?? ''));
        $price = (float) ($data['price'] ?? 0);
        $active = isset($data['active']) && (string) $data['active'] === '1';

        if ($sku === '' || $name === '') {
            throw new InvalidArgumentException('SKU y nombre son obligatorios.');
        }

        if ($price < 0) {
            throw new InvalidArgumentException('El precio no puede ser negativo.');
        }

        $existing = $this->products->findBySku($sku);
        if ($existing !== null && (int) $existing['id'] !== $id) {
            throw new InvalidArgumentException('El SKU ya pertenece a otro producto.');
        }

        $updated = $this->products->update($id, [
            'sku' => $sku,
            'name' => $name,
            'price' => $price,
            'active' => $active,
        ]);

        if ($updated === null) {
            throw new RuntimeException('No se pudo actualizar el producto.');
        }

        return $updated;
    }

    public function registerMovement(array $data): array
    {
        $productId = (int) ($data['product_id'] ?? 0);
        $type = (string) ($data['type'] ?? '');
        $quantity = (int) ($data['quantity'] ?? 0);
        $note = trim((string) ($data['note'] ?? ''));

        $product = $this->products->find($productId);
        if ($product === null) {
            throw new RuntimeException('Producto no encontrado.');
        }

        if ($type !== 'sale' && $type !== 'restock') {
            throw new InvalidArgumentException('Tipo de movimiento invalido.');
        }

        if ($quantity <= 0) {
            throw new InvalidArgumentException('La cantidad debe ser mayor que cero.');
        }

        $currentStock = $this->inventory->getStock($productId);
        if ($type === 'sale' && $quantity > $currentStock) {
            throw new InvalidArgumentException('No hay existencias suficientes para registrar la venta.');
        }

        $newStock = $type === 'sale'
            ? $currentStock - $quantity
            : $currentStock + $quantity;

        $this->inventory->setStock($productId, $newStock);

        return $this->movements->create([
            'product_id' => $productId,
            'type' => $type,
            'quantity' => $quantity,
            'note' => $note,
            'stock_before' => $currentStock,
            'stock_after' => $newStock,
        ]);
    }

    public function productsWithStock(): array
    {
        $rows = [];
        foreach ($this->products->all() as $product) {
            $rows[] = [
                ...$product,
                'stock' => $this->inventory->getStock((int) $product['id']),
            ];
        }

        return $rows;
    }

    public function activeProductsWithStock(): array
    {
        return array_values(array_filter(
            $this->productsWithStock(),
            static fn (array $product): bool => (bool) $product['active']
        ));
    }

    public function movementsWithProducts(): array
    {
        $products = [];
        foreach ($this->products->all() as $product) {
            $products[(int) $product['id']] = $product;
        }

        $rows = [];
        foreach ($this->movements->all() as $movement) {
            $product = $products[(int) $movement['product_id']] ?? null;
            $rows[] = [
                ...$movement,
                'product_name' => $product['name'] ?? 'Producto eliminado',
                'product_sku' => $product['sku'] ?? '-',
            ];
        }

        return $rows;
    }

    public function summary(): array
    {
        $products = $this->productsWithStock();
        $stockTotal = 0;
        $lowStock = 0;

        foreach ($products as $product) {
            $stockTotal += (int) $product['stock'];
            if ((int) $product['stock'] <= 5) {
                $lowStock++;
            }
        }

        return [
            'products' => count($products),
            'stock_total' => $stockTotal,
            'movements' => count($this->movements->all()),
            'low_stock' => $lowStock,
        ];
    }
}
