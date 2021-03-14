@extends('layouts.app')

@section('title', 'DegreeDetails')
@section('content')

    <div class="container">
        <degree-details :prev_page_url="'{{ URL::previous() }}'"></degree-details>
    </div>
@endsection