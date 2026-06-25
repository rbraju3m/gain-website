@extends('admin.layouts.admin')

@section('title', 'Edit article · ' . $article->title)
@section('breadcrumb', 'News')

@section('content')
    @include('admin.news._form', ['article' => $article, 'submitLabel' => 'Save changes'])
@endsection
