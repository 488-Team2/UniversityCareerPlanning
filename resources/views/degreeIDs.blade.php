@extends('layouts.app')

@section('title', 'DegreesIDs')
@section('content')

    <div class="container">
        <degrees :ids="'{!! $ids !!}'"></degrees>
    </div>
@endsection
