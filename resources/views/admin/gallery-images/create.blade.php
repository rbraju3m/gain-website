@extends('admin.layouts.admin')

@section('title', 'New gallery image')
@section('breadcrumb', 'Gallery')

@section('content')
    @include('admin.gallery-images._form', ['image' => $image, 'allYears' => $allYears, 'submitLabel' => 'Add image'])
@endsection
