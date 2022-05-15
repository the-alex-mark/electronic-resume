<div class="d-flex flex-column border rounded mb-2 h-100" style="min-height: 144px; max-height: 144px; height: 100%; background-color: #e9ecef;">
    <div class="d-flex justify-content-end align-items-center p-2">
        <span class="d-inline-block me-auto fw-bold">
            Вопрос №<span>{{ $index + 1 }}</span>
        </span>

        <button class="btn btn-danger p-0 d-flex justify-content-center align-items-center question-remove" data-question-index="{{ $index }}" style="width: 24px; height: 24px;">
            <i class="mdi mdi-close input-group-icon text-white"></i>
        </button>
    </div>
    <div class="d-flex justify-content-center align-items-center border-top rounded bg-white text-center flex-grow-1 px-2 py-3">
        <small>{{ $question ?? '' }}</small>
    </div>
</div>
