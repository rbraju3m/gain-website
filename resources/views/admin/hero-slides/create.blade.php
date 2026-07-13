@extends('admin.layouts.admin')

@section('title', 'New hero slide')
@section('breadcrumb', 'Hero carousel')

@section('content')
    @include('admin.hero-slides._form', ['slide' => $slide, 'submitLabel' => 'Create slide'])
@endsection
