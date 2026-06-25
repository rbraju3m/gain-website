@extends('admin.layouts.admin')

@section('title', 'Edit programme · ' . $programme->title)
@section('breadcrumb', 'Programmes')

@section('content')
    @include('admin.programmes._form', ['programme' => $programme, 'submitLabel' => 'Save changes'])
@endsection
