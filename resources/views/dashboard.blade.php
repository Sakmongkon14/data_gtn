@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">

    <div class="container-fluid mt-4">
        <div class="row">
            <!-- Card 1: ข้อมูลทั้งหมด -->
            <div class="col-md-6">
                <div class="card shadow h-100 d-flex flex-column">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">Summary Balance Information</h5>
                    </div>
                    <div class="card-body flex-grow-1" style="min-height: 400px;">
                        @php
                            $items = [
                                ['title' => 'Balance Invoice', 'value' => $in, 'icon' => 'fa-dollar-sign', 'color' => '#28a745'],
                                ['title' => 'Balance SAQ', 'value' => $saq, 'icon' => 'fa-dollar-sign', 'color' => '#ffc107'],
                                ['title' => 'Balance CR', 'value' => $cr, 'icon' => 'fa-dollar-sign', 'color' => '#dc3545'],
                                ['title' => 'Balance TSSR', 'value' => $tssr, 'icon' => 'fa-dollar-sign', 'color' => '#17a2b8'],
                                ['title' => 'Balance Civilwork', 'value' => $cw, 'icon' => 'fa-dollar-sign', 'color' => '#6c757d'],
                            ];
                        @endphp
    
                        @foreach ($items as $item)
                        <div class="mb-3 p-3 rounded shadow-sm" style="border-left: 5px solid {{ $item['color'] }};">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <div class="text-xs font-weight-bold text-uppercase" style="color: {{ $item['color'] }};">
                                        {{ $item['title'] }}
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $item['value'] }}</div>
                                </div>
                                <div>
                                    <i class="fas {{ $item['icon'] }} fa-2x" style="color: {{ $item['color'] }};"></i>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
    
            <!-- Card 2: กราฟ -->
            <div class="col-md-6">
                <div class="card shadow h-100 d-flex flex-column">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Data Visualization</h5>
                    </div>
                    <div class="card-body d-flex justify-content-center align-items-center flex-grow-1" style="min-height: 400px;">
                        <canvas id="dataChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        var ctx = document.getElementById("dataChart").getContext("2d");
        var dataChart = new Chart(ctx, {
            type: "bar",
            data: {
                labels: ["INVOICE", "SAQ", "CR", "TSSR", "CIVILWORK"],
                datasets: [{
                    label: "Balance Amount",
                    data: [{{ $in }}, {{ $saq }}, {{ $cr }}, {{ $tssr }}, {{ $cw }}],
                    backgroundColor: ["#28a745", "#ffc107", "#dc3545", "#17a2b8", "#6c757d"]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    });
    </script>
    

@endsection
