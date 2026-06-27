@extends('layouts.site')

@section('title', 'Page not found — ' . config('app.name'))

@section('content')
    @include('errors._layout', [
        'code'     => '404',
        'title'    => "We couldn't find that page.",
        'body'     => 'The link may have moved, or it might never have existed. Head back to the homepage or get in touch if you think this is a mistake.',
        'iconPath' => 'M9.7 14.3a3 3 0 0 1 4.6 0M9 9h.01M15 9h.01M12 22a10 10 0 1 0 0-20 10 10 0 0 0 0 20Z',
    ])
@endsection
