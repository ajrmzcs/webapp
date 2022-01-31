@extends('layouts.app')

@section('content')
    <show-records-component :base_url="'{{ config('app.url') }}'" />
@endsection
