@extends('layouts.app')

@section('content')
    <home-component :base_url="'{{ config('app.url') }}'" />
@endsection
