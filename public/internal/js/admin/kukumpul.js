document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.btn-view').forEach(btn => {
            btn.addEventListener('click', async function (e) {
                e.preventDefault();

                const id = this.dataset.id;
                const url = this.getAttribute('href');

            // Set loading state di modal
                document.getElementById('modalDetailContent').innerHTML = `
                <div class="text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2">Memuat data...</p>
                </div>
                `;

            // Tampilkan modal
                const modal = new bootstrap.Modal(document.getElementById('modalDetail'));
                modal.show();

                try {
                    const res = await fetch(url, {
                        method: 'GET',
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });

                    if (!res.ok) {
                        throw new Error(`HTTP error! status: ${res.status}`);
                    }

                    const data = await res.json();

                // Render isi modal dari data JSON
                    document.getElementById('modalDetailContent').innerHTML = `
                    <table class="table table-bordered">
                        <tr><th>Invoice</th><td>${data.invoice}</td></tr>
                        <tr><th>Nama</th><td>${data.nama}</td></tr>
                        <tr><th>Email</th><td>${data.email ?? '-'}</td></tr>
                        <tr><th>No HP</th><td>${data.nohp}</td></tr>
                        <tr><th>Nominal</th><td>Rp. ${Number(data.rupiah).toLocaleString('id-ID')}</td></tr>
                        <tr><th>Status</th><td>${data.status}</td></tr>
                        <tr><th>Dukungan</th><td>${data.keterangan ?? '-'}</td></tr>
                        <tr><th>Tanggal</th><td>${formatTanggalIndo(data.created_at)}</td></tr>
                    </table>
                    `;
                } catch (err) {
                    document.getElementById('modalDetailContent').innerHTML = `
                    <div class="alert alert-danger">Gagal memuat data: ${err.message}</div>
                    `;
                }
            });
        });
    });
