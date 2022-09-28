<html lang="pt-br">

<head>
    <title>Dociê IRPF</title>
</head>

<body>

<p style="margin-top:80px"></p>
<h2 style="text-align:center;">Dociê IRPF</h2>

<p style="text-align:center;text-align:justify;text-indent:40px;line-height:24px;">
    <strong>Empresas: </strong>{{ $customer['companies'] }}
</p>
<p style="text-align:center;text-align:justify;text-indent:40px;line-height:24px;">
    <strong>Nome: </strong>{{ $customer['name'] }}
</p>
<p style="text-align:center;text-align:justify;text-indent:40px;line-height:24px;">
    <strong>CPF: </strong>{{ $customer['cpf'] }}
</p>

@foreach ($respostas as $resposta)
    <p style="text-align:center;text-align:justify;text-indent:40px;line-height:24px;margin-top:30px;"><strong>{{ $resposta['pergunta'] }}</strong></p>
    <p style="text-align:center;text-align:justify;text-indent:40px;line-height:24px;">{{ $resposta['resposta'] ? 'Sim' : 'Não' }}</p>
@endforeach

</body>

</html>
