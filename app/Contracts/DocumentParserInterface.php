<?php

namespace App\Contracts;

use Illuminate\Http\UploadedFile;

interface DocumentParserInterface
{
    public function extractText(UploadedFile $file): string;
}
