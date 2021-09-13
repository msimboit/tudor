<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
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

        return redirect()->route('employees', ['current_time' => $current_time->toDateString()]);
    }

    public function registerUser()
    {
        return view ('registerUser');
    }

    public function confirmRegistration(Request $request)
    {
        //dd($request->all());
        User::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        return view('employees.employees');
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
}
