<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Gemini\Laravel\Facades\Gemini;

class GeminiController extends Controller
{
    public function index()
    {
        return view('gemini-chat');
    }

    public function ask(Request $request)
    {
        $request->validate([
            'prompt' => 'required|string',
        ]);

        try {
            // Ubah dari 'gemini-1.5-flash' menjadi 'gemini-2.5-flash'
            // $result = Gemini::generativeModel(model: 'gemini-2.5-flash')->generateContent($request->input('prompt'));
            // Ubah bagian ini di dalam Controller Anda:
            $result = Gemini::generativeModel(model: 'gemini-3.7-flash')->generateContent($request->input('prompt'));
            return response()->json([
                'success' => true,
                'response' => $result->text(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
