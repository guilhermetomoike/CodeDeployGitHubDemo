<?php

namespace App\Http\Controllers;

use App\Models\GuiasDatasPadrao;
use Illuminate\Http\Request;

class GuiasDatasPadraoController extends Controller
{
    public function index()
    {
        return GuiasDatasPadrao::all();
    }

    public function update(Request $request)
    {
        $request->validate(['*.data_vencimento' => ['required', 'date']]);

        foreach ($request->all() as $guia) {
            GuiasDatasPadrao::query()->where('id', $guia['id'])->update([
                'data_vencimento' => $guia['data_vencimento']
            ]);
        }
        return GuiasDatasPadrao::all();
    }
}
