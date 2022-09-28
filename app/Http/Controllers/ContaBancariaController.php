<?php

namespace App\Http\Controllers;

use App\Models\ContaBancaria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ContaBancariaController extends Controller
{

    public function index($owner_type, $owner_id)
    {
        $contasBancarias = ContaBancaria::owner($owner_type, $owner_id)
            ->orderBy('principal', 'desc')
            ->orderBy('id', 'desc')
            ->with('banco')
            ->get();

        return response($contasBancarias);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'owner_type' => ['required', 'in:cliente,empresa'],
            'owner_id' => ['required', 'integer'],
            'cpf_cnpj' => ['required', 'between:9,14'],
            'agencia' => ['required', 'max:10'],
            'dv_agencia' => ['nullable', 'max:2'],
            'conta' => ['required', 'between:3,10'],
            'dv_conta' => ['nullable', 'max:2'],
            'tipo' => ['required', 'in:p,c'],
            'pessoa' => ['required', 'in:pf,pj'],
            'banco_id' => ['required', 'exists:bancos,id'],
            'principal' => ['required', 'boolean'],
        ]);

        try {
            DB::beginTransaction();

            if ($data['principal']) {
                ContaBancaria::resetPrincipal($data['owner_type'], $data['owner_id']);
            }
            $conta = ContaBancaria::create($data);

            DB::commit();
            return response($conta);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->errorResponse();
        }
    }

    public function update(Request $request, $id)
    {
        $contaBancaria = ContaBancaria::findOrFail($id);
        $data = $request->validate([
            'cpf_cnpj' => ['required', 'between:9,14'],
            'agencia' => ['required', 'max:10'],
            'dv_agencia' => ['nullable', 'max:2'],
            'conta' => ['required', 'between:3,10'],
            'dv_conta' => ['nullable', 'max:2'],
            'tipo' => ['required', 'in:p,c'],
            'pessoa' => ['required', 'in:pf,pj'],
            'banco_id' => ['required', 'exists:bancos,id'],
            'principal' => ['required', 'in:0,1'],
        ]);

        try {
            DB::beginTransaction();

            if ($data['principal']) {
                ContaBancaria::resetPrincipal($contaBancaria->owner_type, $contaBancaria->owner_id);
            }
            $contaBancaria->fill($data)->save();

            DB::commit();
            return response($contaBancaria);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->errorResponse($th->getMessage());
        }
    }

    public function destroy($id)
    {
        ContaBancaria::find($id)->delete();
        return $this->successResponse();
    }
}
