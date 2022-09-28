<?php

namespace App\Modules;

use Aws\Textract\TextractClient;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Spatie\PdfToImage\Exceptions\PdfDoesNotExist;
use Spatie\PdfToImage\Pdf;

class ConvertPDFToText
{
    private $tempDir;
    private $pdf;
    private $pdfPath;
    private $pdfName;

    /** @var $pdfImages Collection */
    private $pdfImages = [];
    private $pdfText = [];

    public function __construct(string $pdfPath)
    {
        $this->tempDir = storage_path('app/ocr_pdf_temp');
        $this->pdfPath = $pdfPath;
        $this->pdfName = basename($this->pdfPath, '.pdf');

        if (file_exists($this->tempDir)) {
            $this->removeTempDirectory();
        }

        mkdir($this->tempDir, 0775);
    }

    public function run()
    {
        $this->pdfToImage();
        $this->imageToText();
        $this->removeTempDirectory();

        return $this->pdfText;
    }

    private function pdfToImage()
    {
        try {
            $this->pdf = new Pdf($this->pdfPath);
            $pdfNumberOfPages = collect(range(1, $this->pdf->getNumberOfPages()));

            $this->pdfImages = $pdfNumberOfPages->map(function ($pageNumber) {
                $imagePath = $this->tempDir . '/' . $this->pdfName . '_page' . $pageNumber . '.jpg';
                $this->pdf
                    ->setPage($pageNumber)
                    ->setResolution(171)
                    ->saveImage($imagePath);
                return $imagePath;
            });
        } catch (PdfDoesNotExist $exception) {
            Log::error('ConvertPDFToText[pdfToImage]: ' . $exception->getMessage());
            abort('Erro ao converter Pdf em Imagem. ' . $exception->getMessage());
        }

        return $this;
    }

    private function imageToText()
    {
        $ocr = new TextractClient([
            'region' => config('services.textract.region'),
            'version' => config('services.textract.version'),
        ]);
        $this->pdfImages->each(function ($imagePath) use ($ocr) {
            $image = new \Imagick($imagePath);
            $imgData = $image->getImageBlob();
            $result = $ocr->detectDocumentText(['Document' => ['Bytes' => $imgData]]);
            $text = collect($result->get('Blocks'))
                ->filter(function ($block) {
                    return $block['BlockType'] === 'LINE';
                })
                ->map(function ($block) {
                    return $block['Text'];
                })
                ->reduce(function ($accumulator, $text) {
                    return $accumulator . ' ' . $text;
                }, '');

            array_push($this->pdfText, $text);
        });
    }

    private function removeTempDirectory()
    {
        $files = glob($this->tempDir . '/*');
        $this->removeFiles($files);
        rmdir($this->tempDir);
    }

    private function removeFiles(array $files)
    {
        foreach ($files as $file) {
            if (is_dir($file)) {
                $this->removeFiles($file);
                rmdir($this->tempDir);
            }

            unlink($file);
        }
    }
}
