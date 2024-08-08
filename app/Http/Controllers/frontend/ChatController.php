<?php

namespace App\Http\Controllers\Frontend;

use App\Events\ChatEvent;
use App\Http\Controllers\Controller;
use App\Models\Chat;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    function sendMessage(Request $request)
    {
        $data = $request->validate([
            'message' => 'required', 'max:1000',
            'receiver_id' => 'required', 'integer'
        ]);
        Chat::create(
            [
                'message' => $data['message'],
                'receiver_id' => $data['receiver_id'],
                'sender_id' => auth()->user()->id,
            ]
        );
        $avatar = asset(auth()->user()->avatar);
        $sender_id = auth()->user()->id;
        broadcast(new ChatEvent($request->message, $request->receiver_id, $avatar, $sender_id))->toOthers();
        return response(['msg_id' => $request->msg_temp_id, 'status' => 'success']);
    }
    function getConversation(string $senderId)
    {
        $receiverId = auth()->user()->id;
        Chat::where('sender_id', $senderId)->where('receiver_id', $receiverId)->where('seen', 0)->update(['seen' => 1]);
        $messages = Chat::whereIn('sender_id' , [$receiverId, $senderId])
            ->whereIn('receiver_id', [$senderId, $receiverId])
            ->with(['sender', 'receiver'])
            ->orderBy('created_at', 'asc')
            ->get();
        return response($messages);
    }
}
