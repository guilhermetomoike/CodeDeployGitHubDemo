<?php

namespace Modules\Questionario\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Questionario\Entities\QuestionarioResposta;
use Modules\Questionario\Http\Resources\QuestionarioRespostumResource;
use Modules\Questionario\Http\Resources\QuestionarioRespostumCollection;
use Modules\Questionario\Http\Requests\QuestionarioRespostaUpdateRequest;
use Modules\Questionario\Http\Requests\QuestionarioRespostumStoreRequest;
use Modules\Questionario\Http\Requests\QuestionarioRespostumUpdateRequest;

class QuestionarioRespostaController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Modules\Questionario\Http\Resources\QuestionarioRespostumCollection
     */
    public function index(Request $request)
    {
        $questionarioResposta = QuestionarioResposta::all();

        return new QuestionarioRespostumCollection($questionarioResposta);
    }

    /**
     * @param \Modules\Questionario\Http\Requests\QuestionarioRespostaStoreRequest $request
     * @return \Modules\Questionario\Http\Resources\QuestionarioRespostumResource
     */
    public function store(QuestionarioRespostumStoreRequest $request)
    {
        $questionarioRespostum = QuestionarioResposta::create($request->validated());

        return new QuestionarioRespostumResource($questionarioRespostum);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \Modules\Questionario\Entities\QuestionarioResposta $questionarioRespostum
     * @return \Modules\Questionario\Http\Resources\QuestionarioRespostumResource
     */
    public function show(Request $request, QuestionarioResposta $questionarioRespostum)
    {
        return new QuestionarioRespostumResource($questionarioRespostum);
    }

    /**
     * @param \Modules\Questionario\Http\Requests\QuestionarioRespostaUpdateRequest $request
     * @param \Modules\Questionario\Entities\QuestionarioResposta $questionarioRespostum
     * @return \Modules\Questionario\Http\Resources\QuestionarioRespostumResource
     */
    public function update(QuestionarioRespostumUpdateRequest $request, QuestionarioResposta $questionarioRespostum)
    {
        $questionarioRespostum->update($request->validated());

        return new QuestionarioRespostumResource($questionarioRespostum);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \Modules\Questionario\Entities\QuestionarioResposta $questionarioRespostum
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, QuestionarioResposta $questionarioRespostum)
    {
        $questionarioRespostum->delete();

        return response()->noContent();
    }
}
