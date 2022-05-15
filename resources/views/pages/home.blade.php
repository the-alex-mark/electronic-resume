@extends('templates.common')
@section('title', 'Консоль')

@section('page')
    <div class="container">
        <div class="card">
            <div class="card-header">
                {{ __('Список анкет') }}
            </div>
            <div class="card-body">

                <table class="table table-striped table-hover align-middle mb-0">
                    <thead>
                    <tr>
                        <th style="min-width: 60px;" class="text-center">№</th>
                        <th style="width: 100%;">Имя</th>
                        <th style="min-width: 150px;" class="text-end">Телефон</th>
                        <th style="min-width: 80px;" class="text-end">Баллы</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($summaries as $summary)
                        <tr class="summary-row" data-url="{{ route('summary.edit', [ 'summary' => $summary['id'] ]) }}" role="link">
                            <td class="text-center">{{ $loop->index + 1 }}</td>
                            <td>{{ $summary['full_name'] }}</td>
                            <td class="text-end">{{ phone_formatted($summary['phone']) }}</td>
                            <td class="text-end">{{ $summary['result']['points'] }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">Вы пока ещё не создали ни одной анкеты.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>

            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {

            $('body').on('click', '.summary-row', function (e) {
                window.location = $(this).data('url');
            });

        });
    </script>
@endpush
