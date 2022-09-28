@component('mail::message')
{{-- Greeting --}}
@if (! empty($greeting))
# {{ $greeting }}
@else
# @lang('Olá!')
@endif

<p>
    Já pensou em reduzir o valor do seu imposto de renda a pagar ou aumentar sua restituição de imposto de renda?
    Fizemos uma análise da sua renda anual conforme os holerites que você nos enviou e aquilo que você declara através
    da sua empresa. Temos duas maneiras de você usar melhor seu imposto de renda:
</p>

<p>
    <strong>1) Economizando.</strong><br>
    A aplicação em Previdência Privada pode reduzir seu imposto de renda a pagar ou restituir impostos.
    Na modalidade PGBL você pode reduzir a base de cálculo em até 12%, isso significa que se você recebeu no ano
    100 mil reais por Pessoa Física você pode aplicar 12 mil reais e o novo imposto será calculado em cima de 88 mil reais.
    Para ter este benefício é importante deixar o dinheiro aplicado por um longo prazo (acima de 10 anos).
</p>

<p>
    Para simplificar já fizemos os cálculos para você de quanto precisa aplicar e quanto poderá economizar:
</p>

<table style="width:100%; text-align: left" class="table">
    <tr>
        <th style="width: 20%;"></th>
        <th>Renda</th>
        <th style="width: 35% ;">IR a pagar Abril 2020</th>
    </tr>
    <tr>
        <td style="word-wrap:break-word"> <strong style="word-wrap:break-word">Sem PGBL</strong> </td>
        <td>R${{formata_moeda($simulacao['renda_anual_s'])}}</td>
        <td>R${{formata_moeda($simulacao['pagar_s'])}}</td>
    </tr>
    <tr>
        <td class="text-secondary" style="word-wrap:break-word"> <strong style="word-wrap:break-word">Com PGBL</strong> </td>
        <td>R${{formata_moeda($simulacao['renda_anual_c'])}}</td>
        <td>R${{formata_moeda($simulacao['pagar_c'])}}</td>
    </tr>
</table>

<table style="width:100%; text-align: center" class="table">
    <tr>
        <th>Valor Aplicado</th>
        <th>Economia</th>
    </tr>
    <tr>
        <td>R${{formata_moeda($simulacao['valor_aplicado'])}}</td>
        <td class="text-secondary">R${{formata_moeda($simulacao['economia'])}}</td>
    </tr>
</table>

<p>
    <strong>Como fazer:</strong> <br>
    Procure a instituição financeira de sua confiança (bancos, corretoras, etc), informe que você quer aplicar o valor
    acima descrito na:
    <strong>Previdência Privada – PGBL – Regressiva Definitiva. Isto precisa ser feito até dia 20/12/2019.</strong>
</p>

<p>
    <strong>2) Doando.</strong><br>
    Este ano, nós, da Medb, estamos realizando um projeto social para doar parte do imposto de renda para
    hospitais. Cada ano será um hospital diferente e este ano escolhemos o Hospital Pequeno Príncipe – Curitiba PR.
    Fizemos um levantamento com os nossos clientes que podem doar parte do IR, e você é um deles! O valor doado é abatido
    do valor a pagar do imposto de renda (ao invés de ir para o governo, vai para o hospital).
</p>

<p>
    Segue exemplo de quanto você pode destinar do seu imposto:
</p>

<table style="width:100%; text-align: center" class="table">
    <tr>
        <th>Valor a doar</th>
        <th>IR a pagar Abril 2020</th>
    </tr>
    <tr>
        <td>R${{formata_moeda(($simulacao['devido_s'] * 0.06)}}</td>
        <td>R${{formata_moeda($simulacao['pagar_s'] - (($simulacao['devido_s'] * 6) / 100))}}</td>
    </tr>
</table>

<p>
    <strong>Como fazer:</strong> <br>
    Acesse o site clicando <a href="https://doepequenoprincipe.org.br/impostoderenda/faca-sua-doacao/#doacao-form">neste link</a>.
    <br>
    Preencha o formulário para gerar o boleto no valor da doação informado acima
    e envie o comprovante de pagamento para holerite@medb.com.br.
</p>

<p>
    Com essas dicas você poderá economizar e saber exatamente para onde está indo seus impostos.
</p>

<p>
    Gostou das dicas? Então corre que só tem alguns dias!!!
</p>

<br>

{{-- Salutation --}}
<p>
    <strong>Medb - cuidando do seu futuro!</strong>
</p>

@endcomponent
