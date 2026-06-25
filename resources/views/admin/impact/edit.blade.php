@extends('admin.layouts.admin')
@section('title', 'Edit · ' . $stat->label)
@section('breadcrumb', 'Impact stats')
@section('content')
    @include('admin.impact._form', ['stat' => $stat, 'submitLabel' => 'Save changes'])
@endsection
