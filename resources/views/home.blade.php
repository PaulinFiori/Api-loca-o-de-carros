@extends('layouts.app')

@section('content')
    @php 
        $status = session('status') ? session('status') : 'Você está logado'
    @endphp
    <home-component status="{{ $status }}"></home-component>
@endsection
