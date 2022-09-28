<?php

namespace Modules\Questionario\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Questionario\Entities\QuestionarioPergunta;
use Modules\Questionario\Http\Resources\QuestionarioPerguntumResource;
 use Modules\Questionario\Http\Resources\QuestionarioPerguntumCollection;
 use Modules\Questionario\Http\Requests\QuestionarioPerguntumStoreRequest;
use Modules\Questionario\Http\Requests\QuestionarioPerguntumUpdateRequest;

class QuestionarioPerguntaController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Modules\Questionario\Http\Resources\QuestionarioPerguntumCollection
     */
    public function index(Request $request)
    {
        $questionarioPergunta = QuestionarioPergunta::all();

        return new QuestionarioPerguntumCollection($questionarioPergunta);
    }

    /**
     * @param \Modules\Questionario\Http\Requests\QuestionarioPerguntaStoreRequest $request
     * @return \Modules\Questionario\Http\Resources\QuestionarioPerguntumResource
     */
    public function store(QuestionarioPerguntumStoreRequest $request)
    {
        $questionarioPerguntum = QuestionarioPergunta::create($request->validated());

        return new QuestionarioPerguntumResource($questionarioPerguntum);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \Modules\Questionario\Entities\QuestionarioPergunta $questionarioPerguntum
     * @return \Modules\Questionario\Http\Resources\QuestionarioPerguntumResource
     */
    public function show(Request $request, QuestionarioPergunta $questionarioPerguntum)
    {
        return new QuestionarioPerguntumResource($questionarioPerguntum);
    }

    /**
     * @param \Modules\Questionario\Http\Requests\QuestionarioPerguntaUpdateRequest $request
     * @param \Modules\Questionario\Entities\QuestionarioPergunta $questionarioPerguntum
     * @return \Modules\Questionario\Http\Resources\QuestionarioPerguntumResource
     */
    public function update(QuestionarioPerguntumUpdateRequest $request, QuestionarioPergunta $questionarioPerguntum)
    {
        $questionarioPerguntum->update($request->validated());

        return new QuestionarioPerguntumResource($questionarioPerguntum);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \Modules\Questionario\Entities\QuestionarioPergunta $questionarioPerguntum
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, QuestionarioPergunta $questionarioPerguntum)
    {
        $questionarioPerguntum->delete();

        return response()->noContent();
    }
}
