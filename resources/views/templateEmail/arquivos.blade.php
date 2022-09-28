@extends('layout.emailBase')

@section('pre_description', 'Olá, Estamos lhe enviando em anexo os arquivos solicitados.')

@section('mail_content')

<div style="text-align:left;font-family:Helvetica,Arial,sans-serif;font-size:15px;margin-bottom:0;color:#5F5F5F;line-height:135%;">
    @foreach ($arquivos as $arquivo)
        <p>
            {{ $arquivo->nome_original }}
        </p>
    @endforeach
</div>

@endsection
