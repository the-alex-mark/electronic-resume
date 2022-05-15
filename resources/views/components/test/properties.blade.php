<div class="modal fade" id="{{ $id }}">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Свойства</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-md-7">
                        <div class="form-group mb-3">
                            <label for="title" class="form-label">Название <sup class="text-danger">*</sup></label>
                            <input
                                id="title"
                                type="text"
                                name="title"
                                value="{{ old('title', $title ?? '') }}"
                                class="form-control @error('title') is-invalid @enderror"
                                required=""
                            >

                            @error('title')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="position_id" class="form-label">Должность <sup class="text-danger">*</sup></label>
                            <x-positions
                                id="position_id"
                                name="position_id"
                                value="{{ old('position_id', $position_id ?? -1) }}"
                            ></x-positions>

                            @error('position_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-group">
                            <label for="description" class="form-label">Описание</label>
                            <textarea
                                id="description"
                                name="description"
                                rows="6"
                                class="form-control @error('description') is-invalid @enderror"
                            >{{ old('description', $description ?? '') }}</textarea>

                            @error('description')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Сохранить</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {

            $('#{{ $id }}').on('shown.bs.modal', function (e) {
                $('input[name="title"]').get(0).focus();
            });

        });
    </script>
@endpush
