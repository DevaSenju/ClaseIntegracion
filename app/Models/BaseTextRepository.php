<?php

declare(strict_types=1);

namespace App\Models;

abstract class BaseTextRepository
{
    public function __construct(protected string $filePath)
    {
        if (!is_file($this->filePath)) {
            file_put_contents($this->filePath, json_encode([], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        }
    }

    protected function allRecords(): array
    {
        $contents = file_get_contents($this->filePath);
        if ($contents === false || trim($contents) === '') {
            return [];
        }

        $records = json_decode($contents, true);
        return is_array($records) ? $records : [];
    }

    protected function saveRecords(array $records): void
    {
        file_put_contents(
            $this->filePath,
            json_encode(array_values($records), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        );
    }

    protected function nextId(array $records): int
    {
        $ids = array_column($records, 'id');
        return $ids === [] ? 1 : (max($ids) + 1);
    }
}
