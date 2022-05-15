<h4 class="mb-3">Образование</h4>
<div id="educations" class="row mb-5 g-3 place-list" data-place-type="educations">
    @forelse(old('educations', $educations ?? []) as $index => $education)
        @include('components.education', array_merge([ 'index' => $index ], $education))
    @empty
        @if(!isset($id))
            @include('components.education', [ 'index' => 0 ])
        @endif
    @endforelse

    @if(!isset($readonly) || $readonly !== true)
        <div class="row justify-content-end mt-3">
            <button
                class="btn btn-primary btn-md w-auto place-add"
                data-url="{{ route('summary.place', [ 'type' => 'education' ]) }}"
            >
                Указать ещё одно место обучения
            </button>
        </div>
    @endif
</div>
