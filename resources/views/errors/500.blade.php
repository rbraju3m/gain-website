@extends('layouts.site')

@section('title', 'Something went wrong — ' . config('app.name'))

@section('content')
    @include('errors._layout', [
        'code'     => '500',
        'title'    => 'Something went wrong on our end.',
        'body'     => "We've logged the error and the team will look at it. Try refreshing in a moment, or head back to the homepage.",
        'iconPath' => 'M12 9v4M12 17h.01M10.3 3.86a1.5 1.5 0 0 1 2.6 0l7.9 13.67a1.5 1.5 0 0 1-1.3 2.25H3.69a1.5 1.5 0 0 1-1.3-2.25l7.9-13.67Z',
    ])
@endsection
