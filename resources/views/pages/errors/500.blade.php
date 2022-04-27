@extends('templates.error')
@section('title', 'Внутренняя ошибка сервера')

@section('page')
    <div class="d-flex justify-content-center align-items-center">
        <h1 class="me-3 pe-3 align-top border-end inline-block align-content-center">500</h1>
        <div class="inline-block align-middle">
            <h2 class="font-weight-normal lead">Внутренняя ошибка сервера.</h2>
        </div>
    </div>
@endsection
