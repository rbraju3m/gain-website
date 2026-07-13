@extends('admin.layouts.admin')

@section('title', 'Edit hero slide')
@section('breadcrumb', 'Hero carousel')

@section('content')
    @include('admin.hero-slides._form', ['slide' => $slide, 'submitLabel' => 'Save changes'])
@endsection
