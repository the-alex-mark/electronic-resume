@extends('templates.common')
@section('title', 'Консоль')

@section('page')
    <div class="container">

        @if (session('response'))
            <div class="alert @if(session('response.result', true)) alert-success @else alert-danger @endif" role="alert">
                {!! session('response.message') !!}
            </div>
        @endif

        <div class="card mb-3">
            <div class="card-header">
                {{ __('Список кандидатов') }}
            </div>
            <div class="card-body">

                <table class="table table-striped table-hover align-middle mb-0">
                    <thead>
                    <tr>
                        <th style="min-width: 60px;" class="text-center">№</th>
                        <th style="width: 100%;">Имя</th>
                        <th style="min-width: 150px;" class="text-end">Телефон</th>
                        <th style="min-width: 110px;" class="text-end">Баллы</th>
                        <th style="min-width: 110px;" class="text-end">Действие</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($summaries as $summary)
                        <tr>
                            <td class="text-center">{{ $loop->index + 1 }}</td>
                            <td>{{ $summary['full_name'] }}</td>
                            <td class="text-end">
                                <a href="tel:{{ '8' . phone_cleared($summary['phone']) }}">{{ phone_formatted($summary['phone']) }}</a>
                            </td>
                            <td class="text-end">{{ $summary['result']['points'] }}</td>
                            <td class="text-end">
                                <div class="d-inline nav nav-pills dropdown">
                                    <button
                                        type="button"
                                        class="btn btn-sm btn-outline-primary"
                                        data-bs-toggle="dropdown"
                                        aria-expanded="false"
                                    >
                                        <i class="mdi mdi-dots-horizontal"></i>
                                    </button>
                                    <ul id="nav-type" class="dropdown-menu dropdown-menu-end" role="tablist">
                                        <li><a class="dropdown-item" href="{{ route('summary.read', [ 'summary' => $summary['id'] ]) }}">Просмотреть анкету</a></li>
                                        <li><a class="dropdown-item" href="{{ route('checking.check', [ 'result' => $summary['result']['id'] ]) }}">Проверить результат</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Ни один из кандидатов ещё не прошёл тестирование.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>

            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header">
                {{ __('Список тестов') }}
            </div>
            <div class="card-body">

                <table class="table table-striped table-hover align-middle mb-0">
                    <thead>
                    <tr>
                        <th style="min-width: 60px;" class="text-center">№</th>
                        <th style="width: 100%;">Название</th>
                        <th style="min-width: 110px;" class="text-end">Действие</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($tests as $test)
                        <tr>
                            <td class="text-center">{{ $loop->index + 1 }}</td>
                            <td>{{ $test['title'] }}</td>
                            <td class="text-end">
                                <div class="d-inline nav nav-pills dropdown">
                                    <button
                                        type="button"
                                        class="btn btn-sm btn-outline-primary"
                                        data-bs-toggle="dropdown"
                                        aria-expanded="false"
                                    >
                                        <i class="mdi mdi-dots-horizontal"></i>
                                    </button>
                                    <ul id="nav-type" class="dropdown-menu dropdown-menu-end" role="tablist">
                                        <li><a class="dropdown-item" href="{{ route('test.edit', [ 'test' => $test['id'] ]) }}">Редактировать</a></li>
                                        <li><a class="dropdown-item" href="{{ route('test.export', [ 'test' => $test['id'] ]) }}">Экспортировать</a></li>
                                        <li><a class="dropdown-item" href="{{ route('test.delete', [ 'test' => $test['id'] ]) }}">Удалить</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center">Вы пока ещё не создали ни одного теста.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>

                <div class="d-flex justify-content-end mt-3">
                    <a
                        href="{{ route('test.create') }}"
                        class="btn btn-primary btn-md w-auto place-add">
                        Создать
                    </a>
                </div>

            </div>
        </div>

    </div>
@endsection
