@extends('layouts.site')

@section('title', 'Session expired — ' . config('app.name'))

@section('content')
    @include('errors._layout', [
        'code'     => '419',
        'title'    => 'Your session timed out.',
        'body'     => 'For security, the form you were filling out has expired. Go back to that page and try again.',
        'iconPath' => 'M12 8v4l3 3M3.05 11a9 9 0 1 1 .5 4M3 4v7h7',
    ])
@endsection
