@extends('layout.emailBase')

@section('pre_description', 'Olá, Estamos lhe enviando anexo sua declaração de renda.')

@section('mail_content')
    <div style="text-align:left;font-family:Helvetica,Arial,sans-serif;font-size:15px;margin-bottom:0;color:#5F5F5F;line-height:135%;">
        Olá, Estamos lhe enviando anexo sua declaração de renda conforme solicitado.
    </div>
    <br>
    <div style="text-align:left;font-family:Helvetica,Arial,sans-serif;font-size:15px;margin-bottom:0;color:#5F5F5F;line-height:135%;">
        Qualquer dúvida, por favor, não hesite em entrar em
        contato conosco.
        Seu gestor CS já está em cópia no e-mail.
    </div>
@endsection
