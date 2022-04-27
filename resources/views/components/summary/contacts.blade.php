<h4 class="mb-3">Контактные данные</h4>
<div class="row mb-5 g-3">
    <div class="col-md-6">
        <label for="phone" class="form-label">Мобильный телефон <sup class="text-danger">*</sup></label>
        <input
            id="phone"
            type="tel"
            name="phone"
            value="{{ old('phone', $phone ?? '') }}"
            placeholder="+7 (000) 000-00-00"
            class="form-control input-mask-phone @error('phone') is-invalid @enderror"
            required=""
        >

        @error('phone')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="email" class="form-label">Электронная почта</label>
        <input
            id="email"
            type="email"
            name="email"
            value="{{ old('email', $email ?? Auth::user()->email ?? '') }}"
            placeholder="you@example.com"
            class="form-control @error('email') is-invalid @enderror"
        >

        @error('email')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <div class="col-12">
        <label for="site" class="form-label">Личный сайт</label>
        <div class="input-group">
            <span class="input-group-text">
                <i class="mdi mdi-link-variant input-group-icon"></i>
            </span>
            <input
                id="site"
                type="text"
                name="site"
                value="{{ old('site', $site ?? '') }}"
                placeholder="example.com"
                class="form-control @error('site') is-invalid @enderror"
            >

            @error('site')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>
