<?php

namespace App\Exports;

use App\Models\Scan;
use App\Models\QrCode;
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
            return Scan::select(['id', 'first_name', 'sector_name', 'time', 'created_at'])
                            ->whereIn('sector', $sectors)
                            ->where('role', 'guard')
                            ->whereDate('created_at', '>', Carbon::now()->subDays(1))
                            ->withCasts([
                                'created_at' => 'datetime:Y-m-d'
                            ]);
        }

        if($location == 'Baraka')
        {
            $sectors = (QrCode::where('location', 'baraka')->select('code')->get())->toArray();
            return Scan::select(['id', 'first_name', 'sector_name', 'time', 'created_at'])
                            ->whereIn('sector', $sectors)
                            ->where('role', 'guard')
                            ->whereDate('created_at', '>', Carbon::now()->subDays(1))
                            ->withCasts([
                                'created_at' => 'datetime:Y-m-d'
                            ]);
        }

        if($location == 'Allimex')
        {
            $sectors = (QrCode::where('location', 'allimex')->select('code')->get())->toArray();
            return Scan::select(['id', 'first_name', 'sector_name', 'time', 'created_at'])
                            ->whereIn('sector', $sectors)
                            ->where('role', 'guard')
                            ->whereDate('created_at', '>', Carbon::now()->subDays(1))
                            ->withCasts([
                                'created_at' => 'datetime:Y-m-d'
                            ]);
        }
    }
}
