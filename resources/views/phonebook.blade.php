@extends('template')

@section('title', "Contatos")

@section('content')

    <phonebook
        :contacts="{{ $contacts }}"
    />

@endsection
