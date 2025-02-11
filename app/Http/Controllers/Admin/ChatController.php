<?php

namespace App\Http\Controllers\Admin;

use App\Events\ChatEvent;
use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    function index()
    {
        $userId = auth()->user()->id;
//        $chatUsers = User::where('id', '!=', $userId)
//            ->whereHas('chats', function ($query) use ($userId) {
//                $query->where(function ($subQuery) use ($userId) {
//                    $subQuery->where('sender_id', $userId)
//                        ->orWhere('receiver_id', $userId);
//                });
//            })
//            ->orderByDesc('created_at')
//            ->distinct()
//            ->get();
        $senders = Chat::select('sender_id')
            ->where('receiver_id', $userId)
            ->where('sender_id', '!=', $userId)
            ->selectRaw('MAX(created_at) as latest_message_sent')
            ->groupBy('sender_id')
            ->orderByDesc('latest_message_sent')
            ->get();
        return view('admin.chat.index', compact('senders'));
    }

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
