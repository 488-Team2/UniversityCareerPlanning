@extends('layouts.app')

@section('title', 'DegreeSearch')
@section('content')
<navbar></navbar>
    <div class="container">
        <degrees :keywords="'{!! $keywords !!}'"></degrees>
    </div>
@endsection
