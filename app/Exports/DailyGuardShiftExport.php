<?php

namespace App\Exports;

use App\Models\Scan;
use App\Models\Qrcode;
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
            $sectors = (QrCode::where('location', 'langata')->select('code')->get())->toArray();
            return Scan::query()->whereIn('sector', $sectors)
                            ->where('role', 'guard')
                            ->whereDate('created_at', '>', Carbon::now()->subDays(1));
        }

        if($location == 'Baraka')
        {
            $sectors = (QrCode::where('location', 'baraka')->select('code')->get())->toArray();
            return Scan::query()->where('sector', $sectors)
                            ->where('role', 'guard')
                            ->whereDate('created_at', '>', Carbon::now()->subDays(1));
        }

        if($location == 'Allimex')
        {
            $sectors = (QrCode::where('location', 'allimex')->select('code')->get())->toArray();
            return Scan::query()->where('sector', $sectors)
                            ->where('role', 'guard')
                            ->whereDate('created_at', '>', Carbon::now()->subDays(1));
        }
    }
}
