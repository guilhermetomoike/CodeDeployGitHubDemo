<?php

namespace App\Http\Controllers;

use App\Models\Endereco;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EnderecoController extends Controller
{
    public function index($addressable_type, $addressable_id)
    {
        $endereco = Endereco::addressable($addressable_type, $addressable_id)->first();

        return response($endereco);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'addressable_type' => ['nullable', 'in:cliente,empresa'],
            'addressable_id' => ['nullable', 'integer'],
            'iptu' => ['nullable'],
            'cep' => ['required', 'size:8'],
            'logradouro' => ['required'],
            'numero' => ['required'],
            'complemento' => ['nullable'],
            'bairro' => ['required'],
            'cidade' => ['required'],
            'uf' => ['required', 'size:2'],
            'ibge' => ['nullable', 'size:7'],
            'tipo' => ['nullable'],
        ]);

        if (
            !empty($data['addressable_type'])
            && !empty($data['addressable_id'])
            && Endereco::addressable($data['addressable_type'], $data['addressable_id'])->exists()
        ) {
            return $this->errorResponse('Endereço já cadastrado');
        }

        return response(Endereco::create($data));
    }

    public function update(Request $request, $id)
    {
        $endereco = Endereco::find($id);

        $data = $request->validate([
            'iptu' => ['required'],
            'cep' => ['required', 'size:8'],
            'logradouro' => ['required'],
            'numero' => ['required'],
            'complemento' => ['nullable'],
            'bairro' => ['required'],
            'cidade' => ['required'],
            'uf' => ['required', 'size:2'],
            'ibge' => ['required', 'size:7'],
            'tipo' => ['required']
        ]);

        $endereco->fill($data)->save();

        return response($endereco);
    }
}
