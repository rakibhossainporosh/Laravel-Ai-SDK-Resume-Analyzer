<?php

namespace App\Providers;

use App\Contracts\DocumentParserInterface;
use App\Contracts\ResumeAnalyzerInterface;
use App\Services\AiResumeAnalyzerService;
use App\Services\PdfParserService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(DocumentParserInterface::class, PdfParserService::class);
        $this->app->bind(ResumeAnalyzerInterface::class, AiResumeAnalyzerService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
