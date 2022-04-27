<h4 class="mb-3">Основная информация</h4>
<div class="row mb-5 g-3">
    <div class="col-sm-4">
        <label for="last_name" class="form-label">Фамилия <sup class="text-danger">*</sup></label>
        <input
            id="last_name"
            type="text"
            name="last_name"
            value="{{ old('last_name', $last_name ?? '') }}"
            placeholder="Иванов"
            class="form-control @error('last_name') is-invalid @enderror"
            required=""
        >
    </div>

    <div class="col-sm-4">
        <label for="first_name" class="form-label">Имя <sup class="text-danger">*</sup></label>
        <input
            id="first_name"
            type="text"
            name="first_name"
            value="{{ old('first_name', $first_name ?? '') }}"
            placeholder="Иван"
            class="form-control @error('first_name') is-invalid @enderror"
            required=""
        >
    </div>

    <div class="col-sm-4">
        <label for="patronymic" class="form-label">Отчество</label>
        <input
            id="patronymic"
            type="text"
            name="patronymic"
            value="{{ old('patronymic', $patronymic ?? '') }}"
            placeholder="Иванович"
            class="form-control @error('patronymic') is-invalid @enderror"
        >
    </div>

    <div class="col-12">
        <label for="city" class="form-label">Город проживания <sup class="text-danger">*</sup></label>
        <select
            id="city"
            name="city"
            class="form-select @error('city') is-invalid @enderror"
            required=""
        >
            <option hidden>Выбрать ...</option>
            <option value="Ярославль" @selected(old('city', $city ?? '') === 'Ярославль')>Ярославль</option>
            <option value="Москва" @selected(old('city', $city ?? '') === 'Москва')>Москва</option>
        </select>

        @error('city')
        <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <div class="col-sm-4">
        <label for="date_of_birth" class="form-label">Дата рождения <sup class="text-danger">*</sup></label>
        <input
            id="date_of_birth"
            type="date"
            name="date_of_birth"
            value="{{ old('date_of_birth', $date_of_birth ?? '') }}"
            min="{{ \Illuminate\Support\Carbon::now()->modify('-50 years')->toDateString() }}"
            max="{{ \Illuminate\Support\Carbon::now()->modify('-16 years')->toDateString() }}"
            class="form-control @error('date_of_birth') is-invalid @enderror"
            required=""
        >
    </div>

    <div class="col-sm-8">
        <label class="form-label">Пол <sup class="text-danger">*</sup></label>
        <div class="form-group row">
            <div class="btn-group @error('floor') is-invalid @enderror">
                <input
                    id="floor_male"
                    type="radio"
                    name="floor"
                    value="male"
                    class="btn-check"
                    autocomplete="off"
                    @checked(old('floor', $floor ?? '') === 'male')
                >
                <label for="floor_male" class="btn btn-outline-primary">Мужской</label>

                <input
                    id="floor_women"
                    type="radio"
                    name="floor"
                    value="women"
                    class="btn-check"
                    autocomplete="off"
                    @checked(old('floor', $floor ?? '') === 'women')
                >
                <label for="floor_women" class="btn btn-outline-primary">Женский</label>
            </div>

            @error('floor')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>
