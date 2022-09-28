<?php

namespace App\Jobs;

use App\Models\Upload;
use App\Services\File\Parse\ParseGuiasService;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ParseGuiasJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $upload;
    

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
     * @param ParseGuiasService $parseGuiasService
     *
     * @return void
     */
    public function handle(ParseGuiasService $parseGuiasService)
    {
        $parseGuiasService->parseGuia($this->upload);
       
    }
}
