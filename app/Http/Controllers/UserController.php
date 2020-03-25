<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Message;

class UserController extends Controller
{
    public function get()
    {
        $response = User::all();
        return response()->json($response);
    }

    public function getMessagesFor($id){
        $messages = Message::where('from', $id)->orWhere('to', $id)->get();
        dd($messages);

        return response()->json($messages);
    }
}
