@extends('template')

@section('title', 'Login')

@section('content')

    <login
        :numbers="{{ $numbers }}"
    />

@endsection
