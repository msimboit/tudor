<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Geolocation;
use App\Models\User;
use App\Http\Resources\GeolocationResource;
use Carbon\Carbon;

class GeolocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response = GeolocationResource::collection(Geolocation::all());
        return response($response, 200);
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
            'phone_number' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        $user = User::where('phone_number', $request->phone_number)->first();

        $geolocation = new GeoLocation;
        $geolocation->phone_number = $user->phone_number;
        $geolocation->first_name = $user->firstname;
        $geolocation->latitude = $request->latitude;
        $geolocation->longitude = $request->longitude;
        $geolocation->time = Carbon::now()->format('Y-m-d H:i:s');
        $success = $geolocation->save();

        return (new GeolocationResource($geolocation))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
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
