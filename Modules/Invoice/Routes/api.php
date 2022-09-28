<?php

use Illuminate\Support\Facades\Route;
use Modules\Invoice\Http\Middleware\InvoiceAsasWebhook;
use Modules\Invoice\Http\Middleware\InvoiceWebhook;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('jwt')->group(function () {

    Route::prefix('faturas')->group(function () {
        Route::put('cancelar', 'InvoiceController@salveMotivoCancelamento');
        Route::put('estornar/{fatura_id}', 'InvoiceController@estornarFatura');
        Route::delete('{fatura_id}', 'InvoiceController@destroy');

        Route::post('{payer_type}/{payer_id}/pagar', 'PayInvoiceController')
            ->where(['payer_type' => '^(cliente|empresa)$', 'payer_id' => '[0-9]+']);

        Route::get('{payer_type}/{payer_id}', 'InvoiceController@getByPayer')
            ->where(['payer_type' => '^(cliente|empresa)$', 'payer_id' => '[0-9]+']);
            
            Route::get('/atrasadas/{payer_type}/{payer_id}', 'InvoiceController@getByPayerAtrasadas')
            ->where(['payer_type' => '^(cliente|empresa)$', 'payer_id' => '[0-9]+']);
            
        Route::post('send', 'SendInvoiceController');

        Route::post('{id}/voucher', 'AttachPaymentVoucherController@store');
        Route::get('{id}/voucher', 'AttachPaymentVoucherController@show');

        Route::get('contas-receber', 'ContasReceberController@index');
        Route::get('contas-receber/{id}', 'ContasReceberController@show');
        Route::post('contas-receber/create-lancamento', 'ContasReceberController@storeLancamento');
        Route::post('contas-receber/adicionais', 'ContasReceberController@storeLancamentoAdicionais');
        Route::get('contas-receber/relatorio/adicionais', 'ContasReceberController@relatorioLancamentoAdicionais');
        Route::post('casClienteAsas', 'ContasReceberController@ClienteAsas');
        Route::put('/', 'InvoiceController@update');




    });

    Route::apiResource('faturas', 'InvoiceController');
    Route::post('faturas/store-atrasadas','invoiceController@storeAtrasadas');

    
    // Route::post('financeiro/arrumar/contas', 'ContasReceberController@ArrumarPlanos');
    // Route::post('financeiro/arrumar/plano', 'ContasReceberController@ArrumarPlanosEmpresa');


    Route::post('financeiro/faturas/relatorio', 'InvoiceController@relatorioFaturas');
    Route::post('financeiro/boleto/teste', 'ContasReceberController@criarBoletoTeste');
    Route::post('financeiro/contasreceber', 'ContasReceberController@createContasReceber');
    Route::post('financeiro/socios/relatorio', 'ContasReceberController@relatorioSociosAfetados');
    Route::post('financeiro/upload/faturamento', 'ContasReceberController@uploadFaturamentos');
    Route::get('financeiro/listar_faturamentos', 'ContasReceberController@listar_faturamentos');
    Route::post('financeiro/upload/funcionarios', 'ContasReceberController@uploadFuncinarios');
    Route::get('financeiro/adicionais/{payer_id}/{payer_type}', 'InvoiceController@listaAdicionais');
    Route::put('financeiro/fatura/status', 'InvoiceController@updateFaturaStatus');
    Route::post('financeiro/value/status', 'InvoiceController@getValueForStatus');

    Route::post('financeiro/inicio', 'ContasReceberController@CreateContasReceberPosCadastro');

    Route::post('financeiro/value/status', 'InvoiceController@getValueForStatus');
    Route::post('financeiro/honorario/guia', 'InvoiceController@honorarioGuia');


    Route::prefix('tipoCobranca')->group(function () {
    Route::get('/', 'TipoCobrancaController@index');
    Route::get('lista', 'TipoCobrancaController@index2');

    // Route::get('/{id}', 'TipoCobrancaController@showByid');

    
    Route::post('/', 'TipoCobrancaController@store');
    Route::put('/{id}', 'TipoCobrancaController@update');
    Route::delete('/{id}', 'TipoCobrancaController@destroy');

    
    
    });

    
    Route::prefix('fatura_motivo_cancelamento')->group(function () {
        Route::get('/', 'FaturaMotivoCancelamentoController@index');
        Route::post('/', 'FaturaMotivoCancelamentoController@store');
        Route::put('/{id}', 'FaturaMotivoCancelamentoController@update');
        Route::delete('/{id}', 'FaturaMotivoCancelamentoController@destroy');
        });
    


    
    Route::prefix('relatorio')->group(function () {

    Route::get('congeladas', 'FinanRelatoriosController@relatorioCongeladas');
    Route::get('cancelados', 'FinanRelatoriosController@relatorioCanceladas');
    Route::get('semcontrato', 'FinanRelatoriosController@relatorioSemContratos');
    Route::get('clientexfatura', 'FinanRelatoriosController@relatorioClienteXFatura');
    Route::get('clientexfaturaCartao', 'FinanRelatoriosController@relatorioClienteXFaturaCartao');
    Route::get('semcrm', 'FinanRelatoriosController@relatorioSemCrm');
    Route::get('empresasPlanos', 'FinanRelatoriosController@relatorioEmpresasPlanosDeleted');
    Route::get('semalvara', 'FinanRelatoriosController@RelatorioEmpresaSemAlvara');
    Route::get('empresasResidentes', 'FinanRelatoriosController@relatorioEmpresasResidente');
    Route::get('EmpresasSemCrmJuridico', 'FinanRelatoriosController@relatorioEmpresasSemCrmJuridico');
    Route::get('EmpresasComCrmJuridico', 'FinanRelatoriosController@relatorioEmpresasComCrmJuridico');
    Route::get('EmpresasCongeladasPlanoAnual', 'FinanRelatoriosController@relatorioEmpresaPlanoAnualCong');

    Route::get('previsoes', 'FinanRelatoriosController@relatorioPrevisoesAtivas');
    Route::post('comissoes', 'FinanRelatoriosController@relatorioComissoes');
    Route::get('comissoes/excongelados', 'FinanRelatoriosController@relatorioComissoesExCongelados');
    Route::post('abertura/dias', 'FinanRelatoriosController@EmpresaAberturaDate');
    Route::get('financeiro/valores', 'FinanRelatoriosController@relatorioDeOndeVeio');
    Route::get('financeiro/pagantescartao', 'FinanRelatoriosController@relatorioPagantesCartao');

    Route::get('financeiro/empresasocios', 'FinanRelatoriosController@relatorioEmpresasMesmoSocio');
    Route::get('financeiro/guialib', 'FinanRelatoriosController@relatorioGuiasLiberacao');
    Route::get('financeiro/faturamentos', 'FinanRelatoriosController@relatorioFaturamentoEmpresas');

    Route::get('financeiro/relatorio-congelados-honorarios', 'FinanRelatoriosController@relatorioCongeladosHonorarios');
    Route::get('relatorio-clientes-adm', 'FinanRelatoriosController@relatorioClientesAdm');
    Route::get('fachamento-mensal', 'FinanRelatoriosController@relatorioFechamentoMensal');
    Route::get('cliente-faturados', 'FinanRelatoriosController@relatorioClientesFat');

    



    // Route::get('previsoes/abertura', 'FinanRelatoriosController@relatorioPrevisoesAtivas');
    // Route::get('Previsoes/congeladas', 'FinanRelatoriosController@relatorioPrevisoesAtivas');
    
    });

    
    Route::prefix('fatura-cliente')->group(function () {
        Route::post('antecipar', 'InvoiceController@antecipacaoCliente');
    });
    Route::apiResource('payment-methods', 'PaymentMethodController')->except('show', 'update');
    Route::get('payment-methods/{payer_type}/{payer_id}', 'PaymentMethodController@show')
        ->where(['payer_type' => '^(cliente|empresa)$', 'payer_id' => '[0-9]+']);

    // CARTAO DE CREDITO - LEGADO (UTILIZADO NA VIEW DO CLIENTE)
    Route::prefix('cartao-credito')->group(function () {
        Route::post('cadastrar', 'PaymentMethodController@store');
//        Route::post('recebimento', 'CartaoCreditoController@recebimentoEmpresa');
    });
    
    
});


// // WEBHOOKS
// Route::middleware(InvoiceWebhook::class)->prefix('webhook')->group(function () {
//     Route::post('iugu/mudanca-estado-fatura', 'WebhookInvoiceStatusChangeController');
//     Route::post('iugu/fatura-liberada', 'InvoiceController@webhookFaturaLiberada'); // recorrencia lancada

//     // Route::post('assa/fatura-liberada', 'InvoiceController@webhookFaturaLiberada'); // recorrencia lancada
// });
Route::middleware(InvoiceAsasWebhook::class)->prefix('webhook')->group(function () {
Route::post('asaas/mudanca-estado-fatura', 'WebhookInvoiceStatusChangeAsaasController@index');

});