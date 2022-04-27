<div class="row g-3 bg-light pb-3 border {{--border-light--}} rounded place" data-place-index="{{ $index }}">
    <div class="col-sm-9">
        <label for="educations[{{ $index }}][institution]" class="form-label">Учебное заведение <sup class="text-danger">*</sup></label>
        <input
            id="educations[{{ $index }}][institution]"
            type="text"
            name="educations[{{ $index }}][institution]"
            value="{{ $institution ?? '' }}"
            class="form-control @error("educations.$index.institution") is-invalid @enderror"
            required=""
        >

        @error("educations.$index.institution")
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <div class="col-sm-3">
        <div class="row">
            <label for="educations[{{ $index }}][year]" class="form-label">Год окончания <sup class="text-danger">*</sup></label>
            <div class="input-group">
                <input
                    id="educations[{{ $index }}][year]"
                    type="number"
                    name="educations[{{ $index }}][year]"
                    value="{{ $year ?? '' }}"
                    min="1901"
                    max="2155"
                    placeholder="{{ \Illuminate\Support\Carbon::now()->format('Y') }}"
                    class="form-control @error("educations.$index.year") is-invalid @enderror"
                    required=""
                >
                <span class="input-group-text" data-toggle="popover" data-placement="top" data-trigger="focus" title="Если учитесь в настоящее время — укажите год предполагаемого окончания.">
                    <i class="mdi mdi-help-circle input-group-icon text-muted"></i>
                </span>
            </div>
        </div>
    </div>

    <div class="col-12">
        <label for="educations[{{ $index }}][faculty]" class="form-label">Факультет</label>
        <input
            id="educations[{{ $index }}][faculty]"
            type="text"
            name="educations[{{ $index }}][faculty]"
            value="{{ $faculty ?? '' }}"
            class="form-control @error("educations.$index.faculty") is-invalid @enderror"
        >

        @error("educations.$index.faculty")
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <div class="col-12">
        <label for="educations[{{ $index }}][specialization]" class="form-label">Специализация</label>
        <input
            id="educations[{{ $index }}][specialization]"
            type="text"
            name="educations[{{ $index }}][specialization]"
            value="{{ $specialization ?? '' }}"
            class="form-control @error("educations.$index.specialization") is-invalid @enderror"
        >

        @error("educations.$index.specialization")
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <div class="col">
        <hr class="mt-4">
        <div class="row">
            <div class="col d-flex justify-content-end">
                <button class="btn btn-outline-danger btn-md ms-2 btn-place-clear">Очистить</button>
                <button class="btn btn-danger btn-md ms-2 btn-place-remove">Удалить</button>
            </div>
        </div>
    </div>

    {{-- Идентификатор записи --}}
    @isset($id)
        <input type="hidden" name="educations[{{ $index }}][id]" value="{{ $id }}">
    @endisset
</div>
