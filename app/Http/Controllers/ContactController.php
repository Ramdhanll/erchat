<?php

namespace App\Http\Controllers;
use App\user;
use App\Message;
use App\Events\newMessage;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function get() {
        $contacts = User::where('id', '!=', auth()->id())->get();

        return response()->json($contacts);
    }

    public function getMessagesFor($id) {
        $messages = Message::where('from',$id)->orWhere('to', $id)->get();

        return response()->json($messages, 200);
    }

    public function send(Request $request) {
        $message = Message::create([
            'from'  => auth()->id(),
            'to'    => $request->contact_id,
            'text'  => $request->text
        ]);
        
        broadcast(new newMessage($message));

        return response()->json($message, 200);
    }
}
