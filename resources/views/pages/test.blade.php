@extends('templates.common')
@section('title', 'Редактирование теста')

@section('page')
    <div class="container d-flex flex-grow-1">
        <form id="test" method="POST" enctype="multipart/form-data" action="{{ route('test.save') }}" class="flex-grow-1 d-flex flex-column">
            @csrf
            @include('components.test.properties', [ 'id' => 'properties' ])

            <div id="accordion-test" class="accordion mb-2 question-list">
                @forelse(old('questions', $questions ?? []) as $index => $question)
                    @include('components.test.question', array_merge($question, [
                        'accordion' => 'accordion-test',
                        'number'    => $loop->index + 1,
                        'index'     => $loop->index,
                        'show'      => $loop->index == 0
                    ]))
                @empty
                    @include('components.test.question', [ 'accordion' => 'accordion-test', 'number' => 1, 'index' => 0, 'show' => true ])
                @endforelse
            </div>

            {{-- Управление --}}
            <div class="d-flex mt-auto pt-3 border-top">
                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                        data-bs-target="#properties">Свойства
                </button>

                <div class="ms-auto"></div>
                <button
                    type="button"
                    class="btn btn-outline-primary ms-2 question-add"
                    data-accordion="accordion-test"
                    data-url="{{ route('test.question') }}"
                >
                    Добавить вопрос
                </button>
                <button type="submit" class="btn btn-primary ms-2">Сохранить</button>
            </div>

            {{-- Идентификатор записи --}}
            @isset($id)
                <input type="hidden" name="id" value="{{ $id }}">
            @endisset
        </form>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function () {

            function randIntExcept(min, max, except) {
                let n, e = Array.isArray(except) ? except : [(isNaN(except) ? min - 1 : except)];

                while (true) {
                    n = Math.floor(Math.random() * (max - min + 1)) + min;
                    if (e.indexOf(n) < 0) return n;
                }
            }

            $('body')

            {{-- Удаление блока контроллеров (образование / место работы) --}}
                .on('click', '.question-remove', function (e) {
                    e.preventDefault();

                    let _index = $(this).data('question-index');
                    let _elem = $('[data-question-index="' + _index + '"]');
                    let _prev = _elem.prev('.question-tab');
                    let _next = _elem.next('.question-tab');

                    if (_prev.length > 0) {
                        _prev.tab('show');
                        $(_prev.data('data-bs-target')).addClass('show active');
                    } else if (_next.length > 0) {
                        _next.tab('show');
                        $(_prev.data('data-bs-target')).addClass('show active');
                    }

                    if (_prev.length > 0 || _next.length > 0)
                        _elem.remove();
                })

                {{-- Добавление блока контроллеров (образование / место работы) --}}
                .on('click', '.question-add', function (e) {
                    e.preventDefault();

                    let _parent = $('.question-list');
                    let _accordion = $(this).data('accordion');
                    let _indexes = [];

                    _parent.each(function () {
                        _indexes.push($(this).data('question-index'));
                    });

                    let _url = $(this).data('url');
                    let _body = {
                        'index': randIntExcept(0, 9999, _indexes),
                        'number': _parent.find('.question-item').length + 1,
                        'accordion': _accordion
                    }

                    $.ajax({
                        type: 'POST',
                        async: true,
                        url: _url,
                        data: JSON.stringify(_body),
                        contentType: "application/json",
                        success: (data) => {
                            _parent.find('.collapse-content').removeClass('show')
                            _parent.append(data);
                        }
                    });
                })

                .on('click', '.answer-add', function (e) {
                    e.preventDefault();

                    let _parent = $('.answer-list');
                    let _indexes = [];

                    _parent.each(function () {
                        _indexes.push($(this).data('answer-index'));
                    });

                    let _url = $(this).data('url');
                    let _body = {
                        'question': $(this).parents('.question-item').data('index'),
                        'index': randIntExcept(0, 9999, _indexes),
                    }

                    $.ajax({
                        type: 'POST',
                        async: true,
                        url: _url,
                        data: JSON.stringify(_body),
                        contentType: "application/json",
                        success: (data) => {
                            _parent.append(data);
                        }
                    });
                })

                .on('click', '.answer-remove', function (e) {
                    e.preventDefault();

                    let _parent = $('.answer-list');
                    let _count  = _parent.find('.answer-item').length;

                    if (_count > 2)
                        $(this).parents('.answer-item').remove();
                })

                .on('shown.bs.tab', '.question-type-toggle', function (e) {
                    let _panel_id = $(e.target).data('bs-target');

                    $(_panel_id)
                        .parents('.tab-content')
                        .find('fieldset')
                        .prop('disabled', true);

                    $(_panel_id)
                        .find('fieldset')
                        .prop('disabled', false);
                });

        });
    </script>
@endpush

@push('styles')
    <style>
        body {
            display: flex;
            flex-direction: column;

            min-height: 100vh;
            max-height: 100vh;
            height: 100%;
        }

        main {
            display: flex;
            flex-direction: column;
            flex-grow: 1;
            height: 100%;
        }
    </style>
@endpush
