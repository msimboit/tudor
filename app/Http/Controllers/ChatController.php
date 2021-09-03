<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Chat;
use App\Http\Resources\ChatsResource;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response = ChatsResource::collection(Chat::all());
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
        // print_r($request->all());
        // $sender = User::where('email', $request->sender_email)->first();
        // $receiver = User::where('email', $request->receiver_email)->first();

        // $chat = new Chat;
        // $chat->sender_email = $request->sender_email;
        // $chat->receiver_email = $request->receiver_email;
        // $chat->message = $request->message;
        // $success = $chat->save();

        $chat = Chat::create([
            'sender_email' => $request->sender_email,
            'receiver_email' => $request->sender_email,
            'message' => $request->message,
        ]);

        $response = new ChatsResource($chat);

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
        $chat = Chat::find($id);

        if($chat === null || $chat === ''){
            return response( ['message' => 'Not Found'], 401);
        }

        $response = new ChatsResource($chat);

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
