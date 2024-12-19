<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuizController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/quiz-form', function () {
    return view('quiz_form'); // Form HTML-nya
});

Route::post('/generate-quiz', [QuizController::class, 'generateQuiz']);
