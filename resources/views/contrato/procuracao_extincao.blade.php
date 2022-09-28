<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Procuração Constituição</title>

    <style>
        body {
            font-size: 12pt;
        }

        @page {
            margin: 1in;
        }

        h1, h2, h3 {
            margin: 0;
        }

        h1 {
            margin-bottom: 36px;
            font-size: 12pt;
            font-weight: bold;
            text-align: center;
        }

        h2 {
            margin-bottom: 24px;
            font-size: 12pt;
            font-weight: bold;
        }

        h3 {
            margin-bottom: 24px;
            font-size: 12pt;
            font-weight: bold;
            font-style: italic;
        }

        p {
            text-align: justify;
        }
    </style>
</head>
<body>
    <main>
        <h1>PROCURAÇÃO</h1>

        <h2>OUTORGANTE:</h2>
        <p>
            <strong>{{ $socioAdministrador->nome_completo }}</strong>,
            {{ $socioAdministrador->nacionalidade }},
            {{ $socioAdministrador->estado_civil()->first()->nome }},
            {{ $socioAdministrador->profissao()->first()->nome }},
            @if (!empty($socioAdministrador->crm))
                inscrita no CRM/PR nº {{ $socioAdministrador->crm }},
            @endif
            portador(a) da Cédula de Identidade RG nº {{ $socioAdministrador->rg }},
            SSP/{{ $socioAdministrador->endereco->uf }},
            inscrito(a) no CPF sob nº {{ $socioAdministrador->cpf }},
            residente e domiciliado(a) na {{ $socioAdministrador->endereco->logradouro }},
            nº {{ $socioAdministrador->endereco->numero }},
            @if (!empty($socioAdministrador->endereco->complemento))
                {{ $socioAdministrador->endereco->complemento }},
            @endif
            {{ $socioAdministrador->endereco->bairro }},
            {{ $socioAdministrador->endereco->cidade }},
            {{ $socioAdministrador->endereco->uf }},
            {{ $socioAdministrador->endereco->cep }}.
        </p>

        <br />

        <h2>OUTORGADO:</h2>
        <p><strong>WILLIAM ANDREAZI COLOMBARI</strong>, brasileiro, solteiro, contador, inscrito no CRC/PR 063958/O-0, portador da Cédula de Identidade RG nº 8.439.025-9 SSP/PR, inscrito no CPF sob nº 043.064.199-08, endereço: Avenida Pedro Taques, 294, Sala 904 Torre Sul, Zona Armazém, Maringá/PR, CEP 87.030-008, e-mail: contato@medcontabil.com.br  e telefone 44 - 3031-1015.</p>

        <br />

        <h2>PODERES:</h2>
        <h3>Para extinção:</h3>
        <p>
            Por este instrumento, o(a)(s) outorgante(s) constitui(em) o outorgado como procurador, a quem confere(m) poderes específicos
            para assinar requerimentos/capa de processo e ato de extinção da sociedade {{ $empresa->razao_social }},
            registrada na junta comercial do estado do {{ $empresa->endereco->uf }} sob o NIRE 000000000
            e inscrita no CNPJ nº. {{ $empresa->cnpj }},
            neste ato representada por
            {{ $socioAdministrador->nome_completo }},
            {{ $socioAdministrador->nacionalidade }},
            {{ $socioAdministrador->estado_civil()->first()->nome }},
            {{ $socioAdministrador->profissao()->first()->nome }},
            inscrita no CRM/PR nº {{ $socioAdministrador->crm }},
            portador(a) da Cédula de Identidade RG nº {{ $socioAdministrador->rg }},
            SSP/{{ $socioAdministrador->endereco->uf }},
            inscrito(a) no CPF sob nº {{ $socioAdministrador->cpf }},
            residente e domiciliado(a) na {{ $socioAdministrador->endereco->logradouro }},
            nº {{ $socioAdministrador->endereco->numero }},
            @if (!empty($socioAdministrador->endereco->complemento))
                {{ $socioAdministrador->endereco->complemento }},
            @endif
            {{ $socioAdministrador->endereco->bairro }},
            {{ $socioAdministrador->endereco->cidade }},
            {{ $socioAdministrador->endereco->uf }},
            {{ $socioAdministrador->endereco->cep }}.
            ficando a outorgante, dentro dos limites legais, responsável pelo ativo e passivo da sociedade, pela guarda dos livros mercantis,
            e pela assinatura de todos os documentos necessários, praticados com o uso de certificação digital, a ser(em) apresentado(s)
            para arquivamento perante a Junta Comercial do Estado do {{ $empresa->endereco->uf }},
            vedado o substabelecimento a terceiros dos poderes ora conferidos.
        </p>

        <br />

        <p>{{ $socioAdministrador->endereco->cidade }} - {{ $socioAdministrador->endereco->uf }}, {{ date('d/m/Y') }}</p>
        <p>{{ $socioAdministrador->nome_completo }}</p>
    </main>
</body>
</html>
