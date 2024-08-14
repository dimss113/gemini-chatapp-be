<?php

namespace App\Http\Controllers;

use App\Models\Assistant;
use Illuminate\Http\Request;

use Str;

class AssistantController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'title' => 'required',
        ]);

        $assistant_id = Str::uuid()->toString();

        $assistant = new Assistant();
        $assistant->id = $assistant_id;
        $assistant->name = $request->name;
        $assistant->title = $request->title;
        $assistant->user_id = auth()->user()->id;

        $assistant->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Assistant Created',
            'data' => $assistant
        ], 201);
    }

    public function list(Request $request)
    {
        $assistants = Assistant::where('user_id', auth()->user()->id)->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Assistants Retrieved',
            'data' => $assistants
        ], 200);
    }

    public function delete($id)
    {
        $assistant = Assistant::find($id);

        if (!$assistant) {
            return response()->json([
                'status' => 'error',
                'message' => 'Assistant Not Found',
                'data' => null
            ], 404);
        }

        $assistant->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Assistant Deleted',
            'data' => $assistant
        ], 200);
    }
    
}
