<?php

namespace App\Exports;

use App\Models\Scan;
use App\Models\QrCode;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Carbon\Carbon;

class SpecificGuardShiftExport implements FromQuery
{
    use Exportable;

    public function __construct(string $location, string $from, string $to)
    {
        $this->location = $location;
        $this->from = $from;
        $this->to = $to;
    }

    public function query()
    {
        $langata = 'TCS000';
        $baraka = 'TCS00';
        $allimex = 'ALP';

        $location = $this->location;
        $from = $this->from;
        $to = $this->to;

        if($location == "Lang'ata")
        {
            $sectors = (QrCode::where('location', 'langata')->select('code')->get())->toArray();
            return Scan::query()->whereIn('sector', $sectors)
                            ->where('role', 'guard')
                            ->whereBetween('created_at', [$from, $to]);
        }

        if($location == 'Baraka')
        {
            $sectors = (QrCode::where('location', 'baraka')->select('code')->get())->toArray();
            return Scan::query()->where('sector', $sectors)
                            ->where('role', 'guard')
                            ->whereBetween('created_at', [$from, $to]);
        }

        if($location == 'Allimex')
        {
            $sectors = (QrCode::where('location', 'allimex')->select('code')->get())->toArray();
            return Scan::query()->where('sector', $sectors)
                            ->where('role', 'guard')
                            ->whereBetween('created_at', [$from, $to]);
        }
    }
}
