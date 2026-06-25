@extends('admin.layouts.admin')

@section('title', 'New programme')
@section('breadcrumb', 'Programmes')

@section('content')
    @include('admin.programmes._form', ['programme' => $programme, 'submitLabel' => 'Create programme'])
@endsection
