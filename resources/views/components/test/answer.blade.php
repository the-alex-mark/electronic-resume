<div class="form-group answer-item mb-3" data-answer-index="{{ $index }}">
    <div class="input-group @error("questions.$question.answers.$index") is-invalid @enderror @error("questions.$question.answers.$index") is-invalid @enderror">
        <div class="input-group-text">
            <input
                type="radio"
                name="questions[{{ $question }}][true]"
                value="{{ $index }}"
                class="form-check-input mt-0"
                aria-label=""
                @checked(isset($true) && intval($true) === $index)
            >
        </div>

        <input
            type="text"
            name="questions[{{ $question }}][answers][{{ $index }}]"
            value="{{ $value ?? '' }}"
            class="form-control @error("questions.$question.answers.$index") is-invalid @enderror"
            aria-label="Вариант ответа"
            required=""
        >

        <button class="btn btn-outline-danger answer-remove">Удалить</button>
    </div>
</div>
