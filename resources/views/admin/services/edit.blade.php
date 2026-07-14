@extends('admin.layouts.admin')

@section('title', 'Edit service · ' . $service->title)
@section('breadcrumb', 'Services')

@section('content')
    @include('admin.services._form', ['service' => $service, 'submitLabel' => 'Save changes'])
@endsection
