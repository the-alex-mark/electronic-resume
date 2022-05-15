<div class="card mb-2 question-item" data-question-index="{{ $index }}">
    <div
        id="collapse-header-{{ $index }}"
        class="card-header collapse-button border-bottom-0 d-flex align-items-center"
        data-bs-toggle="collapse"
        data-bs-target="#collapse-content-{{ $index }}"
        role="button"
        aria-controls="collapse-content-{{ $index }}"
        style="padding: 12px 16px;"
    >
        <div class="d-flex flex-grow-1 fw-bold text-dark mr-auto">
            Вопрос №{{ $number ?? ($index + 1) }}
        </div>
        <i class="mdi mdi-chevron-down collapse-arrow text-dark pl-3 mdi-rotate-180" data-icon="mdi-transition"></i>
    </div>

    <div
        id="collapse-content-{{ $index }}"
        @class([ 'collapse-content', 'collapse', 'show' => ($show === true) ])
        data-bs-parent="#{{ $accordion }}"
        aria-labelledby="collapse-header-{{ $index }}"
    >
        <div class="card-body d-flex flex-column border-top p-3">

            {{-- Вопрос --}}
            <div class="form-group">
                <label for="questions[{{ $index }}][question]" class="form-label">Вопрос:</label>
                <textarea
                    id="questions[{{ $index }}][question]"
                    name="questions[{{ $index }}][question]"
                    rows="8"
                    class="form-control @error("questions.$index.question") is-invalid @enderror"
                    required=""
                >{{ $question ?? '' }}</textarea>

                @error("questions.$index.question")
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            {{-- Изображение --}}
            <div class="form-group mt-3">
                <label for="questions[{{ $index }}][image]" class="form-label">Изображение:</label>
                <input
                    id="questions[{{ $index }}][image]"
                    type="file"
                    name="questions[{{ $index }}][image]"
                    accept="image/*"
                    value=""
                    class="form-control @error("questions.$index.image") is-invalid @enderror"
                >

                @error("questions.$index.image")
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror

                @if(!empty($image) && is_string($image))
                    <span class="d-inline-block text-muted w-100 mt-1" style="font-size: 0.875em;">Вложение: {{ substr($image, 0, 50) }} ...</span>
                    <input type="hidden" name="questions[{{ $index }}][image_base64]" value="{{ $image }}">
                @endisset
            </div>

            <div class="tab-content">
                @php
                    $type = old("questions.$index.type", $type ?? 'choice');
                @endphp

                {{-- Варианты ответов --}}
                <div class="tab-pane fade @if($type == 'choice') show active @endif" id="question-{{ $index }}-panel-choice_one" role="tabpanel">
                    <fieldset @if($type != 'choice') disabled="" @endif>
                        <span class="d-inline-block mt-3 mb-2">
                            Варианты ответов:
                        </span>

                        <div class="answer-list">
                            @forelse(old("questions.$index.answers", $answers ?? []) as $number => $answer)
                                @include('components.test.answer', [
                                    'question' => $index,
                                    'index'    => $loop->index,
                                    'value'    => $answer,
                                    'true'     => $true ?? null
                                ])
                            @empty
                                @include('components.test.answer', [ 'question' => $index, 'index' => 0 ])
                                @include('components.test.answer', [ 'question' => $index, 'index' => 1 ])
                                @include('components.test.answer', [ 'question' => $index, 'index' => 2 ])
                            @endforelse
                        </div>

                        <input type="hidden" name="questions[{{ $index }}][type]" value="choice">
                    </fieldset>
                </div>

                {{-- Свободный ответ --}}
                <div class="tab-pane fade @if($type == 'free') show active @endif" id="question-{{ $index }}-panel-free" role="tabpanel">
                    <fieldset @if($type != 'free') disabled="" @endif class="mb-3">
                        <input type="hidden" name="questions[{{ $index }}][type]" value="free">
                    </fieldset>
                </div>
            </div>

            {{-- Управление --}}
            <div class="d-flex border-top pt-3">
                <div class="nav nav-pills dropdown">
                    <button
                        type="button"
                        class="btn btn-outline-primary dropdown-toggle"
                        data-bs-toggle="dropdown"
                        aria-expanded="false"
                    >
                        Тип вопроса
                    </button>
                    <ul id="nav-type" class="dropdown-menu dropdown-menu-start" role="tablist">
                        <li><a id="question-{{ $index }}-tab-choice_one" class="dropdown-item question-type-toggle" href="#" data-bs-toggle="pill" data-bs-target="#question-{{ $index }}-panel-choice_one" role="tab">Выбор одного правильного ответа</a></li>
                        <li><a id="question-{{ $index }}-tab-free" class="dropdown-item question-type-toggle" href="#" data-bs-toggle="pill" data-bs-target="#question-{{ $index }}-panel-free" role="tab">Свободный ответ</a></li>
                    </ul>
                </div>

                <div class="ms-auto"></div>
                <button type="button" class="btn btn-outline-primary ms-2 answer-add" data-url="{{ route('test.answer') }}">Добавить вариант</button>
                <button type="button" class="btn btn-danger ms-2 question-remove">Удалить вопрос</button>
            </div>
        </div>
    </div>
</div>
