<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class QuizController extends Controller
{
    public function generateQuiz(Request $request)
    {
        $validated = $request->validate([
            'kategori' => 'required|string',
            'jumlah' => 'required|integer',
            'kesulitan' => 'required|string',
            'level' => 'required|string',
        ]);

        $prompt = "
        Anda adalah seorang pembuat soal ujian yang ahli, tugas Anda adalah membuat soal pilihan ganda dengan tema {$validated['kategori']}.
        Buatlah soal pilihan ganda untuk siswa dengan tingkat {$validated['level']} dan kesulitan {$validated['kesulitan']}.
        Pastikan soal-soalnya unik, dalam bentuk teks, dan diformat seperti berikut (tanpa JSON atau format lain):
        Setiap soal harus tampak seperti ini:

        1. Teks soal
           A) Pilihan A
           B) Pilihan B
           C) Pilihan C
           D) Pilihan D
           Jawaban Benar: Pilihan yang benar

        Ulangi format ini sebanyak {$validated['jumlah']} soal.
        ";

        $url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=AIzaSyC4Ew99f-OgsYGekqg4OjYIgF8MF_H5cL8';
        $data = [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $prompt]
                    ]
                ]
            ]
        ];
        
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
        ]);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            return response()->json([
                'error' => 'cURL Error: ' . curl_error($ch)
            ], 500);
        }

        curl_close($ch);

        $responseData = json_decode($response, true);

        $quizContent = $responseData['candidates'][0]['content']['parts'][0]['text'];

        return response()->json([
            'quizContent' => $quizContent
        ]);
    }
}
