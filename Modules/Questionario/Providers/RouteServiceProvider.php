<?php

namespace Modules\Questionario\Providers;

use Illuminate\Support\Facades\Route;
use Modules\Questionario\Entities\QuestionarioParte;
use Modules\Questionario\Entities\QuestionarioPagina;
use Modules\Questionario\Entities\QuestionarioPergunta;
use Modules\Questionario\Entities\QuestionarioResposta;
use Modules\Questionario\Http\Resources\QuestionarioResource;
use Modules\Questionario\Entities\QuestionarioPerguntaEscolha;
use Modules\Questionario\Http\Resources\QuestionarioParteResource;
use Modules\Questionario\Http\Resources\QuestionarioPaginaResource;
use Modules\Questionario\Http\Resources\QuestionarioPerguntumResource;
use Modules\Questionario\Http\Resources\QuestionarioRespostumResource;
use Modules\Questionario\Http\Resources\QuestionarioPerguntaEscolhaResource;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The module namespace to assume when generating URLs to actions.
     *
     * @var string
     */
    protected $moduleNamespace = 'Modules\Questionario\Http\Controllers';

    /**
     * Called before routes are registered.
     *
     * Register any model bindings or pattern based filters.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::middleware('api')
            ->group(module_path('Questionario', '/Routes/api.php'));
    }
}
