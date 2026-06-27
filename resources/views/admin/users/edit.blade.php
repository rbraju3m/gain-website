@extends('admin.layouts.admin')

@section('title', 'Edit ' . $user->name)
@section('breadcrumb', 'Overview')

@section('content')
    @include('admin.users._form', ['submitLabel' => 'Save changes'])
@endsection
