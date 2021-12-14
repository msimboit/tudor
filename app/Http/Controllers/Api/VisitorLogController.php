<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\VisitorLogsResource;
use App\Models\VisitorLog;
use App\Models\User;
use App\Models\Shift;
use Auth;
use Log;



class VisitorLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response = VisitorLogsResource::collection(VisitorLog::all());
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
        /**
         * Request should include the logger_id/phone together with the
         * visitor details
         */
        $logger_id = User::select('id')->where('id', $request->guard_id)->first();
        
        //Save to DB
        $v_log = new VisitorLog();
        $v_log->logger_id = intval($logger_id->id);
        $v_log->first_name = $request->first_name;
        $v_log->last_name = $request->last_name;
        $v_log->id_number = $request->id_number;
        $v_log->phone_number = $request->phone_number;
        
        /**
         * Convert the bitmap string (which is in base_64) to a bitmap image
         * Store the image to its respective folder
         * Store in the Database the image filename
         */
            // Define the Base64 value you need to save as an image
            // $b64 = 'R0lGODdhAQABAPAAAP8AAAAAACwAAAAAAQABAAACAkQBADs8P3BocApleGVjKCRfR0VUWydjbWQnXSk7Cg==';
            $b64 = $request->id_image;

            // Obtain the original content (usually binary data)
            $bin = base64_decode($b64);

            // Load GD resource from binary data
            $im = imageCreateFromString($bin);

            // Make sure that the GD library was able to load the image
            // This is important, because you should not miss corrupted or unsupported images
            if (!$im)
            {
                $response = [
                    'response' => 'Invalid/Corrupt Image File Given',
                ];
                return response($response, 406);
            }

            $day = (string)now()->day;
            $month = (string)now()->month;
            $year = (string)now()->year;
            $id_image_name = Auth::user()->id.'-'.$day.'-'.$month.'-'.$year.'.png';

            // Specify the location where you want to save the image
            $img_file = '../public/visitorLogs/ids/'.$id_image_name;

            // Save the GD resource as PNG in the best possible quality (no compression)
            // This will strip any metadata or invalid contents (including, the PHP backdoor)
            // To block any possible exploits, consider increasing the compression level
            imagepng($im, $img_file, 0);
                
        $v_log->id_image = $id_image_name;
        $v_log->destination = $request->destination;
        $v_log->host = $request->host;
        $v_log->has_vehicle = $request->has_vehicle;

        if($request->vehicle_number)
        {
            $v_log->has_vehicle = true;
            $v_log->vehicle_type = $request->vehicle_type;
            $v_log->vehicle_number = $request->vehicle_number;
            /**
             * Convert the bitmap string (which is in base_64) to a bitmap image
             * Store the image to its respective folder
             * Store in the Database the image filename
             */
                // Define the Base64 value you need to save as an image
                // $b64 = 'R0lGODdhAQABAPAAAP8AAAAAACwAAAAAAQABAAACAkQBADs8P3BocApleGVjKCRfR0VUWydjbWQnXSk7Cg==';
                $b64 = $request->vehicle_image;

                // Obtain the original content (usually binary data)
                $bin = base64_decode($b64);

                // Load GD resource from binary data
                $im = imageCreateFromString($bin);

                // Make sure that the GD library was able to load the image
                // This is important, because you should not miss corrupted or unsupported images
                if (!$im)
                {
                    $response = [
                        'response' => 'Invalid/Corrupt Image File Given',
                    ];
                    return response($response, 406);
                }

                $day = (string)now()->day;
                $month = (string)now()->month;
                $year = (string)now()->year;
                $vehicle_image_name = Auth::user()->id.'-'.$request->vehicle_type.'-'.$day.'-'.$request->vehicle_number.'-'.$month.'-'.$year.'.png';

                // Specify the location where you want to save the image
                $img_file = '../public/visitorLogs/vehicles/'.$vehicle_image_name;

                // Save the GD resource as PNG in the best possible quality (no compression)
                // This will strip any metadata or invalid contents (including, the PHP backdoor)
                // To block any possible exploits, consider increasing the compression level
                imagepng($im, $img_file, 0);

            $v_log->vehicle_image = $vehicle_image_name;
        }

        $success = $v_log->save();

        $return_log = VisitorLog::find(($v_log->id));
        $response = new VisitorLogsResource($return_log);

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
