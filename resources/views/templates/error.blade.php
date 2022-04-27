@extends('app')

@section('content')
    <div id="error" class="error flex-fill d-flex flex-column">
        <main class="main my-auto">
            @yield('page')
        </main>
    </div>
@endsection

@push('styles')
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            height: 100%;
        }
    </style>
@endpush
