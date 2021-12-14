<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Scan;
use App\Models\User;
use App\Models\QrCode;
use App\Models\Shift;
use App\Http\Resources\ScannersResource;
use Carbon\Carbon;
use DateTime;
use DB;
use Log;

class ScannersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ScannersResource::collection(Scan::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
            'phone_number' => 'required|string',
            'latitude' => 'required|string',
            'longitude' => 'required|string',
            'sector' => 'required|string',
        ]);

        Log::info($request->all());
        $user = User::where('phone_number', $request->phone_number)->first();

        $sector_name = QrCode::where('code', $request->sector)->select('name')->first();

        $last_clock_in = DB::table('scans')
        ->select('created_at')
        ->where('phone_number', '=', $user->phone_number)
        ->where('sector_name', '=', 'Clocking In')
        ->orderBy('created_at', 'desc')
        ->first();

        $actual_scan_time = Carbon::now();
        $diff = (Carbon::parse($last_clock_in->created_at))->diffInHours($actual_scan_time);
        Log::info($diff);
        Log::info('  ');
        $confirm = ($request->sector == 'TCS000201') || ($request->sector == 'TCS00101');
        Log::info($confirm);
        if($diff > 12 && ( ($request->sector != 'TCS000201') || ($request->sector != 'TCS00101') )){
            $response = [
                'message' => 'Clock In First',
            ];
            return response($response, 404);
        }

        $last_scanned_site = DB::table('scans')
            ->where('phone_number', '=', $user->phone_number)
            ->orderBy('created_at', 'desc')
            ->first();

        if($last_clock_in == null)
        {
            $time = Carbon::now();
            $current_time = date("g:i a", strtotime($time));

            $location = (QrCode::where('code', $request->sector)->select('location')->first())->toArray();

            $scan= new Scan;
            $scan->phone_number = $user->phone_number;
            $scan->first_name = $user->firstname;
            $scan->latitude = $request->latitude;
            $scan->longitude = $request->longitude;
            $scan->sector = $request->sector;
            $scan->sector_name = $sector_name->name;
            $scan->time = $current_time;
            $scan->location = $location['location'];
            $scan->role = $user->role;
            $success = $scan->save();

            $shift = new Shift;
            $shift->phone_number = $user->phone_number;
            $shift->first_name = $user->firstname;
            $shift->last_name = $user->lastname;
            $shift->role = $user->role;
            $shift->clockin = $scan->created_at;
            $success2 = $shift->save();
            
            if($user->role === 'guard')
            {
                $response = [
                    'phone_number' => $user->phone_number,
                    'first_name' => $user->firstname,
                    'latitude' => $scan->latitude,
                    'longitude' => $scan->longitude,
                    'sector' => $scan->sector,
                    'sector_name' => $scan->sector_name
                ];

                $response_array = collect($response);
                $response = [
                    'response' => $response_array,
                ];
                return response($response, 200);
            }

            
            $response = [
                'phone_number' => $user->phone_number,
                'first_name' => $user->firstname,
                'latitude' => $scan->latitude,
                'longitude' => $scan->longitude,
                'sector' => $scan->sector,
                'sector_name' => $scan->sector_name
            ];

            $response_array = collect($response);
            $response = [
                'response' => $response_array,
            ];
            return response($response, 200);
        }

        $date = new DateTime($last_clock_in->created_at);
        $now = new DateTime();
        
        $diff = $date->diff($now)->format("%d days, %h hours and %i minutes");

        $current_time = Carbon::now();

        $location = (QrCode::where('code', $request->sector)->select('location')->first())->toArray();

        $scan= new Scan;
        $scan->phone_number = $user->phone_number;
        $scan->first_name = $user->firstname;
        $scan->latitude = $request->latitude;
        $scan->longitude = $request->longitude;
        $scan->sector = $request->sector;
        $scan->sector_name = $sector_name->name;
        $scan->time = date("g:i a", strtotime($current_time));
        $scan->role = $user->role;
        $scan->location = $location['location'];
        $success = $scan->save();

        if($scan->sector_name == 'Clocking Out') {
            $in = new DateTime($last_clock_in->created_at);
            $out = new DateTime($scan->created_at);
            $duration = $out->diff($in)->format("%d days, %h hours and %i minutes");

            $shift = DB::table('shifts')
                    ->where('phone_number', ($user->phone_number))
                    ->where('clockin', ($last_clock_in->created_at))
                    ->update([
                        'clockout' => $scan->created_at,
                        'shift_duration' => $duration
                        ]);
        }


        if($scan->sector_name == 'Clocking In' && $last_scanned_site->sector_name != 'Clocking Out' ) {
            $in = new DateTime($last_clock_in->created_at);
            $out = new DateTime($scan->created_at);
            $duration = $out->diff($in)->format("%d days, %h hours and %i minutes");

            $shift = DB::table('shifts')
                    ->where('phone_number', ($user->phone_number))
                    ->where('clockin', ($last_clock_in->created_at))
                    ->update([
                        'clockout' => $scan->created_at,
                        'shift_duration' => $duration
                        ]);

            $shift = new Shift;
            $shift->phone_number = $user->phone_number;
            $shift->first_name = $user->firstname;
            $shift->last_name = $user->lastname;
            $shift->role = $user->role;
            $shift->clockin = $scan->created_at;
            $success2 = $shift->save();
        }

        $response = [
            'phone_number' => $user->phone_number,
            'first_name' => $user->firstname,
            'latitude' => $scan->latitude,
            'longitude' => $scan->longitude,
            'sector' => $scan->sector,
            'sector_name' => $scan->sector_name
        ];

        $response_array = collect($response);
        $response = [
            'response' => $response_array,
        ];
        return response($response, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
