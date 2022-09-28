<?php

namespace App\Http\Controllers;

use App\Mail\EmpresaPosCadastroSendFilesMail;
use App\Models\Empresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmpresaPosCadastroSendFilesController extends Controller
{
    public function files(Empresa $empresa)
    {
        return $empresa->precadastro->arquivos;
    }

    public function attach(Request $request, Empresa $empresa)
    {
        $data = $request->validate([
            'file_id' => 'required|integer|exists:arquivos,id'
        ]);

        $empresa->precadastro->addArquivo($data['file_id']);

        return $empresa->precadastro->arquivos;
    }

    public function send(Request $request, Empresa $empresa)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required',
            'files_ids' => 'required|array'
        ]);

        Mail::to($data['email'])
            ->send(new EmpresaPosCadastroSendFilesMail($empresa, $data['subject'], $data['message'], $data['files_ids']));
    }
}
