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

        $unreadIds = Message::select(\DB::raw('`from` as sender_id, count(`from`) as messages_count'))
            ->where('to', auth()->id())
            ->where('read', false)
            ->groupBy('from')
            ->get(); 
            // select from as sender_id, count('from') as message_count where to=1 and read=false group by 'from'
        $contacts = $contacts->map(function($contact) use ($unreadIds) {
            $contactUnread = $unreadIds->where('sender_id', $contact->id)->first();
            
            $contact->unread = $contactUnread ? $contactUnread->messages_count : 0;
            return $contact;
        });
        return response()->json($contacts);

    }

    public function getMessagesFor($id) {
        Message::where('from', $id)->where('to', auth()->id())->update(['read' => true]);

        $messages = Message::where(function($q) use ($id) {
            $q->where('from', auth()->id());
            $q->where('to', $id);
        })->orWhere(function($q) use ($id) {
            $q->where('from', $id);
            $q->where('to', auth()->id());
        })->get(); // select * from message where (from = 1 and to = 2) or (from = 2 and to = 1)
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
