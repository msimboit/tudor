<?php

namespace App\Exports;

use App\Models\Scan;
use App\Models\QrCode;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use PhpOffice\PhpSpreadsheet\Shared\Date;
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

            // $report = Scan::selectRaw(['phone_number', 'first_name', 'sector_name', 'time', 'created_at'])
            //                 ->where('sector', $sectors)
            //                 ->where('role', 'guard')
            //                 ->whereBetween('created_at', [$from, $to])
            //                 ->withCasts([
            //                     'created_at' => 'datetime'
            //                 ]);
            // return $report;

            $report = Scan::select([
                'id', 'first_name', 'sector_name', 'time',
                'created_at'
            ])->withCasts([
                'created_at' => 'datetime:Y-m-d'
            ]);

            return $report;

            // return Scan::query()->where('sector', $sectors)
            //                 ->where('role', 'guard')
            //                 ->whereBetween('created_at', [$from, $to]);
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
