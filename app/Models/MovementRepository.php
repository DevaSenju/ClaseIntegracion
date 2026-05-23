<?php

declare(strict_types=1);

namespace App\Models;

final class MovementRepository extends BaseTextRepository
{
    public function all(): array
    {
        $records = $this->allRecords();
        usort($records, static fn (array $a, array $b): int => $b['id'] <=> $a['id']);
        return $records;
    }

    public function create(array $data): array
    {
        $records = $this->allRecords();
        $record = [
            'id' => $this->nextId($records),
            'product_id' => (int) $data['product_id'],
            'type' => $data['type'],
            'quantity' => (int) $data['quantity'],
            'note' => $data['note'],
            'stock_before' => (int) $data['stock_before'],
            'stock_after' => (int) $data['stock_after'],
            'created_at' => date('Y-m-d H:i:s'),
        ];

        $records[] = $record;
        $this->saveRecords($records);

        return $record;
    }
}
