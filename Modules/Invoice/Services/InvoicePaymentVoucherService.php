<?php


namespace Modules\Invoice\Services;


use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Modules\Invoice\Entities\Fatura;

class InvoicePaymentVoucherService
{
    public function attach(int $id, ?UploadedFile $uploadedFile)
    {
        try {
            DB::beginTransaction();
            $fatura = Fatura::query()->find($id);
            $file = Storage::disk('s3')->put(null, $uploadedFile);
            $voucher = $fatura->voucher()->create();
            $voucher->arquivo()->create([
                'caminho' => $file,
                'nome_original' => $uploadedFile->getFilename(),
                'nome' => 'comprovante_'.date('d-m-y')
            ]);
            $fatura->update(['status' => 'processando']);
            DB::commit();
            return $voucher->fresh();
        } catch (\Exception $e) {
            if ($file) Storage::disk('s3')->delete($file);
            DB::rollBack();
            return false;
        }
    }

    public function getByInvoice(int $id)
    {
        $fatura = Fatura::query()->find($id);
        return $fatura->voucher;
    }
}
