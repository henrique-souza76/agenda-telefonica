@extends('template')

@section('title', "Contatos")

@section('content')

    <phonebook
        :user_name="'{{$user_name}}'"
        :contacts="{{$contacts}}"
    />

@endsection
