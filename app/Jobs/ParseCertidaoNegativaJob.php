<?php

namespace App\Jobs;

use App\Models\Upload;
use App\Services\File\Parse\ParseCertidaoNegativaService;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ParseCertidaoNegativaJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $upload;
    public $tries = 1;

    /**
     * Create a new job instance.
     *
     * @param Upload $upload
     *
     * @return void
     */
    public function __construct(Upload $upload)
    {
        $this->upload = $upload;
        $this->onQueue('parser');
    }

    /**
     * Execute the job.
     *
     * @param ParseCertidaoNegativaService $parseCertidaoNegativaService
     *
     * @return void
     */
    public function handle(ParseCertidaoNegativaService $parseCertidaoNegativaService)
    {
        $parseCertidaoNegativaService->parseCertidao($this->upload);
    }
}
