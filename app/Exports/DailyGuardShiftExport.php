<?php

namespace App\Exports;

use App\Models\Scan;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Carbon\Carbon;

class DailyGuardShiftExport implements FromQuery
{
    use Exportable;

    public function __construct(string $location)
    {
        $this->location = $location;
    }

    public function query()
    {
        $langata = 'TCS000';
        $baraka = 'TCS00';
        $allimex = 'ALP';

        $location = $this->location;

        if($location == "Lang'ata")
        {
            return Scan::query()->where('sector', 'LIKE', "%{$langata}%")
                            ->where('role', 'guard')
                            ->whereDate('created_at', '>', Carbon::now()->subDays(1));
        }

        if($location == 'Baraka')
        {
            return Scan::query()->where('sector', 'LIKE', "%{$baraka}%")
                            ->where('role', 'guard')
                            ->whereDate('created_at', '>', Carbon::now()->subDays(1));
        }

        if($location == 'Allimex')
        {
            return Scan::query()->where('sector', 'LIKE', "%{$allimex}%")
                            ->where('role', 'guard')
                            ->whereDate('created_at', '>', Carbon::now()->subDays(1));
        }
    }
}
