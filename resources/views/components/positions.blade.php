<select
    id="{{ $id }}"
    name="{{ $name }}"
    class="form-select @error($name) is-invalid @enderror"
    @class([ 'form-select', 'is-invalid' => $errors->has($name) ])
    @disabled($list->isEmpty())
    required=""
>
    <option hidden {{ selected(false, $list->isEmpty()) }}>
        @if($list->isEmpty()) Данные отсутствуют @else Выбрать ... @endif
    </option>

    @foreach($list as $position)
        <option {{ selected($position->id, $value ?? -1) }} value="{{ $position->id }}">
            {{ $position->title }}
        </option>
    @endforeach
</select>
