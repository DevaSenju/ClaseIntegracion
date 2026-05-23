<?php

declare(strict_types=1);

namespace App\Models;

final class ProductRepository extends BaseTextRepository
{
    public function all(): array
    {
        $records = $this->allRecords();
        usort($records, static fn (array $a, array $b): int => $b['id'] <=> $a['id']);
        return $records;
    }

    public function find(int $id): ?array
    {
        foreach ($this->allRecords() as $record) {
            if ((int) $record['id'] === $id) {
                return $record;
            }
        }

        return null;
    }

    public function findBySku(string $sku): ?array
    {
        foreach ($this->allRecords() as $record) {
            if (strcasecmp((string) $record['sku'], $sku) === 0) {
                return $record;
            }
        }

        return null;
    }

    public function create(array $data): array
    {
        $records = $this->allRecords();
        $now = date('Y-m-d H:i:s');
        $record = [
            'id' => $this->nextId($records),
            'sku' => $data['sku'],
            'name' => $data['name'],
            'price' => (float) $data['price'],
            'active' => (bool) $data['active'],
            'created_at' => $now,
            'updated_at' => $now,
        ];

        $records[] = $record;
        $this->saveRecords($records);

        return $record;
    }

    public function update(int $id, array $data): ?array
    {
        $records = $this->allRecords();

        foreach ($records as $index => $record) {
            if ((int) $record['id'] !== $id) {
                continue;
            }

            $records[$index] = [
                ...$record,
                'sku' => $data['sku'],
                'name' => $data['name'],
                'price' => (float) $data['price'],
                'active' => (bool) $data['active'],
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            $this->saveRecords($records);
            return $records[$index];
        }

        return null;
    }
}
