@extends('app')

@section('content')
    @include('templates.parts.navbar')

    <main class="main py-4">
        @include('templates.parts.breadcrumb')
        @yield('page')
    </main>

    @include('templates.parts.footer')
@endsection
