<?php

namespace App\Http\Controllers;

use App\Models\Crm;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CrmController extends Controller
{
    public function index($owner_type, $owner_id)
    {
        $crm = Crm::owner($owner_type, $owner_id)->first();

        return response($crm);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'owner_type' => ['required', 'in:empresa,cliente'],
            'owner_id' => ['required', 'integer'],
            'numero' => ['nullable'],
            'senha' => ['nullable'],
            'estado' => ['nullable', 'size:2'],
            'data_emissao' => ['required', 'date'],
        ]);

        if(Crm::owner($data['owner_type'], $data['owner_id'])->exists()) {
            return $this->errorResponse('CRM já cadastrado');
        }

        return response(Crm::create($data));
    }

    public function update(Request $request, int $id)
    {
        $crm = Crm::find($id);
        $data = $request->validate([
            'numero' => ['nullable'],
            'senha' => ['nullable'],
            'estado' => ['nullable', 'size:2'],
            'data_emissao' => ['required', 'date'],
        ]);

        $crm->fill($data)->save();

        return response($crm);
    }
}
