<?php

namespace App\Http\Controllers;

use Gemini\Data\Content;
use Gemini\Laravel\Facades\Gemini;
use Illuminate\Http\Request;
use OpenAI\Laravel\Facades\OpenAI;

class OpenAIController extends Controller
{
    // create constructor

    public function recommendation($message)
    {
    
        // $result = OpenAI::chat()->create([
        //     'model' => 'gpt-3.5-turbo',
        //     'messages' => [
        //         ['role' => 'system', 'content' => 'You are a helpful assistant.'],
        //         ['role' => 'user', 'content' => 'Give me 5 messages to recommend to the user']
        //     ]
        // ]);

        // $test = OpenAI::completions()->create([
        //     'model' => 'gpt-3.5-turbo',
        //     'prompt' => 'HAI',
        // ]); 

        // $test = [
        //     'Halo! Aku butuh bantuan untuk [topik/spesifik masalah]. Bisa bantu?',
        //     'Hai Hai, aku sedang mencari informasi tentang [topik]. Ada yang bisa kamu beritahu?',
        //     'Hai! Aku menghadapi masalah dengan [teknologi/alat]. Apakah ada solusi atau tips yang bisa kamu berikan?'
        // ];

        $result = Gemini::geminiPro()->generateContent($message);

        return $result->text();
    }

    public function startChat() 
    {
        $result = Gemini::geminiPro()->generateContent('berikan 5 pertanyaan singkat yang bisa diajukan ke gemini dan pisahkan tiap pertanyaan dengan \ serta tidak perlu menggunakan nomor urut');

        $result = explode('\\', $result->text());

        return response()->json([
            'status' => 'success',
            'message' => 'Chat Started',
            'data' => $result
        ], 200);
    }
}
