@extends('layouts.app')

@section('title', 'DegreeDetails')
@section('content')

    <div class="container">
        <navbar></navbar>
        <degree-details :prev_page_url="'{{ URL::previous() }}'" :degree_id="'{{ $id }}'"></degree-details>
    </div>
@endsection