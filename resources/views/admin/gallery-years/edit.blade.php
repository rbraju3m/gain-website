@extends('admin.layouts.admin')

@section('title', 'Edit gallery year · ' . $year->year)
@section('breadcrumb', 'Gallery')

@section('content')
    @include('admin.gallery-years._form', ['year' => $year, 'submitLabel' => 'Save changes'])
@endsection
