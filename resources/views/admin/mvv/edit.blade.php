@extends('admin.layouts.admin')
@section('title', 'Edit · ' . $card->title)
@section('breadcrumb', 'M / V / V')
@section('content')
    @include('admin.mvv._form', ['card' => $card, 'submitLabel' => 'Save changes'])
@endsection
