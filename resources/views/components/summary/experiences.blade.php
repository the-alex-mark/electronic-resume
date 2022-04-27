<h4 class="mb-3">Опыт работы</h4>
<div id="experiences" class="row mb-5 g-3 place-list" data-place-type="experiences">
    @forelse(old('experiences', $experiences ?? []) as $index => $experience)
        @include('components.experience', array_merge([ 'index' => $index ], $experience))
    @empty
        @include('components.experience', [ 'index' => 0 ])
    @endforelse

    <div class="row justify-content-end mt-3">
        <button
            class="btn btn-primary btn-md w-auto place-add"
            data-url="{{ route('summary.place', [ 'type' => 'experience' ]) }}"
        >
            Указать ещё одно место работы
        </button>
    </div>
</div>
