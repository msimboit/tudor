<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Issue;
use App\Models\User;
use App\Models\Scan;
use App\Http\Resources\IssuesResource;
use App\Http\Resources\MarkersResource;
use Carbon\Carbon;
use DateTime;
use DB;

class IssuesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response = IssuesResource::collection(Issue::all());
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
            'title' => 'required|string',
            'issueLocation' => 'required|string',
            'details' => 'required|string',
        ]);

        $user = User::where('phone_number', $request->phone_number)->first();

        $issue = new Issue;
        $issue->phone_number = $user->phone_number;
        $issue->first_name = $user->firstname;
        $issue->title = $request->title;
        $issue->issueLocation = $request->issueLocation;
        $issue->details = $request->details;
        $success = $issue->save();

        $response = new IssuesResource($issue);

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
        $issue = Issue::find($id);

        if($issue === null || $issue === ''){
            return response( ['message' => 'Not Found'], 401);
        }

        $response = new IssuesResource($issue);

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
        $issue = Issue::find($id);
        $issue->cleared = 1;
        $issue->save();
        $response = new IssuesResource($issue);

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

    /**
     * Keep alert for panic buttons pressed.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function panicAlert()
    {
        $response = IssuesResource::collection(Issue::where('title', 'Panic Button Pressed')->where('cleared', 0)->get());
        return response($response, 200);
    }

    /**
    * Send the daily guard markers during that day
    * 
    * @return \Illuminate\Http\Response
    */
   public function guardMarkers()
   {
        $current_time = Carbon::now(); 
        $response = MarkersResource::collection(Scan::where('created_at', '>', $current_time->subHours(24))->where('role', 'guard')->get());
        return response($response, 200);
   }
}
