@extends('layouts.site')

@section('title', config('app.name') . ' — Nourishing Communities, Building Futures')

@section('content')
    @include('partials.home.hero')
    @include('partials.home.impact')
    @include('partials.home.about')
    @include('partials.home.mvv')
    @include('partials.home.achievements')
    @include('partials.home.programmes')
    @include('partials.home.stories')
    @include('partials.home.map')
    @include('partials.home.news')
    @include('partials.home.partners')
    @include('partials.home.cta')
@endsection
