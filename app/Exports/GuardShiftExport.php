<?php

namespace App\Exports;

use App\Models\Shift;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Carbon\Carbon;

class GuardShiftExport implements FromQuery
{
    use Exportable;

    public function __construct(string $role)
    {
        $this->role = $role;
    }

    public function query()
    {
        return Shift::query()->where('role', $this->role)
                            ->whereDate('created_at', '>', Carbon::now()->subDays(30));
    }
}
