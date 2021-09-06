<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Chat;
use App\Http\Resources\ChatsResource;
use Auth;
use DB;
use Carbon;

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
        $fields = $request->validate([
            'sender_email' => 'required|string',
            'receiver_email' => 'required|string',
            'message' => 'required|string',
        ]);

        $chat = Chat::create([
            'sender_email' => $request->sender_email,
            'receiver_email' => $request->receiver_email,
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

    /**
     * Display a listing of the resource on the web.
     *
     * @return \Illuminate\Http\Response
     */
    public function chats($id)
    {
        $user = User::find($id);
        $chats = Chat::where('sender_email', $user->email)
                        ->orWhere('receiver_email', $user->email)
                        ->get();

        $all_users = User::get();
        return view('chats.index', compact('user', 'all_users', 'chats'));
    }

    /**
     * Display a listing of the resource on the web.
     *
     * @return \Illuminate\Http\Response
     */
    public function chat($id)
    {
        $user = Auth::user();
        $chatWith = User::where('id', $id)->first();
        $chats = Chat::where('sender_email', $user->email)
                        ->orWhere('receiver_email', $user->email)
                        ->latest()
                        ->limit(5)
                        ->get();

        $chats = $chats->reverse();
        // dd($chatWith);

        return view('chats.create', compact('user', 'chatWith', 'chats'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function chatStore(Request $request)
    {
        $fields = $request->validate([
            'receiver_email' => 'required|string',
            'message' => 'required|string',
        ]);

        $receiver = User::where('email', $request->receiver_email)->first();
        $chat = Chat::create([
            'sender_email' => Auth::user()->email,
            'receiver_email' => $request->receiver_email,
            'message' => $request->message,
        ]);

        $response = new ChatsResource($chat);

        return redirect()->route('chat', $receiver->id)->with('status', 'Message Sent');
    }
}
