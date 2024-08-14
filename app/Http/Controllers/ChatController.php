<?php

namespace App\Http\Controllers;

use App\Models\Assistant;
use App\Models\Chat;
use Illuminate\Http\Request;
use Str;

class ChatController extends Controller
{
    public function create(Request $request) 
    {
        $request->validate([
            'topic' => 'required',  
            'assistant_id' => 'required',
        ]);

        $checkAssistant = Assistant::where('id', $request->assistant_id)->first();
        $checkChat = Chat::where('assistant_id', $request->assistant_id)->where('user_id', auth()->user()->id)->first();

        if ($checkChat) {
            return response()->json([
                'status' => 'success',
                'message' => 'Chat Already Exists',
                'data' => null
            ], 200);
        }

        if (!$checkAssistant) {
            return response()->json([
                'status' => 'error',
                'message' => 'Assistant Not Found',
                'data' => null
            ], 404);
        }

        $chat_id = Str::uuid()->toString();

        $chat = new Chat();
        $chat->id = $chat_id;
        $chat->topic = $request->topic;
        $chat->assistant_id = $request->assistant_id;
        $chat->user_id = auth()->user()->id;

        $chat->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Chat Created',
            'data' => $chat
        ], 201);
    }

    public function list(Request $request)
    {
        $chats = Chat::where('user_id', auth()->user()->id)->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Chats Retrieved',
            'data' => $chats
        ], 200);
    }

    public function delete($id)
    {
        $chat = Chat::find($id);

        if (!$chat) {
            return response()->json([
                'status' => 'error',
                'message' => 'Chat Not Found',
                'data' => null
            ], 404);
        }

        $chat->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Chat Deleted',
            'data' => $chat
        ], 200);
    }

    public function get($id)
    {
        $chat = Chat::with([
            'messages' => function ($query) {
                $query->orderBy('created_at', 'asc'); 
            },
            'assistants'
        ])->find($id);

        if (!$chat) {
            return response()->json([
                'status' => 'error',
                'message' => 'Chat Not Found',
                'data' => null
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Chat Retrieved',
            'data' => $chat
        ], 200);
    }
    
}
