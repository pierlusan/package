@extends('layouts.app')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="container">
                    {{$surveys}}
                </div>
            </div>
        </div>
    </div>
@endsection
