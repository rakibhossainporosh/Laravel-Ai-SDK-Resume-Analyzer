<?php

namespace App\Services;

use App\Contracts\DocumentParserInterface;
use Illuminate\Http\UploadedFile;
use Smalot\PdfParser\Parser;

class PdfParserService implements DocumentParserInterface
{
    public function __construct(private Parser $parser) {}

    public function extractText(UploadedFile $file): string
    {
        $pdf = $this->parser->parseFile($file->getRealPath());
        $text = $this->cleanText($pdf->getText());

        return str($text)->squish()->limit(18000, '')->toString();
    }

    private function cleanText(string $text): string
    {
        $text = str_replace("\0", '', $text);
        $text = mb_convert_encoding($text, 'UTF-8', 'UTF-8');
        $text = iconv('UTF-8', 'UTF-8//IGNORE', $text);
        $text = preg_replace('/[^\P{C}\n\r\t]+/u', '', $text);
        $text = preg_replace("/[ \t]+/", ' ', $text);
        $text = preg_replace("/\n{3,}/", "\n\n", $text);

        return trim($text);
    }
}
