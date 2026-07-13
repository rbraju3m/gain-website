@extends('admin.layouts.admin')

@section('title', 'New gallery year')
@section('breadcrumb', 'Gallery')

@section('content')
    @include('admin.gallery-years._form', ['year' => $year, 'submitLabel' => 'Create year'])
@endsection
