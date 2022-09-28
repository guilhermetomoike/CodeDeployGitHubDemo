<?php


use Illuminate\Support\Facades\Route;

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

Route::post('usuario/login', 'Auth\LoginController@loginUsuario');
Route::post('cliente/login', 'Auth\LoginController@loginCliente');

Route::post('clientes/resetar-senha', 'Auth\ResetClientePasswordController@resetPassword');
Route::post('clientes/resetar-senha-info', 'Auth\ResetClientePasswordController@ResetPasswordInfo');

Route::prefix('satisfacao')->group(function () {
    // Route::get('/', 'CartaoCreditoController@index');
    // Route::put('/{id}', 'CartaoCreditoController@update');
    Route::post('/', 'SatisfacaoController@store');
    Route::get('/relatorio', 'SatisfacaoController@relatorioSatisfacao');
});

Route::group(['middleware' => ['jwt']], function () {
    Route::get('refresh-token', 'Auth\LoginController@refresh');
    Route::get('verify-token', 'Auth\LoginController@verifyToken');

    Route::get('usuarios/tipo', 'UsuarioController@getTipoUsuario');
    Route::post('usuarios/{id}/permissao', 'UsuarioController@setPermission');
    Route::post('usuarios/{id}/role', 'UsuarioController@setRole');
    Route::apiResource('usuarios', 'UsuarioController');
    Route::post('usuarios/{id}/avatar', 'UsuarioController@updateAvatar');
    Route::post('usuarios/restore/{id}', 'UsuarioController@restore');
    Route::get('usuarios/{id}/avatar', 'UsuarioController@getAvatar');
    Route::get('usuario-info', 'UsuarioController@getUserByToken');

    Route::apiResource('roles', 'Auth\RoleController');
    Route::apiResource('permissions', 'Auth\PermissionController');

    // Clientes
    Route::prefix('clientes')->group(function () {
        Route::get('search/{search}', 'ClienteController@search');
        Route::get('/{id}/empresas', 'ClienteController@empresas');
        Route::get('zendesk-chat', 'ClienteController@getZendeskJwt');
        Route::patch('{id}', 'ClienteController@update');
        Route::patch('{id}/alterar-senha', 'ClienteController@updatePassword');
        Route::put('{id}/reset-senha', 'ClienteController@resetPassword');

        Route::post('{id}/avatar', 'ClienteController@updateAvatar');
        Route::get('{id}/avatar', 'ClienteController@getAvatar');
        Route::post('{id}/add-arquivo', 'ClienteController@addArquivo');
        Route::apiResource('{client_id}/access', 'Customer\AccessController')
            ->only(['store', 'update', 'index']);
    });
    Route::get('/irpf/{cliente_id}/assets', 'AssetsController@show');
    Route::apiResource('irpf/assets', 'AssetsController')->except('show');

    Route::apiResource('clientes', 'ClienteController')->except('update');
    Route::get('cliente', 'ClienteController@getClienteByToken');
    Route::get('cliente/{cliente}/token', 'ClienteController@getTokenByCliente');

    Route::apiResource('cliente-residencia', 'ClienteResidenciaController')->only('store');
    Route::get('cliente-residencia/especialidades', 'ClienteResidenciaController@especialidades');
    Route::put('cliente-residencia/{id}', 'ClienteResidenciaController@update');


    Route::apiResource('empresa-pre-cadastros', 'EmpresaPreCadastroController');

    Route::post('contatos/confirm/{contactable_type}/{contactable_id}', 'ContatoController@confirm')->name('contatos.confirm');
    Route::apiResource('contatos', 'ContatoController')->except(['show']);
    Route::get('contatos/{contactable_type}/{contactable_id}', 'ContatoController@index')->name('contatos.index');

    // cartao credito



    Route::prefix('cartaoCredito')->group(function () {
        Route::get('/', 'CartaoCreditoController@index');
        Route::put('/{id}', 'CartaoCreditoController@update');
        Route::delete('/{id}', 'CartaoCreditoController@destroy');
        Route::post('/', 'CartaoCreditoController@store');
        Route::get('/relatorio', 'CartaoCreditoController@relatorioCartaoCredito');
    });

    Route::apiResource('motivo_retencao','MotivoRetencaoController');

    Route::prefix('retencao')->group(function () {
    Route::put('/{id}', 'RetencaoController@update');
    Route::post('/', 'RetencaoController@store');
    Route::get('/', 'RetencaoController@index');


    Route::get('/{id}', 'RetencaoController@show');


        Route::get('relatorio', 'RetencaoController@relatorio');

        
    });




    // Empresas
    Route::prefix('empresas')->group(function () {
        Route::get('/{id}/email-envio', 'EmpresaController@getEmailEnvio');
        Route::get('/{id}/required-guides', 'EmpresaController@getRequiredGuidesByEmpresa');
        Route::post('/{id}/required-guides', 'EmpresaController@setRequiredGuidesByEmpresa');
        Route::post('/{empresa_id}/cancel', 'EmpresaPosCadastroController@cancel');
        Route::put('/{empresa_id}/pularAcesso', 'EmpresaPosCadastroController@pularAcesso');

Route::post('/empresa-status-ativar','EmpresaController@reativarEmpresaStatus');

        // socios
        Route::get('/{id}/socios', 'EmpresaController@socios');
        Route::patch('/{id}/socios', 'EmpresaSociosUpdateController@update');

        // prolabore
        Route::get('{id}/prolabore', 'ProlaboreController@index');
        Route::post('{id}/prolabore', 'ProlaboreController@store');
        Route::post('{id}/prolabore/liberacao', 'ProlaboreController@liberarEmpresa');
        Route::delete('{id}/prolabore/liberacao', 'ProlaboreController@estornarLiberacao');
        Route::get('liberacao-prolabore', 'ProlaboreController@listaLiberacao');

        Route::apiResource('{empresa_id}/acessos-prefeituras', 'Empresa\AcessoPrefeituraController')
            ->only(['store', 'update', 'index']);

        Route::patch('{id}/congelamento', 'EmpresaController@congelamento');
        Route::patch('{id}/desativar', 'EmpresaController@desativar');
        Route::post('{id}/acesso-nfse', 'EmpresaController@storeAcessoNfse');

        Route::post('{id}/add-arquivo', 'EmpresaController@addArquivo');
        Route::get('{id}/carteiras', 'EmpresaController@getCarteiras');
        Route::post('{id}/add-carteira', 'EmpresaController@addCarteira');
        Route::post('{id}/add-carteiras', 'EmpresaController@addCarteiras');
        Route::post('{id}/remove-carteira', 'EmpresaController@removeCarteira');

        Route::get('timeempresaforstatus', 'EmpresaController@TimeTempoEmpresas');
        Route::get('relatorio/data-ativacao', 'EmpresaController@EmpresaDataAtiva');
        Route::get('relatorio/relatorio-ddd', 'EmpresaController@relatorioDDD');

        



        // ALVARAS
        Route::apiResource('alvaras', 'Empresa\AlvarasController');
        Route::apiResource('alvarasSanitario', 'Empresa\AlvarasSanitarioController');
        Route::apiResource('taxas', 'Empresa\TaxasController');

        Route::apiResource('bombeiro', 'Empresa\BombeiroController');


        Route::post('alvaras/relatorio', 'Empresa\AlvarasController@relatorio');



        // Empresa Pós Cadastro
        Route::get('poscadastro', 'EmpresaPosCadastroController@index')->name('empresa-poscadastro.index');
        Route::get('poscadastro/relatorio', 'EmpresaPosCadastroController@relatorioPosCadastro');


        Route::get('poscadastro/status', 'EmpresaPosCadastroController@status')->name('empresa-poscadastro.status');
        Route::get('{empresa}/poscadastro', 'EmpresaPosCadastroController@show')->name('empresa-poscadastro.show');
        Route::put('{empresa}/poscadastro', 'EmpresaPosCadastroController@update')->name('empresa-poscadastro.update');
        Route::get('{empresa}/poscadastro/steps', 'EmpresaPosCadastroController@checkStep')->name('empresa-poscadastro.check');
        Route::get('{empresa}/poscadastro/steps/{steps}', 'EmpresaPosCadastroController@getDataSteps');
        Route::get('{empresa}/poscadastro/files', 'EmpresaPosCadastroSendFilesController@files')->name('empresa-poscadastro.files');
        Route::post('{empresa}/poscadastro/attach-files', 'EmpresaPosCadastroSendFilesController@attach')->name('empresa-poscadastro.attach-files');
        Route::post('{empresa}/poscadastro/send-files', 'EmpresaPosCadastroSendFilesController@send')->name('empresa-poscadastro.send-files');

        Route::get('{id}/contrato', 'EmpresaController@getEmpresaContrato');
        Route::get('{id}/contrato/check', 'ContratoController@check');

        Route::get('search/{search}', 'EmpresaController@search');
        Route::get('{id}', 'EmpresaController@show');
        Route::post('{id}/tributacao-frequency', 'EmpresaController@changeTribucacaoFrequency');
        Route::get('{id}/tributacao-frequency', 'EmpresaController@getTribucacaoFrequency');

        Route::get('{empresa_id}/history-regime-tributario', 'HistoricoRegimeTributarioController@getByEmpresa');
        Route::post('/status/relatorio', 'EmpresaController@relatorioEmpresas');
    });

    Route::prefix('dashboard')->group(function () {
        Route::get('companies-quantity-stats', 'DashboardController@companiesQuantityStats');
        Route::get('companies-contract-stats', 'DashboardController@companiesContractStats');
        Route::get('sales-quantity-by-month', 'DashboardController@salesQuantityByMonth');
        Route::post('companies-opening-stats', 'DashboardController@companiesOpeningStats');
        Route::get('companies-opening-time-by-step', 'DashboardController@timePerStepInOpeningCompanies');
        Route::get('cash-flow', 'DashboardController@cashFlow');
        Route::get('cash-flow-forecast', 'DashboardController@cashFlowForecast');
        Route::get('monthly-taxes-stats', 'DashboardController@monthlyTaxesStats');
        Route::get('monthly-payments-stats', 'DashboardController@monthlyPaymentsStats');
        Route::get('payments-defaulters', 'DashboardController@paymentDefaulter');
        Route::get('awaiting-contract-signature', 'DashboardController@contractsAwaitingSignature');
        Route::get('awaiting-finish-register', 'DashboardController@registerAwaiting');
        Route::get('quantity-alvaras/{id}', 'DashboardController@quantityAlvaras');
        Route::get('quantity-cnpj/{id}', 'DashboardController@quantityCnpj');

        Route::get('quantity-new-companies', 'DashboardController@quantityNewCompanies');
        Route::get('irpf-stats', 'DashboardController@irpfStats');
        Route::get('companies-quantity-for-carteiras', 'DashboardController@quantityCompaniesForCarteira');

        // Route::get('companies-opening-stats-history','DashboardController@companiesOpeningStatsHistory');




        Route::post('logsForUsers', 'Empresa\ActivityLogController@LogsForUsers');

        Route::get('pegartipo', 'Empresa\ActivityLogController@pegarSubjectType');
    });

    Route::get('motivos-desativar-empresas', 'EmpresaController@motivosDesativar');

    Route::apiResource('empresas', 'EmpresaController')->except('delete');

    Route::apiResource('contratos', 'ContratoController')->only('store');

    // Contas Bancárias
    Route::apiResource('contas-bancarias', 'ContaBancariaController')->except(['index, show']);
    Route::get('contas-bancarias/{owner_type}/{owner_id}', 'ContaBancariaController@index')->name('contas-bancarias.index');

    // CRMs
    Route::apiResource('crms', 'CrmController')->except(['index', 'destroy']);
    Route::get('crms/{owner_type}/{owner_id}', 'CrmController@index')->name('crms.index');

    // Endereços
    Route::apiResource('enderecos', 'EnderecoController')->except(['index', 'destroy']);
    Route::get('enderecos/{addressable_type}/{addressable_id}', 'EnderecoController@index')->name('enderecos.index');

    // Bancos
    Route::get('bancos', 'BancoController@index');
    Route::get('bancos/{search}', 'BancoController@search');

    // ORDEM DE SERVICO
    Route::prefix('ordem-servico')->namespace('OrdemServico')->group(function () {
        // ordens servico base
        Route::apiResource('os-base', 'OrdemServicoBaseController')->only(['index', 'store', 'destroy']);

        // atividade
        Route::post('atividade/iniciar', 'OrdemServicoController@iniciarAtividade');
        Route::post('atividade/finalizar', 'OrdemServicoController@finalizarAtividade');
        Route::post('atividade/store', 'OrdemServicoController@storeAtividadeArquivo');
        Route::post('atividade/arquivo/estornar', 'OrdemServicoController@estornarArquivo');
        Route::post('enviar-email', 'OrdemServicoController@enviarEmail');
        Route::get('list/{empresa_id}', 'OrdemServicoController@listByEmpresa');
    });
    Route::resource('ordem-servico', 'OrdemServico\OrdemServicoController');

    // SIMULADOR
    Route::prefix('simulator')->group(function () {
        Route::get('pgbl/{customer_id}', 'SimuladorController@showPgbl');
    });

    // FILES
    Route::prefix('files')->group(function () {
        // FILE
        Route::get('download/{file_id}', 'FileController@download');
        Route::post('update-file', 'FileController@updateFile');
        Route::delete('delete-file', 'FileController@deleteFile');

        // DIRECTORY
        Route::get('{empresa_id}', 'FileController@show');
        Route::get('/', 'FileController@index');
        Route::post('create-diretory', 'FileController@createDiretory');
        Route::delete('delete-diretory', 'FileController@deleteDiretory');
    });

    Route::apiResource('planos', 'PlanosController')->only('index');

    // IES
    Route::apiResource('ies', 'IesController')->only(['index', 'store']);

    // Course
    Route::prefix('courses')->group(function () {
        Route::get('/', 'CourseController@index');
        Route::get('cliente-course/{cliente_id}', 'ClienteCourseController@show');
        Route::get('cliente-course', 'ClienteCourseController@index');
        Route::post('confirm/{cliente_id}', 'ClienteCourseController@confirm');
        Route::post('cliente-course/inactivate-course/{id}', 'ClienteCourseController@inactivateCourse');
        Route::post('{id?}', 'CourseController@store');
    });

    // Especialidade
    Route::get('especialidades', 'EspecialidadeController')->name('especialidades.index');

    // Estado Civil
    Route::get('estados-civis', 'EstadoCivilController')->name('estados-civis.index');

    // Profissão
    Route::get('profissoes', 'ProfissaoController')->name('profissoes.index');

    // Qualificacão
    Route::get('qualificacoes', 'QualificacaoController')->name('qualificacoes.index');

    // Route::post('email', 'MailController@store');

    // FATURAMENTOS
    Route::prefix('faturamento')->group(function () {
        Route::get('{empresa_id}', 'FaturamentoController@show');
        Route::get('/renda/{empresa_id}', 'FaturamentoController@showRenda');
        Route::get('/liquido-impostos/{empresa_id}', 'FaturamentoController@liquidoImpostos');
    });

    // DECLARACOES PDF
    Route::prefix('declaracao')->group(function () {
        Route::match(['GET', 'POST'], 'faturamento', 'FaturamentoController@declaracaoFaturamentoPdf');
        Route::match(['GET', 'POST'], 'renda', 'FaturamentoController@declaracaoRendaPdf');
    });

    // FAQ
    Route::apiResource('faq', 'FaqController')->only('index');

    // NFSE
    Route::post('nfse/emitir', 'NfseController@emitByInvoiceId');
    Route::post('nfse/imitirRejeitadas', 'NfseController@imitirRejeitadas');

    
    Route::get('nfse/refresh/{id_integracao}', 'NfseController@refreshStatus');
    Route::apiResource('nfse', 'NfseController')->only(['index', 'destroy']);

    // LIBERACAO DE GUIAS
    Route::prefix('guias')->group(function () {
        Route::patch('libera-envios', 'GuiaLiberacaoController@eligesToSend');
        Route::post('send', 'GuiaLiberacaoController@sendEmail');
        Route::post('send-all', 'GuiaLiberacaoController@sendAllEligible');
        Route::post('store', 'GuiaLiberacaoController@store');
        Route::get('empresas', 'GuiaLiberacaoController@getEmpresasGuias');
        Route::put('estorno/{id}', 'GuiaLiberacaoController@estornoGuia');
        Route::get('tipos', 'GuiaLiberacaoController@getTipos');
        Route::get('data-padrao', 'GuiaLiberacaoController@getDataPadrao');
        Route::get('tipos', 'GuiaLiberacaoController@getTipos');
        Route::post('upload', 'GuiaLiberacaoController@uploadGuias');
        Route::post('uploadDevelop', 'GuiaLiberacaoController@uploadGuiasDevelop');

        Route::get('nao-processadas', 'GuiaLiberacaoController@guiasNaoProcessadas');
        Route::delete('nao-processadas/{id}', 'GuiaLiberacaoController@deleteGuiaNaoProcessada');
        Route::post('change-liberacao', 'GuiaLiberacaoController@changeLiberacao');
        Route::get('datas-padrao', 'GuiasDatasPadraoController@index');
        Route::patch('datas-padrao', 'GuiasDatasPadraoController@update');
        Route::get('upload-report', 'GuiaLiberacaoController@getUploadStatus');
        Route::get('{empresa_id}', 'GuiaLiberacaoController@show');
        Route::get('relatorio/fechamento', 'GuiaLiberacaoController@relatorioGuias');


        
    });

    // CERTIDÕES NEGATIVAS DE DÉBITOS
    Route::prefix('certidao-negativa')->group(function () {
        Route::get('/', 'CertidaoNegativaController@index');
        Route::post('/', 'CertidaoNegativaController@store');
        Route::post('/upload', 'CertidaoNegativaController@upload');
        Route::get('/nao-processadas', 'CertidaoNegativaController@naoProcessadas');
        Route::delete('/nao-processadas/{id}', 'CertidaoNegativaController@deleteNaoProcessada');
        Route::get('/empresa/{id}', 'CertidaoNegativaController@getCertidoesByEmpresa');
    });

    // RECEITAS
    Route::prefix('receitas')->group(function () {
        Route::get('/', 'ReceitaController@getReceitas');
        Route::post('/', 'ReceitaController@createReceita');
        Route::put('/{id}', 'ReceitaController@editReceita');
        Route::delete('/{id}', 'ReceitaController@deleteReceita');
        Route::post('upload', 'ReceitaController@upload');
        Route::post('divisao', 'ReceitaController@divisao');
        Route::get('nao-processadas', 'ReceitaController@receitasNaoProcessadas');
        Route::delete('nao-processadas/{id}', 'ReceitaController@deleteReceitaNaoProcessada');
        Route::get('relatorio', 'ReceitaController@generateReport');
        Route::put('/{id}/lancamento', 'ReceitaController@lancamentoReceita');

        Route::get('all-yearly/{customer_id}', 'ReceitaController@getReceitasByCustomer');

        Route::put('holerite/{id}', 'ReceitaController@updateHolerite');
        Route::post('holerite', 'ReceitaController@storeHolerite');
        Route::post('holerite/from-upload', 'ReceitaController@moveUploadToHolerite');

        Route::post('uploadDevelop', 'ReceitaController@uploadReceitasDevelop');
    });

    Route::prefix('carteiras')->group(function () {
        Route::get('/', 'CarteiraController@index');
        Route::get('/{id}', 'CarteiraController@show');
        Route::post('/', 'CarteiraController@store');
        Route::put('/{id}', 'CarteiraController@update');
        Route::delete('/{id}', 'CarteiraController@destroy');
        Route::get('/{setor}/setor', 'CarteiraController@getBySetor');
        Route::get('/{setor}/like', 'CarteiraController@getByLikeSetor');
    });

    // Auxiliar API
    Route::prefix('auxiliar')->group(function () {
        Route::get('cnpj/', 'ApiAuxiliarController@consultaCnpj');
        Route::get('cep/{cep}', 'ApiAuxiliarController@consultaCep');
        Route::get('homologacao/{codigoIbge}', 'ApiAuxiliarController@consultaHomologacaoNfse');
    });

    Route::apiResource('estados', 'EstadoController')->only(['index', 'show']);

    Route::get('viabilidade/documentos-base', 'DocumentosViabilidadeBaseController');
    Route::apiResource('viabilidade', 'ViabilidadeMunicipalController');

    // ARQUIVOS
    Route::apiResource('arquivos', 'ArquivoController');
    // UPLOAD PARA MODEL UPLOAD
    Route::post('arquivos/upload', 'UploadController@store');
    Route::get('uploads/{type}', 'UploadController@getByType');

    Route::post('arquivos/send-by-email', 'ArquivoController@sendFilesByEmail');

    Route::get('assinatura-contrato/{empresaId}', 'AssinaturaContratoController@index');
    Route::put('assinatura-contrato', 'AssinaturaContratoController@update');
    Route::get('assinatura-contrato/{empresaId}/reenviar', 'AssinaturaContratoController@reenviar');

    Route::get('arquivos/{arquivo}/download', 'ArquivoDownloadController')
        ->name('arquivos.download');

    Route::get('arquivos/{arquivo}/open', 'ArquivoOpenController')
        ->name('arquivos.open');

    // COMENTARIOS
    Route::apiResource('comentarios', 'ComentarioController')->except(['index', 'show']);
    Route::get('comentarios/{commentable_type}/{commentable_id}', 'ComentarioController@index')->name('comentarios.index');

    //JUNTA COMERCIAL
    Route::apiResource('junta-comercial', 'JuntaComercialController');
    Route::get('junta-comercial/estado/{uf}', 'JuntaComercialByUfController')->name('juntaComercial.byUf');

    // LABELS
    Route::apiResource('labels', 'LabelsController')->only(['store', 'show', 'update']);

    // Reports
    Route::prefix('reports')->group(function () {
        Route::get('1', 'Relatorios\ExportAcessosCarteiraController');
        Route::get('irpf/clientes', 'Relatorios\ExportClientesIrpfController');
        Route::get('clientes', 'Relatorios\ExportClientesController');
    });

    Route::get('required/guides', 'RequiredGuidesController@index');

    Route::get('document/cpf/{document}', 'CpfCnpjController@getByCpf');
    Route::get('document/cnpj/{document}', 'CpfCnpjController@getByCnpj');

    Route::prefix('schedule-job')->group(function () {
        Route::get('', 'ScheduleController@index');
        Route::get('{slug}', 'ScheduleController@getBySlug');
        Route::put('activate/{slug}', 'ScheduleController@activeBySlug');
        Route::put('deactivate/{slug}', 'ScheduleController@deactivateBySlug');
    });

    Route::apiResource('invites', 'InviteController')->only('destroy');
    Route::get('invites/customer', 'InviteController@customerInvites');
    Route::post('invites', 'InviteController@index');
    Route::post(' invites/relatorio', 'InviteController@relatorioInvite');




    Route::prefix('message')->group(function () {
        Route::post('/teste', 'WhatsappMessageController@messagemTeste');
    });
});

// UNPROTECTED ROUTES (DOESN'T REQUIRES JWT/AUTHENTICATION)
Route::get('teste', 'ServerController@httpCheck');

Route::post('customer-indication', 'InviteController@customerIndication');
