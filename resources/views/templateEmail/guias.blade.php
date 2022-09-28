@extends('layout.emailBase')

@section('pre_description', 'Olá, Estamos lhe enviando anexo suas guias.')

@section('mail_content')
<div style="text-align:left;font-family:Helvetica,Arial,sans-serif;font-size:15px;margin-bottom:0;color:#5F5F5F;line-height:135%;">
    Por favor, atente-se que um arquivo pode conter uma ou mais guias.
</div>
<br>
<div style="text-align:left;font-family:Helvetica,Arial,sans-serif;font-size:15px;margin-bottom:0;color:#5F5F5F;line-height:135%;">
    @foreach ($guias as $guia)
        <p>
            {{ $guia->tipo }}
            @if(in_array($guia->tipo, ['HOLERITE', 'ISS']))
                .
            @else
                vencimento:
                <strong>
                    {{ \Carbon\Carbon::parse($guia->data_vencimento)->format('d/m/Y') }}
                </strong>
            @endif
        </p>
    @endforeach
</div>
<br>
<div style="text-align:left;font-family:Helvetica,Arial,sans-serif;font-size:15px;margin-bottom:0;color:#5F5F5F;line-height:135%;">
    Qualquer dúvida, por favor, não hesite em entrar em
    contato conosco.
    Seu gestor CS já está em cópia no e-mail.
</div>
<br>
<div style="text-align:left;font-family:Helvetica,Arial,sans-serif;font-size:15px;margin-bottom:0;color:#cccccc;line-height:135%;">
    Identificacao: {{$guias[0]->empresas_id}}
</div>

@endsection
