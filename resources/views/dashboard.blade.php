@extends('layouts.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
<!--             <div class="card">
                <div class="card-header">{{ __('Student Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div> -->
            <student-dashboard></student-dashboard>
            <br>
            <load-session></load-session>

        </div>
    </div>
    
</div>
@endsection
