@extends('app')

@section('content')
    <div id="auth" class="auth flex-fill d-flex flex-column">
        @include('templates.parts.navbar')

        <main class="main py-4 my-auto">
            @yield('page')
        </main>

        @include('templates.parts.footer')
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
