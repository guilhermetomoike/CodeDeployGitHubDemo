<?php

namespace App\Console\Commands;

use App\Models\Cliente;
use CURLFile;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ImportAssets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:assets';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $clients = Cliente::all();

        foreach ($clients as $client) {
            if (empty($client->irpf)) {
                continue;
            }

            if (empty($client->irpf()->first()->arquivo)) {
                continue;
            }

            $file = $client->irpf()->first()->arquivo()->first();

            $this->storageS3 = Storage::disk('s3');
            $this->storageLocal = Storage::disk('local');

            $pdf = $this->storageS3->get($file->caminho);
            $this->storageLocal->put($file->caminho, $pdf);
            $localPath = storage_path('app/private/') . $file->caminho;

            $url = 'http://54.175.152.0/api/income';

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => array('file' => new CURLFILE($localPath)),
            ));

            $response = curl_exec($curl);

            curl_close($curl);

            $data = json_decode($response);
            if (!$data) {
                continue;
            }
            dump($data);
            $this->setIrpf($client, $data);
        }
    }

    public function setIrpf(Cliente $client, $data)
    {
        foreach ($data as $value) {
            $client->irpf()->first()->assets()->updateOrCreate([
                'code' => $value->code,
                'description' => $value->description,
                'value' => number_format(str_replace(",",".",str_replace(".","",$value->value)), 2, '.', ''),
            ]);
        }
    }
}
