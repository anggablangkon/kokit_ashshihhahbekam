<div class="p-3 bg-light-subtle border-bottom border-dashed">
    <div class="row">
        <div class="col">
            <h4 class="fs-sm mb-1">Summary Data?</h4>
            <small class="text-muted fs-xs mb-0">
                1 data pesanan ada dalam sistem
            </small>
        </div>
        <div class="col-auto align-self-center">
            <button type="button" class="btn btn-sm btn-default rounded-circle btn-icon" data-bs-toggle="tooltip"
                data-bs-placement="top" data-bs-title="Download">
                <i class="ti ti-download fs-xl"></i>
            </button>
        </div>
    </div>
</div>
<div class="row row-cols-xxl-2 row-cols-md-2 row-cols-1 g-1 p-1">
    @foreach ($data as $item)
        @php
            // Hitung persentase progress (misal kedatangan / total_qty dalam persen)
            $progress = $item->total_qty > 0 ? ($item->kedatangan / $item->total_qty) * 100 : 0;
            $progress = round($progress, 2);
            // Pilih label warna dan ikon berdasarkan kode
            $colors = [
                'CK' => ['bg' => 'bg-success', 'icon' => 'ti ti-check', 'text' => 'Total CK'],
                'BC' => ['bg' => 'bg-danger', 'icon' => 'ti ti-alert-circle', 'text' => 'Total BC'],
                'BE' => ['bg' => 'bg-primary', 'icon' => 'ti ti-bolt', 'text' => 'Total BE'],
            ];

            $color = $colors[$item->kode] ?? ['bg' => 'bg-secondary', 'icon' => 'ti ti-help', 'text' => 'Total ' . $item->kode];
        @endphp

        <div class="col">
            <div class="card rounded-0 border shadow-none border-dashed mb-0">
                <div class="card-body">
                    <div class="mb-3 d-flex justify-content-between align-items-center">
                        <h5 class="fs-xl mb-0">{{ number_format($item->kedatangan) }}</h5>
                        <span>{{ $progress }}% <i class="ti ti-arrow-up text-success"></i></span>
                    </div>
                    <p class="text-muted mb-2"><span>{{ $color['text'] }}</span></p>
                    <div class="progress progress-sm mb-0">
                        <div class="progress-bar {{ $color['bg'] }}" role="progressbar" style="width: {{ $progress }}%"
                            aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>