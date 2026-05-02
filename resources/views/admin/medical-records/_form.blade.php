@php
    $currentMedicalRecord = $medicalRecord ?? null;
    $currentFormContext = $formContext ?? null;
    $usesOldInput = $currentFormContext !== null && old('form_context') === $currentFormContext;
    $fieldPrefix = $fieldPrefix ?? 'medical_record';
@endphp

<div class="row">
    <!-- Row Atas: Pasien, Pegawai, Tanggal -->
    <div class="col-md-4 mb-3">
        <label for="{{ $fieldPrefix }}_patient_id" class="form-label">Pasien <span class="text-danger">*</span></label>
        <select id="{{ $fieldPrefix }}_patient_id" required name="patient_id" class="form-select">
            <option value="">Pilih pasien</option>
            @foreach ($patients as $patientOption)
                <option value="{{ $patientOption->id }}" @selected(($usesOldInput ? old('patient_id') : $currentMedicalRecord?->patient_id) == $patientOption->id)>
                    {{ $patientOption->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-4 mb-3">
        <label for="{{ $fieldPrefix }}_employee_id" class="form-label">Pegawai <span class="text-danger">*</span></label>
        <select id="{{ $fieldPrefix }}_employee_id" required name="employee_id" class="form-select">
            <option value="">Pilih pegawai</option>
            @foreach ($employees as $employee)
                <option value="{{ $employee->id }}" @selected(($usesOldInput ? old('employee_id') : $currentMedicalRecord?->employee_id) == $employee->id)>
                    {{ $employee->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-4 mb-3">
        <label for="{{ $fieldPrefix }}_treatment_date" class="form-label">Tanggal <span class="text-danger">*</span></label>
        <input type="date" id="{{ $fieldPrefix }}_treatment_date" required name="treatment_date" class="form-control" value="{{ $usesOldInput ? old('treatment_date') : ($currentMedicalRecord?->treatment_date?->format('Y-m-d') ?? date('Y-m-d')) }}">
    </div>

    <div class="col-md-12 mb-3">
        <label class="form-label text-muted small uppercase fw-bold">Keluhan</label>
        <textarea name="complaint" rows="3" class="form-control" placeholder="Tuliskan keluhan pasien..." required>{{ $currentMedicalRecord?->complaint }}</textarea>
    </div>

    <!-- BAGIAN DINAMIS TREATMENT -->
    <div class="col-12 mb-3">
        <div class="card border shadow-none">
            <div class="card-header d-flex justify-content-between align-items-center bg-light py-2">
                <h6 class="mb-0 fw-bold">Detail Layanan</h6>
                <button type="button" class="btn btn-sm btn-primary" id="add-treatment-row">
                    <i class="ri-add-line"></i> Tambah Item Teratas
                </button>
            </div>
            <div class="card-body p-0">
                <!-- Datalist untuk pilihan layanan dari database -->
                <datalist id="list-layanan">
                    @foreach($treatments as $t)
                        <option value="{{ $t->name }}" data-price="{{ $t->price }}">
                    @endforeach
                </datalist>

                <div class="table-responsive">
                    <table class="table align-middle mb-0" id="treatment-table">
                        <thead class="table-light text-nowrap">
                            <tr>
                                <th style="min-width: 220px;">Layanan (Pilih/Ketik Bebas)</th>
                                <th style="width: 80px;">Qty</th>
                                <th style="min-width: 140px;">Harga Satuan</th>
                                <th style="min-width: 140px;">Diskon (Rp)</th>
                                <th style="min-width: 140px;">Subtotal</th>
                                <th style="width: 40px;"></th>
                            </tr>
                        </thead>
                        <tbody id="treatment-items">
                            <!-- Row baru akan muncul di sini (posisi paling atas) -->
                        </tbody>
                        <tfoot class="table-light text-nowrap">
                            <tr>
                                <th colspan="4" class="text-end text-muted fw-normal">Total Tagihan:</th>
                                <th colspan="2">
                                    <h5 class="mb-0 text-primary fw-bold" id="grand-total-text">Rp 0</h5>
                                    <input type="hidden" name="total_cost" id="grand-total-value">
                                </th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tbody = document.getElementById('treatment-items');
    const btnAdd = document.getElementById('add-treatment-row');
    const grandTotalText = document.getElementById('grand-total-text');
    const grandTotalValue = document.getElementById('grand-total-value');
    const datalistLayanan = document.getElementById('list-layanan');

    // Fungsi untuk menambah baris
    function addRow() {
        const index = Date.now() + Math.floor(Math.random() * 1000);
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>
                <input list="list-layanan" name="treatments[${index}][name]" class="form-control form-control-sm name-input" placeholder="Cari layanan..." required>
            </td>
            <td>
                <input type="number" name="treatments[${index}][qty]" class="form-control form-control-sm qty-input text-center" value="1" min="1">
            </td>
            <td>
                <div class="input-group input-group-sm">
                    <span class="input-group-text">Rp</span>
                    <input type="text" name="treatments[${index}][price]" class="form-control price-input js-currency-input" placeholder="0">
                </div>
            </td>
            <td>
                <div class="input-group input-group-sm">
                    <span class="input-group-text">Rp</span>
                    <input type="text" name="treatments[${index}][discount]" class="form-control discount-input js-currency-input text-danger fw-medium" placeholder="0" value="0">
                </div>
            </td>
            <td>
                <input type="text" class="form-control form-control-sm subtotal-display border-0 bg-transparent fw-bold" readonly value="Rp 0">
                <input type="hidden" class="subtotal-value" value="0">
            </td>
            <td class="text-center">
                <button type="button" class="btn btn-link text-danger remove-row p-0">
                    <i class="ti ti-trash fs-lg"></i>
                </button>
            </td>
        `;
        
        tbody.prepend(row);
    }

    // Inisialisasi: Hanya tambah baris jika tbody kosong
    if (tbody.children.length === 0) {
        addRow();
    }

    // Handle Tombol Tambah (Cegah duplikasi dengan stopPropagation)
    btnAdd.onclick = function(e) {
        e.preventDefault();
        e.stopPropagation();
        addRow();
    };

    // EVENT DELEGATION: Menangani Input dan Klik Hapus di dalam tbody
    tbody.addEventListener('click', function(e) {
        // Cari apakah yang diklik adalah tombol hapus atau ikon di dalamnya
        const btnRemove = e.target.closest('.remove-row');
        if (btnRemove) {
            e.preventDefault();
            // Pastikan minimal ada 1 baris tersisa
            if (tbody.querySelectorAll('tr').length > 1) {
                btnRemove.closest('tr').remove();
                calculateGrandTotal();
            } else {
                alert('Minimal harus ada satu item layanan.');
            }
        }
    });

    tbody.addEventListener('input', function(e) {
        const row = e.target.closest('tr');
        if (!row) return;

        // Auto-fill harga dari datalist
        if (e.target.classList.contains('name-input')) {
            const val = e.target.value;
            const option = Array.from(datalistLayanan.options).find(opt => opt.value === val);
            if (option) {
                const price = option.getAttribute('data-price');
                const priceInput = row.querySelector('.price-input');
                priceInput.value = new Intl.NumberFormat('id-ID').format(price);
            }
        }

        // Format Currency & Hitung Row
        if (e.target.classList.contains('js-currency-input')) {
            let value = e.target.value.replace(/[^0-9]/g, '');
            e.target.value = value ? new Intl.NumberFormat('id-ID').format(value) : '';
        }

        calculateRow(row);
    });

    function calculateRow(row) {
        const qty = parseFloat(row.querySelector('.qty-input').value) || 0;
        const price = parseNumber(row.querySelector('.price-input').value) || 0;
        const discount = parseNumber(row.querySelector('.discount-input').value) || 0;
        
        const subtotal = (qty * price) - discount;
        const subtotalFinal = subtotal < 0 ? 0 : subtotal;

        row.querySelector('.subtotal-display').value = formatRupiah(subtotalFinal);
        row.querySelector('.subtotal-value').value = subtotalFinal;
        
        calculateGrandTotal();
    }

    function calculateGrandTotal() {
        let total = 0;
        tbody.querySelectorAll('.subtotal-value').forEach(el => {
            total += parseFloat(el.value) || 0;
        });
        grandTotalText.innerText = formatRupiah(total);
        grandTotalValue.value = total;
    }

    function parseNumber(str) {
        return parseFloat(str.replace(/[^0-9]/g, '')) || 0;
    }

    function formatRupiah(num) {
        return 'Rp ' + new Intl.NumberFormat('id-ID').format(num);
    }
});
</script>