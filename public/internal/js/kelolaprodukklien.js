
    function konfirmasiHapusProduk(id, nama) {
        Swal.fire({
            title: 'Yakin hapus produk ini?',
            text: 'Produk: ' + nama,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('formHapusProduk' + id).submit();
            }
        });
    }

    function isiFormEdit(id, nama_klien, jenis_produk, qty, keterangan) {
        document.getElementById('edit_id').value = id;
        document.getElementById('edit_nama_klien').value = nama_klien;
        document.getElementById('edit_jenis_produk').value = jenis_produk;
        document.getElementById('edit_qty').value = formatRibuan(qty);
        document.getElementById('edit_keterangan').value = keterangan;
    }

    function formatRibuan(angka) {
        let value = angka.toString().replace(/[^0-9]/g, '');
        return value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    // Tambahkan event listener untuk qtykedatangan agar card merah muncul jika qty > sisa
    const qtyInput = document.getElementById("qtykedatangan");
    const alertQty = document.getElementById("alertQtyKedatangan");
    const sisaQtyText = document.getElementById("sisaQtyText");
    if (qtyInput && alertQty && sisaQtyText) {
        qtyInput.addEventListener('input', function() {
            const sisa = parseInt(qtyInput.getAttribute("data-sisa") || '0');
            const qty = parseInt(qtyInput.value || '0');
            sisaQtyText.textContent = sisa;
            if (qty > sisa) {
                alertQty.style.display = '';
            } else {
                alertQty.style.display = 'none';
            }
        });
    }



    document.addEventListener('DOMContentLoaded', function() {
        // Modal Tambah Data
        var tambahDataModal = document.getElementById('tambahDataModal');
        if (tambahDataModal) {
            tambahDataModal.addEventListener('shown.bs.modal', function () {
                document.getElementById('nama_klien').focus();
            });
        }
    
        // Modal Edit Produk Klien
        var editProdukModal = document.getElementById('editProdukModal');
        if (editProdukModal) {
            editProdukModal.addEventListener('shown.bs.modal', function () {
                document.getElementById('edit_nama_klien').focus();
            });
        }
    });

    
function editProduk(id) {
    fetch('/produk/ajax-klien/' + btoa(id))
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                document.getElementById('edit_id').value = data.data.id;
                document.getElementById('edit_nama_klien').value = data.data.nama_klien;
                document.getElementById('edit_jenis_produk').value = data.data.jenis_produk;
                document.getElementById('edit_qty').value = data.data.qty;
                document.getElementById('edit_keterangan').value = data.data.keterangan;
                new bootstrap.Modal(document.getElementById('editProdukModal')).show();
            } else {
                Swal.fire('Gagal', 'Data tidak ditemukan', 'error');
            }
        });
}

// Event submit form edit produk klien
if(document.getElementById('formEditProduk')) {
    document.getElementById('formEditProduk').addEventListener('submit', function(e) {
        e.preventDefault();
        const id = document.getElementById('edit_id').value;
        const qtyInput = document.getElementById('edit_qty');
        const formData = new FormData(this);
        // Pastikan qty tanpa titik
        formData.set('qty', qtyInput.value.replace(/\./g, ''));
        fetch('/produk-klien/' + id, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                Swal.fire('Berhasil', data.message, 'success');
                ajaxGetHardcoded();
                bootstrap.Modal.getInstance(document.getElementById('editProdukModal')).hide();
            } else {
                Swal.fire('Gagal', data.message, 'error');
            }
        });
    });
}

// Format qty
        document.addEventListener('DOMContentLoaded', function() {
            var qtyInput = document.getElementById('qty');
            if (qtyInput) {
                qtyInput.addEventListener('input', function(e) {
                    // Hanya angka
                    let value = this.value.replace(/[^0-9]/g, '');
                    // Format ribuan
                    this.value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                });

                // Saat submit, hapus titik agar backend dapat angka asli
                var form = qtyInput.closest('form');
                if (form) {
                    form.addEventListener('submit', function(e) {
                        qtyInput.value = qtyInput.value.replace(/\./g, '');
                    });
                }
            }
        });
        document.addEventListener('DOMContentLoaded', function() {
            var editQtyInput = document.getElementById('edit_qty');
            if (editQtyInput) {
                editQtyInput.addEventListener('input', function(e) {
                    // Hanya angka
                    let value = this.value.replace(/[^0-9]/g, '');
                    // Format ribuan
                    this.value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                });

                // Saat submit, hapus titik agar backend dapat angka asli
                var form = document.getElementById('formEditProduk');
                if (form) {
                    form.addEventListener('submit', function(e) {
                        editQtyInput.value = editQtyInput.value.replace(/\./g, '');
                    });
                }
            }
        });

document.addEventListener('DOMContentLoaded', function() {
    var qtyTerkirimInput = document.getElementById('qtykedatangan');
    if (qtyTerkirimInput) {
        qtyTerkirimInput.addEventListener('input', function(e) {
            let value = this.value.replace(/[^0-9]/g, '');
            this.value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        });

        var form = document.getElementById('formKedatangan');
        if (form) {
            form.addEventListener('submit', function(e) {
                qtyTerkirimInput.value = qtyTerkirimInput.value.replace(/\./g, '');
            });
        }
    }
});