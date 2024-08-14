<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Message;
use Illuminate\Http\Request;
use Str;

class MessageController extends Controller
{
    private $AIChatController;

    public function __construct()
    {
        $this->AIChatController = new OpenAIController();
    }

    public function create(Request $request) 
    {
        $request->validate([
            'chat_id' => 'required',
            'message' => 'required',
        ]);


        $chat = Chat::with('assistants')->find($request->chat_id)->first();

        if (!$chat) {
            return response()->json([
                'status' => 'error',
                'message' => 'Chat Not Found',
                'data' => null
            ], 404);
        }

        $message = new Message();
        $message->id = Str::uuid()->toString();
        $message->chat_id = $request->chat_id;
        $message->message = $request->message;
        $message->sender = auth()->user()->id;

        $message->save();

        $answer = $this->AIChatController->recommendation($request->message);

        $message_answer = new Message();
        $message_answer->id = Str::uuid()->toString();
        $message_answer->chat_id = $request->chat_id;
        $message_answer->message = $answer;
        $message_answer->sender = $chat->assistants()->first()->id;

        $message_answer->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Message Created',
            'data' => [
                'message' => $message,
                'answer' => $message_answer
            ]
        ], 201);
    }

    public function list(Request $request)
    {
        $messages = Message::where('chat_id', $request->chat_id)->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Messages Retrieved',
            'data' => $messages
        ], 200);
    }

    public function delete($id)
    {
        $message = Message::find($id);

        if (!$message) {
            return response()->json([
                'status' => 'error',
                'message' => 'Message Not Found',
                'data' => null
            ], 404);
        }

        $message->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Message Deleted',
            'data' => $message
        ], 200);
    }
}
