<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Leave;
use App\Models\User;
use App\Http\Resources\LeavesResource;
use Carbon\Carbon;
use DateTime;
use DB;

class LeavesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response = LeavesResource::collection(Leave::all());
        return response($response, 200);
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
            'phone_number' => 'required',
            'email' => 'required|string',
            'leaveIssue' => 'required|string',
        ]);

        $user = User::where('phone_number', $request->phone_number)->first();
        // print_r($user);
        $leave = new Leave;
        $leave->phone_number = $user->phone_number;
        $leave->email = $user->email;
        $leave->first_name = $user->firstname;
        $leave->leaveIssue = $request->leaveIssue;
        $leave->approved = 0;
        $leave->cleared = 0;
        $success = $leave->save();

        $response = new LeavesResource($leave);

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
        $leave = Leave::find($id);

        if($leave === null || $leave === '')
        {
            return response( ['message' => 'Not Found'], 401);
        }

        $response = new LeavesResource($leave);

        return response($response, 200);
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
        $leave = Leave::find($id);
        $leave->approved = 1;
        $leave->save();
        $response = new LeavesResource($leave);

        return response($response, 200);
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
