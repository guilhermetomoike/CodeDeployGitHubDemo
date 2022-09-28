<?php

namespace Modules\Contratantes\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    protected $moduleNamespace = 'Modules\Contratantes\Http\Controllers';
    
    public function map()
    {
        $this->mapApiRoutes();
    }
    
    protected function mapApiRoutes()
    {
        Route::middleware('api')
            ->namespace($this->moduleNamespace)
            ->group(module_path('Contratantes', '/Routes/api.php'));
    }
}
