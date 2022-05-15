@extends('templates.common')
@section('title', 'Тестирование')

@section('page')
    <div class="container d-flex flex-grow-1">
        <form id="test" method="POST" action="{{ route('passage.save') }}" class="flex-grow-1 d-flex flex-column">
            @csrf

            <div id="accordion-test" class="accordion mb-2 question-list">
                @foreach($questions ?? [] as $index => $question)
                    @include('components.passage.question', array_merge($question, [
                        'accordion' => 'accordion-test',
                        'number'    => $loop->index + 1,
                        'index'     => $loop->index,
                        'show'      => $loop->index == 0
                    ]))
                @endforeach
            </div>

            {{-- Управление --}}
            <div class="d-flex mt-auto justify-content-end pt-3 border-top">
                <button type="submit" class="btn btn-primary ms-2">Сохранить</button>
            </div>

            {{-- Идентификатор записи --}}
            @isset($id)
                <input type="hidden" name="id" value="{{ $id }}">
            @endisset
        </form>
    </div>
@endsection

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
