<h4 class="mb-3">Специализация</h4>
<div class="row mb-5 g-3">
    <div class="col-12">
        <label for="position_id" class="form-label">Должность <sup class="text-danger">*</sup></label>
        <x-positions id="position_id" name="position_id" value="{{ old('position_id', $position_id ?? -1) }}"></x-positions>

        @error('position_id')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>
</div>
