@extends('admin.layouts.admin')

@section('title', 'Edit gallery image · ' . $image->title)
@section('breadcrumb', 'Gallery')

@section('content')
    @include('admin.gallery-images._form', ['image' => $image, 'allYears' => $allYears, 'submitLabel' => 'Save changes'])
@endsection
