<?php

namespace App\Services\Database;

use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

abstract class Importer implements ToModel, WithHeadingRow
{
    use Importable;

    public function model(array $row): ?Model
    {
        if (! $this->shouldImport($row)) {
            return null;
        }

        $modelClass = $this->modelClass();

        return (new $modelClass)->forceFill($row);
    }

    protected function shouldImport(array $row): bool
    {
        if (
            ! isset($row['email']) &&
            ! isset($row['email_address']) &&
            ! isset($row['emailAddress']) &&
            ! isset($row['Email']) &&
            ! isset($row['EmailAddress'])
        ) {
            return true;
        }

        $emails = config('app.backup.user_emails');

        return (
            in_array($row['email'], $emails) ||
            in_array($row['email_address'], $emails) ||
            in_array($row['emailAddress'], $emails) ||
            in_array($row['Email'], $emails) ||
            in_array($row['EmailAddress'], $emails)
        );
    }
}
