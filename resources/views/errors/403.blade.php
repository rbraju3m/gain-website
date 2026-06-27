@extends('layouts.site')

@section('title', 'Forbidden — ' . config('app.name'))

@section('content')
    @include('errors._layout', [
        'code'     => '403',
        'title'    => "You can't see this page.",
        'body'     => "You don't have permission to access this. If you think that's a mistake, contact the site administrator.",
        'iconPath' => 'M12 2 4 6v6c0 5 3.5 9.74 8 10 4.5-.26 8-5 8-10V6l-8-4ZM9 12l2 2 4-4',
    ])
@endsection
