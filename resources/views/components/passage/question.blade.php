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
            <div class="d-flex border rounded p-3">
                <span class="d-block flex-grow-1">{{ $question }}</span>

                @if(!empty($image))
                    <div class="question-image">
                        <img
                            src="data:image/jpeg;base64,{{ $image }}"
                            alt=""
                            class="d-block w-100"
                            style="max-height: 300px;"
                        >
                    </div>
                @endif
            </div>

            <div class="question-answers">
                @if($type === 'choice')
                    <span class="d-inline-block mt-4 mb-2">
                        Варианты ответов:
                    </span>

                    @foreach($answers as $i => $answer)
                        <div class="form-check">
                            <input
                                id="answer-{{ $index }}-{{ $i }}"
                                type="radio"
                                name="results[{{ $index }}][value]"
                                value="{{ $i }}"
                                class="form-check-input"
                            >
                            <label for="answer-{{ $index }}-{{ $i }}" class="form-check-label">{{ $answer }}</label>
                        </div>

                        <input type="hidden" name="results[{{ $index }}][points]">
                    @endforeach
                @else
                    <div class="form-group">
                        <span class="d-inline-block mt-4 mb-2">
                            Произвольный ответ
                        </span>

                        <textarea
                            id="answer"
                            name="results[{{ $index }}][value]"
                            rows="6"
                            class="form-control"
                            aria-label="Произвольный ответ"
                        >{{ old('value', $value[$index] ?? '') }}</textarea>

                        <input type="hidden" name="results[{{ $index }}][points]">
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
