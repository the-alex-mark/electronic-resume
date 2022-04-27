@extends('templates.common')
@section('title', 'Редактирование анкеты')

@section('page')
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-9">
                <form id="summary" method="POST" action="{{ route('summary.save') }}">
                    @csrf

                    @include('components.summary.common')
                    @include('components.summary.contacts')
                    @include('components.summary.specialization')
                    @include('components.summary.educations')
                    @include('components.summary.experiences')
                    @include('components.summary.about')

                    {{-- Идентификатор записи --}}
                    @isset($id)
                        <input type="hidden" name="id" value="{{ $id }}">
                    @endisset

                    <hr class="mt-5 mb-4">
                    <button type="submit" class="w-100 btn btn-primary btn-lg">
                        Сохранить анкету
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {

            function randIntExcept(min, max, except) {
                let n, e = Array.isArray(except) ? except : [ (isNaN(except) ? min-1 : except) ];

                while (true) {
                    n = Math.floor(Math.random() * (max - min + 1)) + min;
                    if (e.indexOf(n) < 0) return n;
                }
            }

            $('body')

                {{-- Очистка блока контроллеров (образование / место работы) --}}
                .on('click', '.btn-place-clear', function (e) {
                    e.preventDefault();

                    let _parent   = $(this).parents('.place');
                    let _controls = _parent.find(':input, textarea');

                    _controls.val('');
                })

                {{-- Удаление блока контроллеров (образование / место работы) --}}
                .on('click', '.btn-place-remove', function (e) {
                    e.preventDefault();

                    let _list   = $(this).parents('.place-list').find('.place');
                    let _parent = $(this).parents('.place');

                    if (_list.length > 1)
                        _parent.remove();
                })

                {{-- Добавление блока контроллеров (образование / место работы) --}}
                .on('click', '.place-add', function (e) {
                    e.preventDefault();
                    let _list    = $(this).parents('.place-list').find('.place');
                    let _indexes = [];

                    _list.each(function () {
                        _indexes.push($(this).data('place-index'));
                    });

                    let _url  = $(this).data('url');
                    let _body = {
                        'index': randIntExcept(0, 9999, _indexes)
                    }

                    $.ajax({
                        type: 'POST',
                        async: true,
                        url: _url,
                        data: JSON.stringify(_body),
                        contentType: "application/json",
                        success: (data) => {
                            $(this).parent('.row').before(data);
                        }
                    });
                });

        });
    </script>
@endpush
