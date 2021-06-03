@extends('layouts.app')

@section('title', 'DegreeSearch')
@section('content')
    <div class="container">
        <degrees :keywords="'{!! $keywords !!}'"></degrees>
    </div>
@endsection
