@extends('layouts.site')

@section('title', 'Under maintenance — ' . config('app.name'))

@section('content')
    @include('errors._layout', [
        'code'     => '503',
        'title'    => "We're briefly down for maintenance.",
        'body'     => 'The site will be back shortly. Thanks for your patience — feel free to reach us in the meantime if you need anything urgent.',
        'iconPath' => 'M11 21V8m2 13V11m9-3-9 13M3 17l4-6m0 0 4-6m4 12 4-6M7 11h10',
    ])
@endsection
