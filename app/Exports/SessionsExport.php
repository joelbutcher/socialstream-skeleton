<?php

namespace App\Exports;

use App\Models\User;
use App\Services\Database\Exporter;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class SessionsExport extends Exporter
{
    public function collection(): Collection
    {
        return $this->users()->map(
            fn (User $user) => DB::table('sessions')->where('user_id', $user->id)->get(),
        )->flatten()->unique('id');
    }
}
