@extends('admin.layouts.admin')

@section('title', 'Edit partner · ' . $partner->name)
@section('breadcrumb', 'Partners')

@section('content')
    @include('admin.partners._form', ['partner' => $partner, 'submitLabel' => 'Save changes'])
@endsection
