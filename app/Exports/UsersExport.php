<?php

namespace App\Exports;

use App\Services\Database\Exporter;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithMapping;

class UsersExport extends Exporter implements WithMapping
{
    public function collection(): Collection
    {
        return $this->users();
    }

    public function map($row): array
    {
        return parent::map(Arr::except(array_merge($row->toArray(), [
            'password' => $row->password,
            'remember_token' => $row->remember_token,
            'two_factor_recovery_codes' => $row->two_factor_recovery_codes,
            'two_factor_secret' => $row->two_factor_secret,
        ]), $row->getAppends()));
    }
}
