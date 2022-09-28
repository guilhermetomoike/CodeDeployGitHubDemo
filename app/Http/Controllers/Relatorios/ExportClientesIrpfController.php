<?php

namespace App\Http\Controllers\Relatorios;

use App\Exports\ClientesIrpfExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class ExportClientesIrpfController
{
    public function __invoke(Request $request)
    {
        try {
            $params = $request->all();
            return Excel::download(new ClientesIrpfExport($params), 'result.xlsx');
        } catch (\Exception $exception) {
            Log::error('ExportClientesIrpf: ' . $exception->getMessage());
            return response()->json($exception->getMessage(), 500);
        }
    }
}
