<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search', '');

        return Faq::where('pergunta', 'like', "%{$search}%")->get();
    }
}
