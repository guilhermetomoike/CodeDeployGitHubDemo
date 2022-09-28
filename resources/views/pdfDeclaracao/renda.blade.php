<html lang="pt-br">
<head>
    <title>Declaracao de Renda</title>
</head>

<body>

<div style="text-align:center;">
    <img src="{{ url('storage/logo_medb_dark.jpg') }}" alt="logo" width="242">
</div>

<p style="margin-top:80px"></p>

<h2 style="text-align:center;">Declaracao de Renda</h2>

<p style="margin-top:80px"></p>

<p style="text-align:center;text-align:justify;text-indent:40px;line-height:24px;">
    <strong>William Andreazi Colombari</strong>, brasileiro, contador, portador do CPF sob nº 043.064.199-08
    e CRC-PR 063958/O-0, com escritório de Contabilidade na Cidade de Maringá - PR., à Av. Pedro Taques,
    294, sala 904, <strong>DECLARA</strong> para os devidos fins de direito e a quem interessar possa,
    que <strong> {{ ucwords(strtolower($cliente->nome_completo)) }} </strong>, {{ $cliente->nacionalidade }},
    {{ $profissao ? $profissao->nome : '' }}, residente e domiciliado(a) na {{ $cliente->endereco->logradouro }},
    {{ $cliente->endereco->numero }}, {{ $cliente->endereco->bairro }}, {{ $cliente->endereco->cidade }} - {{ $cliente->endereco->uf }},
    devidamente inscrito(a) no CPF/MF sob o nº {{ $cliente->cpf }},
    recebe a importanciasupra de R$ {{ $renda_media }} ( {{ mb_strtoupper(valorPorExtenso($renda_media)) }} ),
    mensal, Cfe, Registro Contábil, da Empresa {{ $empresa->razao_social }} devidamente inscrito(a) no
    CNPJ sob nº {{ $empresa->cnpj }}.
</p>

<p style="text-align:center;text-align:justify;text-indent:40px;line-height:24px;">
    Para que o presente recibo surta seus efeitos legais e jurídicos, assino-o em 02 (duas) vias de igual teor e forma.
</p>

<table style="margin:auto;" class="layout">
    <tr><td style="padding-top:25px"></td></tr>
    <tr><td style="padding-top:10px"></td></tr>
</table>

<div style="font-size:9pt;margin-bottom:20px;text-align: center">
    {{ $empresa->endereco->cidade }}, {{ ucfirst(date_for_human()) }}.
</div>

<p style="margin-top:80px"></p>

<div style="text-align:center;">
    <img src="{{ storage_path('app/private/assinatura_william.jpg') }}" width="242" alt="assinatura">
</div>

</body>
</html>
