<?php

use App\Http\Controllers\ResumeAnalyzerController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ResumeAnalyzerController::class, 'index'])->name('resume.index');

Route::post('/resume-analyzer', [ResumeAnalyzerController::class, 'analyze'])->name('analyze.resume');
