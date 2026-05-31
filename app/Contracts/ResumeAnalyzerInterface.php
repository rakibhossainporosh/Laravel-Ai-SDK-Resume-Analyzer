<?php

namespace App\Contracts;

interface ResumeAnalyzerInterface
{
    public function analyze(string $resumeText, ?string $jobDescription);
}
