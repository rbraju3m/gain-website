@extends('admin.layouts.admin')

@section('title', 'New service')
@section('breadcrumb', 'Services')

@section('content')
    @include('admin.services._form', ['service' => $service, 'submitLabel' => 'Create service'])
@endsection
