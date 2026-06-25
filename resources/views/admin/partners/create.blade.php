@extends('admin.layouts.admin')

@section('title', 'New partner')
@section('breadcrumb', 'Partners')

@section('content')
    @include('admin.partners._form', ['partner' => $partner, 'submitLabel' => 'Create partner'])
@endsection
