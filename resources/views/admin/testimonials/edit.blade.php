@extends('admin.layouts.admin')

@section('title', 'Edit testimonial · ' . $testimonial->author_name)
@section('breadcrumb', 'Testimonials')

@section('content')
    @include('admin.testimonials._form', ['testimonial' => $testimonial, 'submitLabel' => 'Save changes'])
@endsection
