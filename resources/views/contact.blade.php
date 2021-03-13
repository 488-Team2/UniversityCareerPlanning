@extends('layouts.app')

@section('content')
    <div id="app"> 
        <navbar></navbar>
        <br>
        <div class="row">
            <div class="col-6 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <h2>Contact Us</h2>
                    </div>
                    <div class="card-body">
                        <contact-form></contact-form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection