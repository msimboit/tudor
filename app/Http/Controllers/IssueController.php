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

        $request->validate([
            'title' => 'required|max:255',
            'issueLocation' => 'required',
            'details' => 'required',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048'
        ]);

        // dd($request->all());
        $newImageName = 'None';
        if($request->image != null || $request->image != ''){
            $image = $request->image;
            $newImageName = time() . '-' . $request->title . '-' . $request->issueLocation . '.' . $image->extension();
            $image->move(public_path('issues_images'), $newImageName);
        }

        $issue = new Issue;
        $issue->phone_number = $user->phone_number;
        $issue->first_name = $user->firstname;
        $issue->title = $request->title;
        $issue->issueLocation = $request->issueLocation;
        $issue->details = $request->details;

        $issue->image = $newImageName;
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

    /**
     * Panic Button has been clicked.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function panic(Request $request)
    {
        // dd($request->all());

        $user = User::where('id', $request->guard_id)->first();

        $issue = new Issue;
        $issue->phone_number = $user->phone_number;
        $issue->first_name = $user->firstname;
        $issue->title = 'Panic Button Pressed';
        $issue->issueLocation = $request->latitude.' - '.$request->longitude;
        $issue->details = 'Panic Button has been pressed. Help Required!!!';
        $success = $issue->save();

        return redirect()->back()->with('success', 'Help is on the way');
    }
}
