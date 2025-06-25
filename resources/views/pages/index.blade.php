@extends('layouts.index')

@section('title', 'Accueil')
@section('description', 'Bienvenue sur Balance intelligente')
@section('keywords', 'balance, dépenses, intelligentes, analyse')
@section('author', 'DINNICHERT Lucas')

@section('content')
    @include('components.filtersAndChart')
    @include('components.uploadInvoiceModal')
    @include('components.cardsManage')
@endsection