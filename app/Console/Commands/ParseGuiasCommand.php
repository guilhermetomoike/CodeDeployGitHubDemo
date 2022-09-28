<?php

namespace App\Console\Commands;

use App\Jobs\ParseGuiasJob;
use App\Services\File\FileService;
use Illuminate\Console\Command;

class ParseGuiasCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse:guias';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parse all selected Guias';

    /**
     * The service to run the procedures.
     *
     * @var FileService
     */
    protected $fileService;

    /**
     * Create a new command instance.
     *
     * @param FileService $fileService
     *
     * @return void
     */
    public function __construct(FileService $fileService)
    {
        parent::__construct();

        $this->fileService = $fileService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $files = $this->fileService->getPendingUploadFiles('guia');

        foreach ($files as $file) {
            ParseGuiasJob::dispatch($file);
        }
    }
}
