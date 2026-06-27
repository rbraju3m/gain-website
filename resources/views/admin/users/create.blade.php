@extends('admin.layouts.admin')

@section('title', 'New user')
@section('breadcrumb', 'Overview')

@section('content')
    @include('admin.users._form', ['submitLabel' => 'Create user'])
@endsection
