@extends('admin.layouts.admin')
@section('title', 'New M/V/V card')
@section('breadcrumb', 'M / V / V')
@section('content')
    @include('admin.mvv._form', ['card' => $card, 'submitLabel' => 'Create card'])
@endsection
