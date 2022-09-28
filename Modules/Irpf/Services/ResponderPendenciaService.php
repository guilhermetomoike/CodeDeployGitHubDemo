<?php

namespace Modules\Irpf\Services;

use App\Models\Arquivo;
use App\Models\Cliente;
use App\Modules\ConvertBase64ToFile;
use App\Notifications\CustomerSentPendencyNotification;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Modules\Irpf\Entities\IrpfClientePendencia;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ResponderPendenciaService
{
    private IrpfService $irpfService;
    private Filesystem $storage;

    public function __construct(IrpfService $irpfService)
    {
        $this->irpfService = $irpfService;
        $this->storage = Storage::disk();
    }

    public function execute(array $data, int $customerId)
    {
        try {
            DB::beginTransaction();

            foreach ($data as $pendencia) {
                $this->savePendencia($pendencia);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $code = $e->getCode() ? $e->getCode() : 500;

            throw new \Exception($e->getMessage(), $code);
        } finally {
            $customer = Cliente
                ::with([
                    'irpf' => function($query) {
                        $query->where('ano', today()->subYear()->year);
                    },
                    'irpf.resposta.pendencia',
                    'irpf.pendencias',
                ])
                ->find($customerId);
            $allPendenciesSent = $this->checkPendenciesFinished($customer);

            if ($allPendenciesSent) {
                $customer->notify(new CustomerSentPendencyNotification());
                $this->irpfService->changeIrpfStep($customerId, 'comprovante');
            }
        }
    }

    private function savePendencia($pendencia)
    {
        $pendenciaModel = IrpfClientePendencia::query()->find($pendencia['id']);
        $inputChange = $this->inputChange($pendencia['id'], $pendencia['inputs'], $pendenciaModel->inputs);

        if (!$inputChange) return false;

        $pendenciaModel->inputs = $inputChange;

        return $pendenciaModel->save();
    }

    private function inputChange($pendencia_id, $new_inputs, $model_inputs)
    {
        $extensions = [
            'image/jpeg',
            'image/png',
            'application/pdf',
        ];

        foreach ($new_inputs as &$input) {
            $isBase64 = array_key_exists('value', $input) && ($input['value']['base64'] ?? null);
            if ($isBase64) {
                $validated = false;
                foreach ($extensions as $extension) {
                    if (ConvertBase64ToFile::validate($extension, $input['value']['base64'])) {
                        $validated = true;
                        break;
                    }
                }

                if ($validated) {
                    $input['name'] = $input['value']['name'] ?? $input['name'];
                    $input['value'] = $this->handleBase64Input($pendencia_id, $input['value'], $input['name']);
                } else {
                    throw new \Exception('Tipo do arquivo não é permitido. Aceitamos apenas PDF, JPEG e PNG.', 400);
                }
            }
            if (isset($input['value']) && $input['value'] instanceof UploadedFile) {
                $input['value'] = $this->handleFormDataUpload($pendencia_id, $input['value'], $input['name']);
            }
        }

        if (!$this->validateDiffInInputs($new_inputs, $model_inputs)) {
            return false;
        }
        if (count($new_inputs) != count($model_inputs)) {
            throw new \Exception('Verifique se todos os campos foram enviados corretamente.');
        }

        return $new_inputs;
    }

    private function handleBase64Input($pendencia_id, $inputValue, $fileName)
    {
        $file = ConvertBase64ToFile::run($inputValue['base64']);
        $path = $this->getFileName($inputValue['base64']);

        $this->storage->put($path, $file);

        return $this->saveArquivoModel($pendencia_id, $path, $fileName, $inputValue);
    }

    private function handleFormDataUpload($pendencia_id, UploadedFile $inputValue, $fileName)
    {
        $path = Str::random(40) . '.pdf';
        $this->storage->putFile($path, $inputValue);
        return $this->saveArquivoModel($pendencia_id, $path, $fileName, $inputValue);
    }

    private function validateDiffInInputs($new_inputs, $model_inputs)
    {
        $diff = [];
        foreach ($new_inputs as $new_input) {
            foreach ($model_inputs as $model_input) {
                if ($model_input['label'] != $new_input['label']) {
                    continue;
                }

                if (!isset($model_input['value']) || (
                        $model_input['value'] != $new_input['value']
                    )) {
                    $diff[] = $new_input;
                }
            }
        }
        return count($diff);
    }

    private function saveArquivoModel($pendencia_id, string $path, $fileName, $fileSource)
    {
        return Arquivo::query()->create([
            'nome' => $fileName,
            'caminho' => $path,
            'nome_original' => $fileSource instanceof UploadedFile ? $fileSource->getClientOriginalName() : $fileSource['name'] ?? null,
            'model_id' => $pendencia_id,
            'model_type' => IrpfClientePendencia::class
        ])->id;
    }

    private function getFileName(string $base64): string
    {
        $extension = ConvertBase64ToFile::getExtension($base64);

        return Str::random(40) . $extension;
    }

    private function checkPendenciesFinished($customer): bool
    {
        $irpf = $customer->irpf;
        $pendenciesStatus = $this->irpfService->pendenciesStatus($irpf);

        return $pendenciesStatus['required']->count() <= $pendenciesStatus['sent']->count() && !$pendenciesStatus['diff']->count();
    }
}
