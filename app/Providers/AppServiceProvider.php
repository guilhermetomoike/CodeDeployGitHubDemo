<?php

namespace App\Providers;

use App\Models\CertificadoDigital;
use App\Models\Cliente;
use App\Models\Cliente\ResidenciaMedica;
use App\Models\Empresa;
use App\Models\Empresa\AcessoPrefeitura;
use App\Models\Empresa\Alvara;
use App\Models\EmpresaPreCadastro;
use App\Models\Guia;
use App\Models\Nfse\TomadorNfse;
use App\Models\OrdemServico\OrdemServico;
use App\Models\OrdemServico\OrdemServicoAtividade;
use App\Observers\ClienteObserver;
use App\Observers\FaturaObserver;
use App\Observers\TomadorNfseOberserver;
use App\Services\ClicksignApiService;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Modules\Contratantes\Entities\Contratante;
use Modules\Invoice\Entities\Fatura;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        TomadorNfse::observe(TomadorNfseOberserver::class);
        Cliente::observe(ClienteObserver::class);
        //  Fatura::observe(FaturaObserver::class);

        Relation::morphMap([
            'cliente' => Cliente::class,
            'residencia_medica' => ResidenciaMedica::class,
            'empresa' => Empresa::class,
            'empresa_pre_cadastro' => EmpresaPreCadastro::class,
            'empresa_alvara' => Alvara::class,
            'empresa_acesso_prefeitura' => AcessoPrefeitura::class,
            'guia' => Guia::class,
            'certificado' => CertificadoDigital::class,
            'ordem_servico' => OrdemServico::class,
            'ordem_servico_atividade' => OrdemServicoAtividade::class,
            'contratante' => Contratante::class
        ]);

        $this->app->bind('ClicksignApi', function (Application $app) {
            return new ClicksignApiService(
                $app->make('config')->get('services.clicksign.token'),
                $app->environment()
            );
        });
    }
}
