<?php

declare(strict_types=1);

namespace App\Models;

final class InventoryRepository extends BaseTextRepository
{
    public function all(): array
    {
        return $this->allRecords();
    }

    public function findByProductId(int $productId): ?array
    {
        foreach ($this->allRecords() as $record) {
            if ((int) $record['product_id'] === $productId) {
                return $record;
            }
        }

        return null;
    }

    public function getStock(int $productId): int
    {
        $record = $this->findByProductId($productId);
        return $record === null ? 0 : (int) $record['stock'];
    }

    public function setStock(int $productId, int $stock): array
    {
        $records = $this->allRecords();
        $now = date('Y-m-d H:i:s');

        foreach ($records as $index => $record) {
            if ((int) $record['product_id'] !== $productId) {
                continue;
            }

            $records[$index]['stock'] = $stock;
            $records[$index]['updated_at'] = $now;
            $this->saveRecords($records);
            return $records[$index];
        }

        $newRecord = [
            'id' => $this->nextId($records),
            'product_id' => $productId,
            'stock' => $stock,
            'updated_at' => $now,
        ];

        $records[] = $newRecord;
        $this->saveRecords($records);

        return $newRecord;
    }
}
