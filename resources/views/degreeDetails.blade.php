@extends('layouts.app')

@section('title', 'DegreeDetails')
@section('content')

<navbar></navbar>
    <div class="container">
        
        <degree-details :prev_page_url="'{{ URL::previous() }}'" :degree_id="'{{ $id }}'"></degree-details>
    </div>
@endsection