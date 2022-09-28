<div style="width: 100%; padding:0;">
  <img alt=""
    src="http://sistema.grupobcontabil.com.br/sistema/assets/template-email/images/header-email.png"
    style="
    max-width: 100%
    border: 0;
    outline: none;
    text-decoration: none;
    height: auto;
    line-height: 100%;
    ">
</div>
<div style="text-align:left;font-family:Helvetica,Arial,sans-serif;font-size:15px;margin-bottom:0;color:#5F5F5F;line-height:135%; margin-top:15px">
    Por favor, atente-se à este e-mail, poís o mesmo contém em anexo informações referente aos valores solicitados pagamento.
</div>
<br>
<div style="
        text-align:left;
        font-family:Helvetica,Arial,sans-serif;
        font-size:15px;
        margin-bottom:0;
        color:#5F5F5F;
        line-height:135%;
        border: 0.5px solid gray;
        padding: 15px;
        background-color: #f1efef;"
    >
    <div style="text-align: center;">Dados referente ao pagamento</div>
    <div style="text-align: left; margin-top: 10px;"><strong>Hospital São Paulo</strong></div>

    <div style="
        margin-top: 10px;
        display: -ms-flexbox;
        display: -webkit-flex;
        display: flex;
        -webkit-flex-direction: row;
        -ms-flex-direction: row;
        flex-direction: row;
        -webkit-flex-wrap: wrap;
        -ms-flex-wrap: wrap;
        flex-wrap: wrap;
        -webkit-justify-content: space-between;
        -ms-flex-pack: justify;
        justify-content: space-between;
        -webkit-align-content: stretch;
        -ms-flex-line-pack: stretch;
        align-content: stretch;
        -webkit-align-items: flex-start;
        -ms-flex-align: start;
        align-items: flex-start;
        margin: 10px 0;"
    >

        <div style="
            -webkit-order: 0;
            -ms-flex-order: 0;
            order: 0;
            -webkit-flex: 0 1 auto;
            -ms-flex: 0 1 auto;
            flex: 0 1 auto;
            -webkit-align-self: auto;
            -ms-flex-item-align: auto;
            align-self: auto;
            color: #808080;"
        >
            <div style="text-align: left;">
                <span>Remetente:</span>
            </div>
        </div>

        <div style="
            -webkit-order: 0;
            -ms-flex-order: 0;
            order: 0;
            -webkit-flex: 0 1 auto;
            -ms-flex: 0 1 auto;
            flex: 0 1 auto;
            -webkit-align-self: auto;
            -ms-flex-item-align: auto;
            align-self: auto;"
        >
            <div style="text-align: right;">
                <strong>{{$cliente->nome_completo}}</strong>
            </div>
        </div>
    </div>

    <div style="
        display: -ms-flexbox;
        display: -webkit-flex;
        display: flex;
        -webkit-flex-direction: row;
        -ms-flex-direction: row;
        flex-direction: row;
        -webkit-flex-wrap: wrap;
        -ms-flex-wrap: wrap;
        flex-wrap: wrap;
        -webkit-justify-content: space-between;
        -ms-flex-pack: justify;
        justify-content: space-between;
        -webkit-align-content: stretch;
        -ms-flex-line-pack: stretch;
        align-content: stretch;
        -webkit-align-items: flex-start;
        -ms-flex-align: start;
        align-items: flex-start;
        margin: 10px 0;"
    >

        <div style="
            -webkit-order: 0;
            -ms-flex-order: 0;
            order: 0;
            -webkit-flex: 0 1 auto;
            -ms-flex: 0 1 auto;
            flex: 0 1 auto;
            -webkit-align-self: auto;
            -ms-flex-item-align: auto;
            align-self: auto;
            color: #808080;"
        >
            <div style="text-align: left;">
                <span>Consultas:</span>
            </div>
        </div>

        <div style="
            -webkit-order: 0;
            -ms-flex-order: 0;
            order: 0;
            -webkit-flex: 0 1 auto;
            -ms-flex: 0 1 auto;
            flex: 0 1 auto;
            -webkit-align-self: auto;
            -ms-flex-item-align: auto;
            align-self: auto;"
        >
            <div style="text-align: right;">
                <strong>{{$recebimento->atendimentos_realizados}}</strong>
            </div>
        </div>
    </div>
    <div style="
        display: -ms-flexbox;
        display: -webkit-flex;
        display: flex;
        -webkit-flex-direction: row;
        -ms-flex-direction: row;
        flex-direction: row;
        -webkit-flex-wrap: wrap;
        -ms-flex-wrap: wrap;
        flex-wrap: wrap;
        -webkit-justify-content: space-between;
        -ms-flex-pack: justify;
        justify-content: space-between;
        -webkit-align-content: stretch;
        -ms-flex-line-pack: stretch;
        align-content: stretch;
        -webkit-align-items: flex-start;
        -ms-flex-align: start;
        align-items: flex-start;
        margin: 10px 0;"
    >

        <div style="
            -webkit-order: 0;
            -ms-flex-order: 0;
            order: 0;
            -webkit-flex: 0 1 auto;
            -ms-flex: 0 1 auto;
            flex: 0 1 auto;
            -webkit-align-self: auto;
            -ms-flex-item-align: auto;
            align-self: auto;
            color: #808080;"
        >
            <div style="text-align: left;">
                <span>Horas trabalhadas:</span>
            </div>
        </div>

        <div style="
            -webkit-order: 0;
            -ms-flex-order: 0;
            order: 0;
            -webkit-flex: 0 1 auto;
            -ms-flex: 0 1 auto;
            flex: 0 1 auto;
            -webkit-align-self: auto;
            -ms-flex-item-align: auto;
            align-self: auto;"
        >
            <div style="text-align: right;">
                <strong>{{$recebimento->horas_trabalhadas}}</strong>
            </div>
        </div>
    </div>

    <div style="
        display: -ms-flexbox;
        display: -webkit-flex;
        display: flex;
        -webkit-flex-direction: row;
        -ms-flex-direction: row;
        flex-direction: row;
        -webkit-flex-wrap: wrap;
        -ms-flex-wrap: wrap;
        flex-wrap: wrap;
        -webkit-justify-content: space-between;
        -ms-flex-pack: justify;
        justify-content: space-between;
        -webkit-align-content: stretch;
        -ms-flex-line-pack: stretch;
        align-content: stretch;
        -webkit-align-items: flex-start;
        -ms-flex-align: start;
        align-items: flex-start;
        margin: 10px 0;"
    >

        <div style="
            -webkit-order: 0;
            -ms-flex-order: 0;
            order: 0;
            -webkit-flex: 0 1 auto;
            -ms-flex: 0 1 auto;
            flex: 0 1 auto;
            -webkit-align-self: auto;
            -ms-flex-item-align: auto;
            align-self: auto;
            color: #808080;"
        >
            <div style="text-align: left;">
                <span>Data de vencimento:</span>
            </div>
        </div>

        <div style="
            -webkit-order: 0;
            -ms-flex-order: 0;
            order: 0;
            -webkit-flex: 0 1 auto;
            -ms-flex: 0 1 auto;
            flex: 0 1 auto;
            -webkit-align-self: auto;
            -ms-flex-item-align: auto;
            align-self: auto;"
        >
            <div style="text-align: right;">
                <strong>{{ date('d/m/yy', strtotime($recebimento->data_pagamento))}}</strong>
            </div>
        </div>
    </div>

    <div style="
        display: -ms-flexbox;
        display: -webkit-flex;
        display: flex;
        -webkit-flex-direction: row;
        -ms-flex-direction: row;
        flex-direction: row;
        -webkit-flex-wrap: wrap;
        -ms-flex-wrap: wrap;
        flex-wrap: wrap;
        -webkit-justify-content: space-between;
        -ms-flex-pack: justify;
        justify-content: space-between;
        -webkit-align-content: stretch;
        -ms-flex-line-pack: stretch;
        align-content: stretch;
        -webkit-align-items: flex-start;
        -ms-flex-align: start;
        align-items: flex-start;
        margin: 10px 0;"
    >

        <div style="
            -webkit-order: 0;
            -ms-flex-order: 0;
            order: 0;
            -webkit-flex: 0 1 auto;
            -ms-flex: 0 1 auto;
            flex: 0 1 auto;
            -webkit-align-self: auto;
            -ms-flex-item-align: auto;
            align-self: auto;
            color: #51ccc1;"
        >
            <div style="text-align: left;">
                <span>Valor Total: </span>
            </div>
        </div>

        <div style="
            -webkit-order: 0;
            -ms-flex-order: 0;
            order: 0;
            -webkit-flex: 0 1 auto;
            -ms-flex: 0 1 auto;
            flex: 0 1 auto;
            -webkit-align-self: auto;
            -ms-flex-item-align: auto;
            align-self: auto;
            color: #51ccc1;"
        >
            <div style="text-align: right;">
                <strong>{{ 'R$ '.number_format($recebimento->valor_total, 2, ',', '.') }}  </strong>
            </div>
        </div>

    </div>
</div>
<br>
<div style="text-align:left;font-family:Helvetica,Arial,sans-serif;font-size:15px;margin-bottom:0;color:#5F5F5F;line-height:135%;">
    Qualquer dúvida, por favor, não hesite em entrar em
    contato conosco.
</div>
