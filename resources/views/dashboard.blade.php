@extends('layouts.layout')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                    class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
        </div>

        <!-- Content Row -->
        <div class="row">

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Pemasukan Bulanan</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    @php
                                        foreach ($dataMasuk as $das) {
                                            echo 'Rp. ' . number_format($das->jumlah, 0, ',', '.');
                                        }
                                    @endphp
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-calendar fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Pengeluaran Bulanan</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    @php
                                        foreach ($dataKeluar as $dak) {
                                            echo 'Rp. ' . number_format($dak->jumlah, 0, ',', '.');
                                        }
                                    @endphp
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    Total Pemasukan
                                </div>
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                        @php
                                            foreach ($totalMasuk as $tom) {
                                                echo 'Rp. ' . number_format($tom->jumlah, 0, ',', '.');
                                            }
                                        @endphp
                                    </div>
                                </div>

                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pending Requests Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Total Pengeluaran</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    @php
                                        foreach ($totalKeluar as $tok) {
                                            echo 'Rp. ' . number_format($tok->jumlah, 0, ',', '.');
                                        }
                                    @endphp
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-comments fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Row -->

        <div class="row">

            <!-- Area Chart -->
            <div class="col-xl-8 col-lg-7">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Earnings Overview</h6>

                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <canvas id="myChart"></canvas>

                        {{-- <script>
                                        var ctx = document.getElementById('myChart').getContext('2d');
                                        var myChart = new Chart(ctx, {
                                            type: 'pie',
                                            data: {!! json_encode($data) !!}
                                            });
                                    </script> --}}
                    </div>
                </div>
            </div>

            <!-- Pie Chart -->
            <div class="col-xl-4 col-lg-5">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Revenue Sources</h6>
                        <form method="GET" action="">
                            <select name="timeframe" onchange="this.form.submit()">
                                <option value="monthly" {{ Request('timeframe') == 'monthly' ? 'selected' : '' }}>Bulan Ini
                                </option>
                                <option value="yearly" {{ Request('timeframe') == 'yearly' ? 'selected' : '' }}>Tahun Ini
                                </option>
                                <option value="all" {{ Request('timeframe') == 'all' ? 'selected' : '' }}>Semua</option>
                            </select>
                        </form>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <div class="chart-pie pt-4 pb-2">
                            <canvas id="revenueChart"></canvas>

                            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                            <script>
                                const ctx = document.getElementById('revenueChart').getContext('2d');
                                const chart = new Chart(ctx, {
                                    type: 'doughnut',
                                    data: {
                                        labels: ['Pemasukan', 'Pengeluaran'],
                                        datasets: [{
                                            data: [{{ $uangMasuk }}, {{ $uangKeluar }}],
                                            backgroundColor: ['#36A2EB', '#FF6384'],
                                        }]
                                    },
                                    options: {
                                        responsive: true,
                                        plugins: {
                                            legend: {
                                                position: 'bottom'
                                            },
                                        }
                                    }
                                });
                            </script>
                        </div>
                        {{-- <div class="mt-4 text-center small">
                                        <span class="mr-2">
                                            <i class="fas fa-circle text-primary"></i> Direct
                                        </span>
                                        <span class="mr-2">
                                            <i class="fas fa-circle text-success"></i> Social
                                        </span>
                                        <span class="mr-2">
                                            <i class="fas fa-circle text-info"></i> Referral
                                        </span>
                                    </div> --}}
                    </div>
                </div>
            </div>
        </div>



    </div>
    <!-- /.container-fluid -->
@endsection
