<?php

namespace App\Http\Controllers\Relatorios;

use App\Exports\EmpresaAcessosCarteiraExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportAcessosCarteiraController
{
    public function __invoke(Request $request)
    {
        $params = $request->all();
        return Excel::download(new EmpresaAcessosCarteiraExport($params), 'result.xlsx');
    }
}
