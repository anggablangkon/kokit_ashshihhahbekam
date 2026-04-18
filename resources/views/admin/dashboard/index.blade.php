@extends('layouts.layouts')
@section('title', 'Halaman Dashboard')

@section('content')
<div class="container-fluid">

    <div class="page-title-head d-flex align-items-center">
        <div class="flex-grow-1">
            <h4 class="fs-sm text-uppercase fw-bold m-0">Dashboard</h4>
        </div>

        <div class="text-end">
            <ol class="breadcrumb m-0 py-0">
                <li class="breadcrumb-item"><a href="javascript: void(0);">Sistem</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-12">

            <div class="card">
                <div class="card-header border-dashed card-tabs d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h4 class="card-title">Pencapaian pertahun {{date('Y')}}</h4>
                    </div>
                </div>

                <div class="card-body p-0">
                    <div class="row g-0">
                        <div class="col-xxl-12 border-end border-dashed">
                            <div id="grafik" style="width:100%; height:400px;"></div>
                        </div><!-- end col -->
                        <!-- <div class="col-xxl-4" id="SummaryData"> </div>  -->

                    </div> <!-- end row-->
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col-->
    </div> <!-- end row-->
</div>

<script>
    document.addEventListener("DOMContentLoaded", () => {
    const chartDom = document.getElementById('grafik');
    const myChart = echarts.init(chartDom);

    fetch('/grafikdashboard')
        .then(response => response.json())
        .then(res => {
            const option = {
                tooltip: {
                    trigger: 'axis'
                },
                xAxis: {
                    type: 'category',
                    data: res.labels
                },
                yAxis: {
                    type: 'value'
                },
                series: [{
                    name: 'Rupiah',
                    type: 'bar',
                    data: res.data,
                    itemStyle: {
                        color: '#e74c3c' // merah
                    }
                }]
            };

            myChart.setOption(option);
        })
        .catch(err => console.error("Error load data:", err));
});
</script>
@endsection