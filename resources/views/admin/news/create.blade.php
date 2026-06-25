@extends('admin.layouts.admin')

@section('title', 'New article')
@section('breadcrumb', 'News')

@section('content')
    @include('admin.news._form', ['article' => $article, 'submitLabel' => 'Create article'])
@endsection
