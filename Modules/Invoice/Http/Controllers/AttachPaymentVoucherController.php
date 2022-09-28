<?php


namespace Modules\Invoice\Http\Controllers;


use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Invoice\Services\InvoicePaymentVoucherService;

class AttachPaymentVoucherController
{
    private InvoicePaymentVoucherService $invoicePaymentVoucher;

    public function __construct(InvoicePaymentVoucherService $invoicePaymentVoucher)
    {
        $this->invoicePaymentVoucher = $invoicePaymentVoucher;
    }

    public function store(Request $request, int $id)
    {
        $voucher = $request->file('voucher');
        $uploaded = $this->invoicePaymentVoucher->attach($id, $voucher);
        return new JsonResponse([
            'message' => 'Upload realizado com sucesso.',
            'data' => $uploaded
        ]);
    }

    public function show(int $id)
    {
        $voucher = $this->invoicePaymentVoucher->getByInvoice($id);
        return new JsonResponse($voucher ?? []);
    }
}
