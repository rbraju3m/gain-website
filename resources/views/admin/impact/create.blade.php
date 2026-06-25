@extends('admin.layouts.admin')
@section('title', 'New impact stat')
@section('breadcrumb', 'Impact stats')
@section('content')
    @include('admin.impact._form', ['stat' => $stat, 'submitLabel' => 'Create stat'])
@endsection
