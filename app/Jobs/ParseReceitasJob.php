<?php

namespace App\Jobs;

use App\Models\Upload;
use App\Services\File\Parse\ParseReceitasService;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ParseReceitasJob implements ShouldQueue
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
     * @param ParseReceitasService $parseService
     *
     * @return void
     */
    public function handle(ParseReceitasService $parseService)
    {
        $parseService->parse($this->upload);
       

       
    }
}
