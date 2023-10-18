<?php

namespace App\Services\Database;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

abstract class Exporter implements FromCollection, WithHeadings, WithMapping
{
    use Exportable;

    /** @return Collection<array-key, Model> */
    abstract public function collection(): Collection;

    protected function users(array $relations = []): Collection
    {
        return User::query()
            ->whereIn('email', config('app.backup.user_emails'))
            ->with($relations)
            ->get();
    }

    public function headings(): array
    {
        $model = $this->collection()->first();

        $attributeKeys = match (true) {
            $model instanceof Model => array_keys($model->getAttributes() ?? []),
            $model instanceof \StdClass => array_keys((array) $model),
            default => [],
        };

        ksort($attributeKeys);

        array_unshift($attributeKeys, 'id');

        return array_unique($attributeKeys);
    }

    /** @var array<string, mixed> $row */
    public function map($row): array
    {
        $row = (array) $row;

        return collect($this->headings())
            ->mapWithKeys(
                fn ($key) => [$key => $row[$key] ?? null],
            )->all();
    }
}
