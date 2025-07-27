@foreach ($produkKlien as $produk)
    <tr class="produk-row">
        <td>
            <div class="d-flex align-items-center">
                <div>
                    <h5 class="fs-base">{{ $produk->nama_klien }} -
                        {{ strtoupper($produk->jenis_produk) }}</h5>
                </div>
            </div>
        </td>
        <td>
            <h5 class="fs-base mt-1 fw-normal">
                {{ $produk->no_po }}
            </h5>
        </td>
        <td>
            <h5 class="fs-base mt-1 fw-normal">
                <button data-token="{{ encrypt($produk->id) }}"
                    data-sisa="{{ $produk->qty - $produk->qty_terkirim_aktif }}" id="Modal{{ $loop->iteration }}"
                    onclick="tambahKedatangan({{ $loop->iteration }})" class="btn btn-sm btn-info btn-kedatangan">
                    <i class="ti ti-plus me-1"></i> Terkirim
                </button>
            </h5>
        </td>
        <td>
            <h5 class="fs-base mt-1 fw-normal">{{ angka($produk->qty) }}</h5>
        </td>
        <td>
            <h5 class="fs-base mt-1 fw-normal">{{ angka($produk->qty_terkirim_aktif) }}</h5>
        </td>
        <td>
            <h5 class="fs-base mt-1 fw-normal">{{ angka($produk->qty - $produk->qty_terkirim_aktif) }}</h5>
        </td>
        <td>
            @php
                $totalQty = $produk->qty;
                $terkirim = $produk->qty_terkirim_aktif;
                $progres = $totalQty > 0 ? ($terkirim / $totalQty) * 100 : 0;
                $sisa = 100 - $progres;
            @endphp
            <div style="width: 100%;">
                <div class="progress" style="height: 8px; margin-left: 10px;">
                    <div class="progress-bar bg-success" role="progressbar" style="width: {{ $progres }}%"
                        aria-valuenow="{{ $progres }}" aria-valuemin="0" aria-valuemax="100"></div>
                    <div class="progress-bar bg-danger" role="progressbar" style="width: {{ $sisa }}%"
                        aria-valuenow="{{ $sisa }}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>

                <small class="d-block mt-1" style="margin-left: 10px; white-space: nowrap;">
                    {{ round($progres, 1) }}% ({{ $terkirim }}/{{ $totalQty }})
                </small>
            </div>

        </td>
        <td>
            <h5 class="fs-base mt-1 fw-normal">
                <i class="ti ti-circle-filled fs-xs {{ $progres >= 100 ? 'text-success' : 'text-danger' }}"></i>
                {{ $progres >= 100 ? 'Selesai' : 'Belum Selesai' }}
            </h5>
        <td style="width: 30px;">
            <div class="dropdown">
                <a href="#" class="dropdown-toggle text-muted drop-arrow-none card-drop p-0"
                    data-bs-toggle="dropdown">
                    <i class="ti ti-dots-vertical fs-lg"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-end">
                    <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#editProdukModal"
                        onclick="isiFormEdit({{ $produk->id }}, '{{ addslashes($produk->nama_klien) }}', '{{ $produk->jenis_produk }}', {{ $produk->qty }}, '{{ addslashes($produk->keterangan) }}')">Edit</a>
                    <a href="{{ route('terkirim.index', encrypt($produk->id)) }}" class="dropdown-item">Terkirim</a>
                    <form id="formHapusProduk{{ $produk->id }}"
                        action="{{ route('produk-klien.destroy', $produk->id) }}" method="POST"
                        style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="dropdown-item text-danger"
                            onclick="konfirmasiHapusProduk({{ $produk->id }}, '{{ $produk->nama_klien }}')">Hapus</button>
                    </form>
                </div>
            </div>
        </td>
    </tr>
@endforeach

<!-- Modal Edit Produk Klien -->
<div class="modal fade" id="editProdukModal" tabindex="-1" aria-labelledby="editProdukModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="formEditProduk" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProdukModalLabel">Edit Produk Klien</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="edit_id">
                    <div class="mb-3">
                        <label>Nama Klien</label>
                        <input type="text" class="form-control" name="nama_klien" id="edit_nama_klien" required>
                    </div>
                    <div class="mb-3">
                        <label>Jenis Produk</label>
                        <select class="form-control" name="jenis_produk" id="edit_jenis_produk" required>
                            <option value="CK">CK</option>
                            <option value="BT">BT</option>
                            <option value="BE">BE</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Qty</label>
                        <input type="text" class="form-control" name="qty" id="edit_qty" required>
                    </div>
                    <div class="mb-3">
                        <label>Keterangan</label>
                        <textarea class="form-control" name="keterangan" id="edit_keterangan"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>
