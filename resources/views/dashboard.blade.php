@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" >
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">

    <style>
        .dashboard-card {
            border-radius: 12px;
            overflow: hidden;
            transition: box-shadow 0.3s ease;
        }
        .dashboard-card:hover {
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
        }
        .chart-container {
            min-height: 400px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .data-box {
            border-left: 6px solid;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 2px 4px 8px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: box-shadow 0.3s ease;
        }
        .data-box:hover {
            box-shadow: 2px 6px 12px rgba(0, 0, 0, 0.2);
        }
        .icon-container {
            font-size: 2rem;
        }
    </style>

    <div class="container-fluid mt-4">
        <div class="row g-4">
            <!-- Card: Pie Chart -->
            <div class="col-md-4">
                <div class="card dashboard-card shadow h-100">
                    <div class="card-header bg-warning text-white text-center">
                        <h5 class="mb-0">Balance Distribution</h5>
                    </div>
                    <div class="card-body chart-container">
                        <canvas id="pieChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Card: Summary Balance Information -->
            <div class="col-md-4">
                <div class="card dashboard-card shadow h-100">
                    <div class="card-header bg-success text-white text-center">
                        <h5 class="mb-0">Summary Balance</h5>
                    </div>
                    <div class="card-body">
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
                            <div class="data-box mb-3" style="border-color: {{ $item['color'] }};">
                                <div>
                                    <div class="text-uppercase fw-bold" style="color: {{ $item['color'] }};">{{ $item['title'] }}</div>
                                    <div class="h5 fw-bold text-dark">{{ $item['value'] }}</div>
                                </div>
                                <div class="icon-container">
                                    <i class="fas {{ $item['icon'] }}" style="color: {{ $item['color'] }};"></i>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Card: Bar Chart -->
            <div class="col-md-4">
                <div class="card dashboard-card shadow h-100">
                    <div class="card-header bg-primary text-white text-center">
                        <h5 class="mb-0">Balance Overview</h5>
                    </div>
                    <div class="card-body chart-container">
                        <canvas id="barChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var barCtx = document.getElementById("barChart").getContext("2d");
            var barChart = new Chart(barCtx, {
                type: "bar",
                data: {
                    labels: ["INVOICE", "SAQ", "CR", "TSSR", "CIVILWORK"],
                    datasets: [{
                        label: "Balance Amount",
                        data: [{{ $in }}, {{ $saq }}, {{ $cr }}, {{ $tssr }}, {{ $cw }}],
                        backgroundColor: ["#28a745", "#ffc107", "#dc3545", "#17a2b8", "#6c757d"],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: { beginAtZero: true }
                    }
                }
            });

            var pieCtx = document.getElementById("pieChart").getContext("2d");
            var pieChart = new Chart(pieCtx, {
                type: "pie",
                data: {
                    labels: ["INVOICE", "SAQ", "CR", "TSSR", "CIVILWORK"],
                    datasets: [{
                        data: [{{ $in }}, {{ $saq }}, {{ $cr }}, {{ $tssr }}, {{ $cw }}],
                        backgroundColor: ["#28a745", "#ffc107", "#dc3545", "#17a2b8", "#6c757d"],
                        hoverOffset: 5
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
