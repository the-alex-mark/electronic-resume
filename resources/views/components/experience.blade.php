<div class="row g-3 bg-light pb-3 border {{--border-light--}} rounded place" data-place-index="{{ $index }}" data-place-type="experience">
    <div class="col-md-6">
        <label for="experiences[{{ $index }}][organization]" class="form-label">Организация <sup class="text-danger">*</sup></label>
        <input
            id="experiences[{{ $index }}][organization]"
            type="text"
            name="experiences[{{ $index }}][organization]"
            value="{{ $organization ?? '' }}"
            class="form-control @error("experiences.$index.organization") is-invalid @enderror"
            required=""
        >

        @error("experiences.$index.organization")
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <div class="col-6 col-md-3">
        <label for="experiences[{{ $index }}][start]" class="form-label">Начало <sup class="text-danger">*</sup></label>
        <input
            id="experiences[{{ $index }}][start]"
            type="date"
            name="experiences[{{ $index }}][start]"
            value="{{ $start ?? '' }}"
            class="form-control @error("experiences.$index.start") is-invalid @enderror"
            required=""
        >
    </div>

    <div class="col-6 col-md-3">
        <label for="experiences[{{ $index }}][end]" class="form-label">Окончание</label>
        <input
            id="experiences[{{ $index }}][end]"
            type="date"
            name="experiences[{{ $index }}][end]"
            value="{{ $end ?? '' }}"
            class="form-control @error("experiences.$index.end") is-invalid @enderror"
        >
    </div>

    <div class="col-12">
        <label for="experiences[{{ $index }}][position]" class="form-label">Должность <sup class="text-danger">*</sup></label>
        <input
            id="experiences[{{ $index }}][position]"
            type="text"
            name="experiences[{{ $index }}][position]"
            value="{{ $position ?? '' }}"
            class="form-control @error("experiences.$index.position") is-invalid @enderror"
            required=""
        >

        @error("experiences.$index.position")
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <div class="col-12">
        <label for="experiences[{{ $index }}][description]" class="form-label">Обязанности на рабочем месте <sup class="text-danger">*</sup></label>
        <textarea
            id="experiences[{{ $index }}][description]"
            name="experiences[{{ $index }}][description]"
            rows="4"
            class="form-control @error("experiences.$index.description") is-invalid @enderror"
            required=""
        >{{ $description ?? '' }}</textarea>

        @error("experiences.$index.description")
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <div class="col-12">
        <label for="experiences[{{ $index }}][site]" class="form-label">Сайт</label>
        <div class="input-group">
            <span class="input-group-text">
                <i class="mdi mdi-link-variant input-group-icon"></i>
            </span>
            <input
                id="experiences[{{ $index }}][site]"
                type="text"
                name="experiences[{{ $index }}][site]"
                value="{{ $site ?? '' }}"
                placeholder="example.com"
                class="form-control @error("experiences.$index.site") is-invalid @enderror"
            >

            @error("experiences.$index.site")
            <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>

    @if(!isset($readonly) || $readonly !== true)
        <div class="col">
            <hr class="mt-4">
            <div class="row">
                <div class="col d-flex justify-content-end">
                    <button class="btn btn-outline-danger btn-md ms-2 btn-place-clear">Очистить</button>
                    <button class="btn btn-danger btn-md ms-2 btn-place-remove">Удалить</button>
                </div>
            </div>
        </div>
    @endif

    {{-- Идентификатор записи --}}
    @isset($id)
        <input type="hidden" name="experiences[{{ $index }}][id]" value="{{ $id }}">
    @endisset
</div>
