<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Issue;
use App\Models\User;
use App\Models\Shift;
use App\Models\QrCode;
use Auth;

class IssueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $issues = Issue::where('cleared', 0)->get();

        return view('issues.index', ['issues' => $issues]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sectors = QrCode::all();
        
        return view('issues.create', ['sectors' => $sectors]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $issue = new Issue;
        $issue->guard_id = $user->id_number;
        $issue->guard_name = $user->firstname;
        $issue->title = $request->title;
        $issue->issueLocation = $request->issueLocation;
        $issue->details = $request->details;
        $success = $issue->save();

        return view('patrol')->with('success', 'Issue Reported Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $issue = Issue::where('id', $id)
                ->first();

        return view('issues.show', ['issue' => $issue]);
    }

    /**
     * Clear the issue.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function clearIssue($id)
    {
        $issue = Issue::where('id', $id)
                ->update([
                    'cleared' => '1'                                                                 
                ]);
                
        return redirect()->route('all_issues')->with('status', 'Issue Cleared');
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
