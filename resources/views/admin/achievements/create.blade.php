@extends('admin.layouts.admin')
@section('title', 'New achievement')
@section('breadcrumb', 'Achievements')
@section('content')
    @include('admin.achievements._form', ['achievement' => $achievement, 'submitLabel' => 'Create achievement'])
@endsection
