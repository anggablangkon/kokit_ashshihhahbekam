@extends('layouts.layouts')
@section('title', 'Halaman Dashboard')

@section('content')
<style>
    /* Mencegah overflow pada card body */
    .card-body {
        overflow: hidden;
    }
    
    /* Responsivitas tinggi grafik untuk mobile */
    @media (max-width: 576px) {
        #grafik_utama, #grafik_pie, #grafik_pasien_aktif, #grafik_pegawai_aktif {
            height: 300px !important;
        }
        .card-body {
            padding: 10px !important;
        }
    }
</style>

<div class="container-fluid">

    <div class="page-title-head d-flex align-items-center">
        <div class="flex-grow-1">
            <h4 class="fs-sm text-uppercase fw-bold m-0">Dashboard</h4>
        </div>
    </div>

    <!-- ROW 1: STATISTIC CARDS -->
    <div class="row g-3">
        <div class="col-6 col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <p class="text-muted mb-1 fw-medium">Total Omzet Bulan Ini</p>
                    <h4 class="mb-0 text-success" id="card-omzet">Rp 0</h4>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <p class="text-muted mb-1 fw-medium">Pasien Baru (Bulan Ini)</p>
                    <h4 class="mb-0 text-primary" id="card-pasien">0</h4>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <p class="text-muted mb-1 fw-medium">Total Kunjungan</p>
                    <h4 class="mb-0 text-info" id="card-kunjungan">0</h4>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <p class="text-muted mb-1 fw-medium">Estimasi Gaji & Komisi</p>
                    <h4 class="mb-0 text-danger" id="card-payroll">Rp 0</h4>
                </div>
            </div>
        </div>
    </div>

    <!-- ROW 2: PIE CHARTS (3 KOLOM) -->
    <div class="row mt-1 g-3">
        <div class="col-12 col-md-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header border-dashed">
                    <h4 class="card-title mb-0">Populasi Treatment</h4>
                </div>
                <div class="card-body">
                    <div id="grafik_pie" style="width:100%; height:400px;"></div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header border-dashed d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h4 class="card-title mb-0">Populasi Pasien Aktif</h4>
                    </div>
                    <span class="badge bg-soft-primary text-primary">Live Data</span>
                </div>
                <div class="card-body">
                    <div id="grafik_pasien_aktif" style="width:100%; height:400px;"></div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header border-dashed d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h4 class="card-title mb-0">Populasi Pegawai Aktif</h4>
                    </div>
                    <span class="badge bg-soft-success text-success">Internal</span>
                </div>
                <div class="card-body">
                    <div id="grafik_pegawai_aktif" style="width:100%; height:400px;"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- ROW 3: BAR CHART -->
    <div class="row mt-1 g-3">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header border-dashed">
                    <h4 class="card-title">Grafik Pendapatan Tahun {{date('Y')}}</h4>
                </div>
                <div class="card-body">
                    <div id="grafik_utama" style="width:100%; height:400px;"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const mainChart = echarts.init(document.getElementById('grafik_utama'));
        const pieChart = echarts.init(document.getElementById('grafik_pie'));
        const pasienChart = echarts.init(document.getElementById('grafik_pasien_aktif'));
        const pegawaiChart = echarts.init(document.getElementById('grafik_pegawai_aktif'));

        // Fungsi helper untuk opsi Pie
        const createPieOption = (name, data, colors) => ({
            color: colors,
            tooltip: { trigger: 'item' },
            legend: { bottom: '0%', fontSize: 10 },
            series: [{
                name: name,
                type: 'pie',
                radius: ['40%', '70%'],
                itemStyle: { borderRadius: 10, borderColor: '#fff', borderWidth: 2 },
                label: { show: false },
                emphasis: { label: { show: true, fontSize: '15', fontWeight: 'bold' } },
                data: data
            }]
        });

        const renderAllCharts = (res) => {
            // Opsi Bar Chart
            mainChart.setOption({
                tooltip: { trigger: 'axis', axisPointer: { type: 'shadow' } },
                grid: { left: '3%', right: '4%', bottom: '3%', containLabel: true },
                xAxis: { 
                    type: 'category', 
                    data: res.labels || ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                    axisLabel: { interval: 0, rotate: 30, fontSize: 11 }
                },
                yAxis: { 
                    type: 'value', 
                    axisLabel: { formatter: (v) => v >= 1000000 ? 'Rp ' + (v/1000000) + 'jt' : 'Rp ' + v.toLocaleString('id-ID') } 
                },
                series: [{
                    name: 'Pendapatan',
                    type: 'bar',
                    data: res.data || [0,0,0,0,0,0,0,0,0,0,0,0],
                    barMaxWidth: 40,
                    itemStyle: { 
                        borderRadius: [5, 5, 0, 0],
                        color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [
                            { offset: 0, color: '#3498db' }, { offset: 1, color: '#2980b9' }
                        ])
                    }
                }]
            });

            // Render Pie Charts
            pieChart.setOption(createPieOption('Treatment', res.pie_data || [], ['#3498db', '#2980b9', '#5dade2']));
            pasienChart.setOption(createPieOption('Pasien', res.pasien_data || [], ['#2ecc71', '#27ae60', '#a2d9ce']));
            pegawaiChart.setOption(createPieOption('Pegawai', res.pegawai_data || [], ['#f1c40f', '#f39c12', '#f5b041']));

            if(res.stats) {
                document.getElementById('card-omzet').innerText = res.stats.total_omzet;
                document.getElementById('card-pasien').innerText = res.stats.pasien_baru;
                document.getElementById('card-kunjungan').innerText = res.stats.total_kunjungan;
                document.getElementById('card-payroll').innerText = res.stats.estimasi_gaji;
            }
        };

        // DATA SAMPLE (Akan muncul jika fetch gagal atau data kosong)
        const sampleData = {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
            data: [1200000, 2100000, 1500000, 3000000, 2400000, 4000000, 3500000, 4200000, 4800000, 4500000, 5500000, 6800000],
            pie_data: [{value: 40, name: 'Bekam'}, {value: 30, name: 'Pijat'}, {value: 30, name: 'Lainnya'}],
            pasien_data: [{value: 100, name: 'Aktif'}, {value: 20, name: 'Baru'}],
            pegawai_data: [{value: 10, name: 'Terapis'}, {value: 3, name: 'Admin'}],
            stats: { total_omzet: "Rp 6.800.000", pasien_baru: "20", total_kunjungan: "120", estimasi_gaji: "Rp 1.500.000" }
        };

        fetch('/grafikdashboard')
            .then(response => response.json())
            .then(res => {
                // Jika data dari server ada, gunakan itu. Jika tidak, pakai sample.
                if (res && res.data) { renderAllCharts(res); } 
                else { renderAllCharts(sampleData); }
            })
            .catch(() => {
                console.warn("Menggunakan data sample karena gagal fetch.");
                renderAllCharts(sampleData);
            });

        window.addEventListener('resize', () => {
            mainChart.resize(); pieChart.resize(); pasienChart.resize(); pegawaiChart.resize();
        });
    });
</script>
@endsection