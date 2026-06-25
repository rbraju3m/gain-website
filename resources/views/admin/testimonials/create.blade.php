@extends('admin.layouts.admin')

@section('title', 'New testimonial')
@section('breadcrumb', 'Testimonials')

@section('content')
    @include('admin.testimonials._form', ['testimonial' => $testimonial, 'submitLabel' => 'Create testimonial'])
@endsection
