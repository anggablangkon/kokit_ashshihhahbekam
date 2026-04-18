function formatTanggalIndo(tanggalISO) {
    if (!tanggalISO) return '-';

    const bulanIndo = [
        "Januari", "Februari", "Maret", "April", "Mei", "Juni",
        "Juli", "Agustus", "September", "Oktober", "November", "Desember"
    ];

    const dateObj = new Date(tanggalISO);
    const hari = String(dateObj.getDate()).padStart(2, '0');
    const bulan = bulanIndo[dateObj.getMonth()];
    const tahun = dateObj.getFullYear();

    // jam ke WIB
    const jam = String(dateObj.getHours()).padStart(2, '0');
    const menit = String(dateObj.getMinutes()).padStart(2, '0');

    return `${hari} ${bulan} ${tahun} ${jam}:${menit}`;
}
