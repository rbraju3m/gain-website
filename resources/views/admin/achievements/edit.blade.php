@extends('admin.layouts.admin')
@section('title', 'Edit · ' . $achievement->title)
@section('breadcrumb', 'Achievements')
@section('content')
    @include('admin.achievements._form', ['achievement' => $achievement, 'submitLabel' => 'Save changes'])
@endsection
