<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Scan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use DateTime;


class HomeController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user()->phone_number;
        $current_time = Carbon\Carbon::now();

        $roles = ['guard', 'management', 'operations', 'control', 'production'];

        if(in_array( (Auth::user()->role), $roles ))
        {

            $last_clock_in = DB::table('scans')
            ->select('created_at')
            ->where('phone_number', '=', $user)
            ->where('sector_name', '=', 'Clocking In')
            ->orderBy('created_at', 'desc')
            ->first();
        
                if($last_clock_in == null){
                    return view('home', ['current_time' => $current_time->toDateString()]);
                }
                else {

                    $date = new DateTime($last_clock_in->created_at);
                    $now = new DateTime();

                    $diff = $date->diff($now)->format("%d days, %h hours and %i minutes");

                    $last_scan = DB::table('scans')
                        ->select('sector_name')
                        ->where('phone_number', '=', $user)
                        ->orderBy('created_at', 'desc')
                        ->first();
                    
                    // dd($last_scan);
                    if($diff < "0 days, 12 hours and 0 minutes" && $last_scan != 'Clocking Out' && Auth::user()->role == 'guard') {
                        return redirect()->route('patrol');
                    }

                    if($diff < "0 days, 12 hours and 0 minutes" && $last_scan != 'Clocking Out' && Auth::user()->role != 'guard') {
                        return redirect()->route('patrol');
                    }

                    return view('home', ['current_time' => $current_time->toDateString()]);
                }
        }

        return redirect()->route('guards');
    }

    /**
     * Register a User.
     *
     * @return \Illuminate\Http\Response
     */
    public function registerUser()
    {

        return view ('registerUser');
    }

    /**
     * Register a Client.
     *
     * @return \Illuminate\Http\Response
     */
    public function registerClient()
    {
        return view ('registerClient');
    }

    public function confirmClientRegistration(Request $request)
    {
        // dd($request->all());
        
        $current_time = Carbon\Carbon::now();
        User::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'role' => 'client',
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('clients');
    }

    public function confirmRegistration(Request $request)
    {
        // dd($request->all());
        
        $current_time = Carbon\Carbon::now();
        User::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('employees');
    }
    
    /**
     * Change the user password.
     *
     * @return \Illuminate\Http\Response
     */
    public function changePassword()
    {
        $user = Auth::user();
        return view('changePassword', [ 'user' => $user ]);
    }

    /**
     * Store the users new password.
     *
     * @params \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function passwordChanged(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'oldPassword' => 'required|max:255',
            'newPassword' => 'required',
        ]);

        if (Hash::check($request->oldPassword, $request->userOldPassword)) 
        {
            $registeredUser = User::find($request->user);

            $registeredUser->password = Hash::make($request->newPassword);

            $registeredUser->save();

            return redirect()->route('home')->with('success', 'Password change was successful!');;

        }else {
            return \Redirect::back()->withWarning( 'Old Password does not match!' );
        }

    }

    /**
     * Edit the user profile.
     *
     * @return \Illuminate\Http\Response
     */
    public function editUser($id)
    {
        $user = User::findOrFail($id);

        return view('edituser', [ 'user' => $user ]);
    }

    /**
     * Update the users profile.
     *
     * @params \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateUser(Request $request, $id)
    {
        User::where('id', $id)
            ->update([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('guards')->with('status', 'User profile updated successfully!');

    }

    /**
     * Admin logout from all other devices.
     *
     * @params \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function adminLogout($password)
    {
        Auth::logoutOtherDevices($password);

        return redirect()->route('guards')->with('status', 'All login sessions have been logged out!');

    }

    public function test()
    {
        $start = Carbon\Carbon::now()->subMinutes(15);
        $now = Carbon\Carbon::now();
        $shift = Scan::where('sector', 'TCS000201')->whereBetween('created_at', [$now, $start])->get();
        // dd($shift->isEmpty());
        $shift = count(Scan::where('location', 'langata')->get());
        dd($shift);
    }

}
