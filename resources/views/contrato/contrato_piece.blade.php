@extends('contrato.contratoBaseGrupob')

@section('contrato_pieces')
    @foreach($contratos as $piece)
        {!! ($piece) !!}
    @endforeach
@endsection