<html lang="pt-br">
<head>
    <title>Declaracao de Faturamento</title>
</head>

<style>
    body {
        font-family: Arial;
        color: black;
        font-size: 11pt;
    }

    p {
        text-align: justify;
        margin-bottom: 4pt;
        margin-top: 0pt;
    }

    table {
        font-size: 9pt;
        line-height: 1.2;
        margin-top: 2pt;
        margin-bottom: 5pt;
        border-collapse: collapse;
    }

    thead {
        font-weight: bold;
        vertical-align: bottom;
    }

    tfoot {
        font-weight: bold;
        vertical-align: top;
    }

    thead td {
        font-weight: bold;
    }

    tfoot td {
        font-weight: bold;
    }

    th {
        font-weight: bold;
        vertical-align: top;
        padding-left: 2mm;
        padding-right: 2mm;
        padding-top: 0.5mm;
        padding-bottom: 0.5mm;
    }

    td {
        padding-left: 2mm;
        vertical-align: top;
        padding-right: 2mm;
        padding-top: 0.5mm;
        padding-bottom: 0.5mm;
    }

    th p {
        margin: 0pt;
    }

    td p {
        margin: 0pt;
    }

    table.widecells td {
        padding-left: 5mm;
        padding-right: 5mm;
    }

    table.tallcells td {
        padding-top: 3mm;
        padding-bottom: 3mm;
    }

    hr {
        width: 70%;
        height: 1px;
        text-align: center;
        color: #999999;
        margin-top: 8pt;
        margin-bottom: 8pt;
    }

    a {
        color: #000066;
        font-style: normal;
        text-decoration: underline;
        font-weight: normal;
    }

    pre {
        font-size: 9pt;
        margin-top: 5pt;
        margin-bottom: 5pt;
    }

    h1 {
        font-weight: normal;
        font-size: 26pt;
        color: #000066;
        margin-top: 18pt;
        margin-bottom: 6pt;
        border-top: 0.075cm solid #000000;
        border-bottom: 0.075cm solid #000000;
        page-break-after: avoid;
    }

    h3 {
        font-weight: normal;
        font-size: 26pt;
        color: #000000;
        margin-top: 0pt;
        margin-bottom: 6pt;
        border-top: 0;
        border-bottom: 0;
        page-break-after: avoid;
    }

    h4 {
        font-size: 13pt;
        color: #9f2b1e;

        margin-top: 10pt;
        margin-bottom: 7pt;
        font-variant: small-caps;
        page-break-after: avoid;
    }

    h5 {
        font-weight: bold;
        font-style: italic;
        font-size: 11pt;
        color: #000044;
        margin-top: 8pt;
        margin-bottom: 4pt;
        page-break-after: avoid;
    }

    h6 {
        font-weight: bold;
        font-size: 9.5pt;
        color: #333333;
        margin-top: 6pt;
        page-break-after: avoid;
    }

    .bpmTopic tbody tr:nth-child(even) {
        background-color: #f5f8f5;
    }

    .bpmTopicC tbody tr:nth-child(even) {
        background-color: #f5f8f5;
    }

    .bpmNoLines tbody tr:nth-child(even) {
        background-color: #f5f8f5;
    }

    .bpmNoLinesC tbody tr:nth-child(even) {
        background-color: #f5f8f5;
    }

    .bpmTopnTail tbody tr:nth-child(even) {
        background-color: #f5f8f5;
    }

    .bpmTopnTailC tbody tr:nth-child(even) {
        background-color: #f5f8f5;
    }

    .evenrow td,
    .evenrow th {
        background-color: #f5f8f5;
    }

    .oddrow td,
    .oddrow th {
        background-color: #e3ece4;
    }

    .bpmTopicC td,
    .bpmTopicC td p {
        text-align: center;
    }

    .bpmNoLinesC td,
    .bpmNoLinesC td p {
        text-align: center;
    }

    .bpmClearC td,
    .bpmClearC td p {
        text-align: center;
    }

    .bpmTopnTailC td,
    .bpmTopnTailC td p {
        text-align: center;
    }

    .bpmTopnTailClearC td,
    .bpmTopnTailClearC td p {
        text-align: center;
    }

    .bpmTopic td,
    .bpmTopic th {
        border-top: 1px solid #ffffff;
    }

    .bpmTopicC td,
    .bpmTopicC th {
        border-top: 1px solid #ffffff;
    }

    .bpmTopnTail td,
    .bpmTopnTail th {
        border-top: 1px solid #ffffff;
    }

    .bpmTopnTailC td,
    .bpmTopnTailC th {
        border-top: 1px solid #ffffff;
    }
</style>
<body>

<div style="text-align:center;">
    <img src="{{ url('storage/logo_medb_dark.jpg') }}" alt="logo" width="242">
</div>

<p style="margin-top:80px"></p>

<h2 style="text-align:center;">Declaracao de Faturamento</h2>

<p style="margin-top:80px"></p>

<p style="text-align:center;text-align:justify;text-indent:40px;line-height:24px;">
    <strong>William Andreazi Colombari</strong>, brasileiro, contador, portador do CPF sob nº 043.064.199-08 e CRC-PR
    063958/O-0,
    com escritório de Contabilidade na Cidade de Maringá - PR, à Av. Pedro Taques, 294, sala 904,
    <strong>DECLARA</strong> para os
    devidos fins de direito e a quem interessar possa, que a <strong>{{ $empresa->razao_social }}</strong>, devidamente
    inscrita
    no
    CNPJ sob nº {{ $empresa->cnpj }}, estabelecida à {{ $endereco->logradouro }}, {{ $endereco->numero }}
    , {{ $endereco->bairro }}, {{ $endereco->cidade }} - {{ $endereco->uf }},
    tem a seguinte <strong>DECLARAÇÃO DE FATURAMENTO.</strong>
</p>

<table style="margin:auto;" class="layout">

    <tr>
        <td style="padding-top:25px"></td>
    </tr>

    <tr style="background-color:#E0E0E0">
        <td>Mês/Ano</td>
        <td style="padding-right:150px"></td>
        <td width="55">Total</td>
    </tr>

    <tr><td style="padding-top:10px"></td></tr>

    @foreach ($faturamentos as $mes)
        <tr>
            <td> {{ date_to_format($mes->mes, 'm/Y') }}</td>
            <td style="padding-right:150px"></td>
            <td>R$ {{ formata_moeda($mes->faturamento) }} </td>
        </tr>

    @endforeach

    <tr style="background-color:#E0E0E0">
        <td>Total</td>
        <td style="padding-right:150px"></td>
        <td>R$ {{ formata_moeda($faturamentos->sum('faturamento')) }}</td>
    </tr>

    <tr><td style="padding-top:50px"></td></tr>
</table>

<div style="font-size:9pt;margin-bottom:20px;text-align: center">
    {{ $endereco->cidade }}, {{ ucfirst(date_for_human()) }}.
</div>

<p style="padding-top:80px"></p>

<div style="text-align:center;">
    <img src="{{ storage_path('app/private/assinatura_william.jpg') }}" width="242" alt="assinatura">
</div>
</body>
</html>
