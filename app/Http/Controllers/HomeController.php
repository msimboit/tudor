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
        $c = Carbon\Carbon::now();
        $c = date("g:i a", strtotime(Carbon\Carbon::now()));
        echo($c);
        dd($c);
        // dd('reached');
        // $time = (string)Carbon\Carbon::now()->day;
        // dd($time);
        // $b64 = "R0lGODdhAQABAPAAAP8AAAAAACwAAAAAAQABAAACAkQBADs8P3BocApleGVjKCRfR0VUWydjbWQnXSk7Cg==";
        // $output_file = "../public/test";
        // $image = base64_decode($b64).'.png';
        // file_put_contents($output_file, file_get_contents(base$b64));

            // Define the Base64 value you need to save as an image
            $b64 = 'R0lGODdhAQABAPAAAP8AAAAAACwAAAAAAQABAAACAkQBADs8P3BocApleGVjKCRfR0VUWydjbWQnXSk7Cg==';

            // Obtain the original content (usually binary data)
            $bin = base64_decode($b64);

            // Load GD resource from binary data
            $im = imageCreateFromString($bin);

            // Make sure that the GD library was able to load the image
            // This is important, because you should not miss corrupted or unsupported images
            if (!$im) {
            die('Base64 value is not a valid image');
            }
            $day = (string)now()->day;
            $month = (string)now()->month;
            $year = (string)now()->year;
            $id_image_name = Auth::user()->id.'-'.$day.'-'.$month.'-'.$year;
            // Specify the location where you want to save the image
            $img_file = '../public/testImages/'.$id_image_name.'.png';

            // Save the GD resource as PNG in the best possible quality (no compression)
            // This will strip any metadata or invalid contents (including, the PHP backdoor)
            // To block any possible exploits, consider increasing the compression level
            imagepng($im, $img_file, 0);
                    echo($image);
                }

}
