@extends('layouts.app')

@section('title', 'DegreesIDs')
@section('content')

<navbar></navbar>
    <div class="container">
        <degrees :ids="'{!! $ids !!}'"></degrees>
    </div>
@endsection
