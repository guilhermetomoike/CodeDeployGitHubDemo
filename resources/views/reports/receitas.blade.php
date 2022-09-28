<h1>Relatório de Receitas</h1>
<table style="border-collapse: collapse; border: 1px solid black; width: 100%">
    <thead>
    <tr>
        <th style="border: 1px solid black;">Empresa</th>
        <th style="border: 1px solid black;">RAZÃO SOCIAL</th>
        <th style="border: 1px solid black;">Sócio</th>
        <th style="border: 1px solid black;">{{ $data['competenciaAnterior'] }}</th>
        <th style="border: 1px solid black;">{{ $data['competenciaAtual'] }}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data['items'] as $receita)
        <tr>
            <td style="border: 1px solid black; text-align: center;">{{ $receita->empresa_id }}
                {{$receita->empresa->congelada ? '*' : ''}}</td>
            <td style="border: 1px solid black; text-align: center;">{{ $receita->empresa->razao_social ?? null }}</td>
            <td style="border: 1px solid black; text-align: center;">{{ $receita->cliente->getFirstName() }}</td>
            <td style="border: 1px solid black; text-align: center;">{{ $receita->prolabore_anterior }}</td>
            <td style="border: 1px solid black; text-align: center;">{{ $receita->prolabore }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
