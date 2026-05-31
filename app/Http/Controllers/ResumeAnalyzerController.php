<?php

namespace App\Http\Controllers;

use App\Contracts\DocumentParserInterface;
use App\Contracts\ResumeAnalyzerInterface;
use App\Http\Requests\ResumeAnalyzerRequest;

class ResumeAnalyzerController extends Controller
{
    public function __construct(
        private DocumentParserInterface $documentParser,
        private ResumeAnalyzerInterface $resumeAnalyzer
    ){}
    public function index()
    {
        return view ('resume.index');
    }

    public function analyze(ResumeAnalyzerRequest $request){
        $resumeText = $this->documentParser->extractText($request->file('resume'));

        if(strlen($resumeText)<100){
            return back()->withErrors([
                'resume' => 'Could not extract enough text from this PDF. It may be scanned or image-based.',
            ]);
        }

        $analysis = $this->resumeAnalyzer->analyze(
            $resumeText,
            $request->validated('job_description')
        );

        return view('resume.result', [
            'analysis' => $analysis
        ]);
    }
}
