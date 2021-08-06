<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Scan;
use App\Models\Shift;
use App\Models\Issue;
use App\Exports\ShiftsExport;
use Maatwebsite\Excel\Facades\Excel;
use Auth;
use DB;
use Log;
use Carbon\Carbon;


class ShiftController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->role == 'guard')
        {
            return redirect()->route('home');
        }
        $guards = User::where('role', 'guard')
                    ->orderBy('firstname')
                    ->get();

        return view('shifts.shifts', ['guards' => $guards]);
    }

    /**
     * Search for a specific date range of shifts.
     *
     * @return \Illuminate\Http\Response
     */
    public function searchDate(Request $request)
    {   
        // dd($request->all());
        $shifts = Shift::whereBetween('created_at', [$request->get('from'), $request->get('to')])
                        ->orderBy('created_at', 'desc')                
                        ->get();

        //dd($shifts);

        return view('shifts.shiftsSearch', ['shifts' => $shifts]);
    }

    /**
     * Show the specific guard information
     *
     * @return \Illuminate\Http\Response
     */
    public function info($id)
    {
        $guard = User::findOrFail($id);

        $guard_details = Shift::where('guard_id', $guard->id_number)
                        ->orderBy('created_at', 'desc')
                        ->simplePaginate(30);
        
        // echo($guard_details);

        return view('shifts.shiftInfo', ['guard' => $guard], ['guard_details' => $guard_details]);
    }

    /**
     * Display specific guards scanned areas during that shift
     * 
     * @return \Illuminate\Http\Response
     */
    public function all_scanned_areas()
    {
        // dd(Auth::user());
        $user = Auth::user();
        $current_time = Carbon::now();
        
        $scanned_areas = DB::table('scans')
        ->select('sector_name')
        ->where('created_at', '<', $current_time)
        ->orderBy('created_at', 'desc')
        ->get();
        
        return view('shifts.scanned_areas', ['current_time' => $current_time], ['scanned_areas' => $scanned_areas]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Generate An Excel Form.
     */
    public function export() 
    {
        return Excel::download(new ShiftsExport, 'shifts.xlsx');
    }
}
