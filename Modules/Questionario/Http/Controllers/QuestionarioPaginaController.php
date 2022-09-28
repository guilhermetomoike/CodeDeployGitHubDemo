<?php

namespace Modules\Questionario\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Questionario\Entities\QuestionarioPagina;
use Modules\Questionario\Http\Requests\QuestionarioPaginaStoreRequest;
use Modules\Questionario\Http\Requests\QuestionarioPaginaUpdateRequest;
use Modules\Questionario\Http\Resources\QuestionarioPaginaCollection;
use Modules\Questionario\Http\Resources\QuestionarioPaginaResource;

class QuestionarioPaginaController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Modules\Questionario\Http\Resources\QuestionarioPaginaCollection
     */
    public function index(Request $request)
    {
        $questionarioPaginas = QuestionarioPagina::all();

        return new QuestionarioPaginaCollection($questionarioPaginas);
    }

    /**
     * @param \Modules\Questionario\Http\Requests\QuestionarioPaginaStoreRequest $request
     * @return \Modules\Questionario\Http\Resources\QuestionarioPaginaResource
     */
    public function store(QuestionarioPaginaStoreRequest $request)
    {
        $questionarioPagina = QuestionarioPagina::create($request->validated());

        return new QuestionarioPaginaResource($questionarioPagina);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \Modules\Questionario\Entities\QuestionarioPagina $questionarioPagina
     * @return \Modules\Questionario\Http\Resources\QuestionarioPaginaResource
     */
    public function show(Request $request, QuestionarioPagina $questionarioPagina)
    {
        return new QuestionarioPaginaResource($questionarioPagina);
    }

    /**
     * @param \Modules\Questionario\Http\Requests\QuestionarioPaginaUpdateRequest $request
     * @param \Modules\Questionario\Entities\QuestionarioPagina $questionarioPagina
     * @return \Modules\Questionario\Http\Resources\QuestionarioPaginaResource
     */
    public function update(QuestionarioPaginaUpdateRequest $request, QuestionarioPagina $questionarioPagina)
    {
        $questionarioPagina->update($request->validated());

        return new QuestionarioPaginaResource($questionarioPagina);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \Modules\Questionario\Entities\QuestionarioPagina $questionarioPagina
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, QuestionarioPagina $questionarioPagina)
    {
        $questionarioPagina->delete();

        return response()->noContent();
    }
}
