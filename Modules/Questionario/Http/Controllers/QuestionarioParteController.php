<?php

namespace Modules\Questionario\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Questionario\Entities\QuestionarioParte;
use Modules\Questionario\Http\Requests\QuestionarioParteStoreRequest;
use Modules\Questionario\Http\Requests\QuestionarioParteUpdateRequest;
use Modules\Questionario\Http\Resources\QuestionarioParteCollection;
use Modules\Questionario\Http\Resources\QuestionarioParteResource;

class QuestionarioParteController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Modules\Questionario\Http\Resources\QuestionarioParteCollection
     */
    public function index(Request $request)
    {
        $questionarioPartes = QuestionarioParte::all();

        return new QuestionarioParteCollection($questionarioPartes);
    }

    /**
     * @param \Modules\Questionario\Http\Requests\QuestionarioParteStoreRequest $request
     * @return \Modules\Questionario\Http\Resources\QuestionarioParteResource
     */
    public function store(QuestionarioParteStoreRequest $request)
    {
        $questionarioParte = QuestionarioParte::create($request->validated());

        return new QuestionarioParteResource($questionarioParte);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \Modules\Questionario\Entities\QuestionarioParte $questionarioParte
     * @return \Modules\Questionario\Http\Resources\QuestionarioParteResource
     */
    public function show(Request $request, QuestionarioParte $questionarioParte)
    {
        return new QuestionarioParteResource($questionarioParte);
    }

    /**
     * @param \Modules\Questionario\Http\Requests\QuestionarioParteUpdateRequest $request
     * @param \Modules\Questionario\Entities\QuestionarioParte $questionarioParte
     * @return \Modules\Questionario\Http\Resources\QuestionarioParteResource
     */
    public function update(QuestionarioParteUpdateRequest $request, QuestionarioParte $questionarioParte)
    {
        $questionarioParte->update($request->validated());

        return new QuestionarioParteResource($questionarioParte);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \Modules\Questionario\Entities\QuestionarioParte $questionarioParte
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, QuestionarioParte $questionarioParte)
    {
        $questionarioParte->delete();

        return response()->noContent();
    }
}
