<?php

namespace Modules\Questionario\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Questionario\Entities\QuestionarioPerguntaEscolha;
use Modules\Questionario\Http\Requests\QuestionarioPerguntaEscolhaStoreRequest;
use Modules\Questionario\Http\Requests\QuestionarioPerguntaEscolhaUpdateRequest;
use Modules\Questionario\Http\Resources\QuestionarioPerguntaEscolhaCollection;
use Modules\Questionario\Http\Resources\QuestionarioPerguntaEscolhaResource;

class QuestionarioPerguntaEscolhaController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Modules\Questionario\Http\Resources\QuestionarioPerguntaEscolhaCollection
     */
    public function index(Request $request)
    {
        $questionarioPerguntaEscolhas = QuestionarioPerguntaEscolha::all();

        return new QuestionarioPerguntaEscolhaCollection($questionarioPerguntaEscolhas);
    }

    /**
     * @param \Modules\Questionario\Http\Requests\QuestionarioPerguntaEscolhaStoreRequest $request
     * @return \Modules\Questionario\Http\Resources\QuestionarioPerguntaEscolhaResource
     */
    public function store(QuestionarioPerguntaEscolhaStoreRequest $request)
    {
        $questionarioPerguntaEscolha = QuestionarioPerguntaEscolha::create($request->validated());

        return new QuestionarioPerguntaEscolhaResource($questionarioPerguntaEscolha);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \Modules\Questionario\Entities\QuestionarioPerguntaEscolha $questionarioPerguntaEscolha
     * @return \Modules\Questionario\Http\Resources\QuestionarioPerguntaEscolhaResource
     */
    public function show(Request $request, QuestionarioPerguntaEscolha $questionarioPerguntaEscolha)
    {
        return new QuestionarioPerguntaEscolhaResource($questionarioPerguntaEscolha);
    }

    /**
     * @param \Modules\Questionario\Http\Requests\QuestionarioPerguntaEscolhaUpdateRequest $request
     * @param \Modules\Questionario\Entities\QuestionarioPerguntaEscolha $questionarioPerguntaEscolha
     * @return \Modules\Questionario\Http\Resources\QuestionarioPerguntaEscolhaResource
     */
    public function update(QuestionarioPerguntaEscolhaUpdateRequest $request, QuestionarioPerguntaEscolha $questionarioPerguntaEscolha)
    {
        $questionarioPerguntaEscolha->update($request->validated());

        return new QuestionarioPerguntaEscolhaResource($questionarioPerguntaEscolha);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \Modules\Questionario\Entities\QuestionarioPerguntaEscolha $questionarioPerguntaEscolha
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, QuestionarioPerguntaEscolha $questionarioPerguntaEscolha)
    {
        $questionarioPerguntaEscolha->delete();

        return response()->noContent();
    }
}
