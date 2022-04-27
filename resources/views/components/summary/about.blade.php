<h4 class="mb-3">Прочая информация</h4>
<div class="row g-3">
    <div class="col-12">
        <label for="about" class="form-label">О себе</label>
        <textarea
            id="about"
            name="about"
            rows="8"
            class="form-control @error('about') is-invalid @enderror"
        >{{ old('about', $about ?? '') }}</textarea>
    </div>
</div>
