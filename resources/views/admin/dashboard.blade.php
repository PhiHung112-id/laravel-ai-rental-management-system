@extends('admin.layouts.app')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
    .dashboard-premium-wrapper {
        min-height: calc(100vh - 60px);
        padding-top: 20px;
    }

    .container-fluid {
        font-family: 'Poppins', sans-serif;
    }

    .dashboard-title {
        font-weight: 700;
        color: #4e73df;
        margin-bottom: 5px;
        font-size: 1.5rem;
    }

    .dashboard-subtitle {
        color: #94a3b8;
        font-size: 0.95rem;
        margin-bottom: 30px;
    }

    .summary-card {
        border: none;
        border-radius: 20px;
        color: white;
        position: relative;
        overflow: hidden;
        min-height: 180px;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.04);
        cursor: pointer;
    }

    .summary-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
    }

    .bg-grad-1 { background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); }
    .bg-grad-2 { background: linear-gradient(135deg, #10b981 0%, #059669 100%); }
    .bg-grad-3 { background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); }

    .card-content {
        position: relative;
        z-index: 2;
        padding: 25px;
        width: 100%;
    }

    .summary-num {
        font-size: 2.4rem;
        font-weight: 700;
        margin-bottom: 5px;
        line-height: 1;
        text-shadow: 0 2px 5px rgba(0, 0, 0, 0.08);
    }

    .summary-label {
        font-size: 0.9rem;
        font-weight: 600;
        opacity: 0.9;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .icon-bg {
        position: absolute;
        right: -10px;
        bottom: -10px;
        font-size: 8rem;
        opacity: 0.12;
        transform: rotate(-15deg);
        transition: all 0.3s ease;
        z-index: 1;
    }

    .summary-card:hover .icon-bg {
        transform: rotate(0deg) scale(1.1);
        opacity: 0.18;
    }

    .icon-circle {
        width: 50px;
        height: 50px;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(5px);
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        margin-bottom: 15px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
    }

    .chart-card {
        border: none;
        border-radius: 20px;
        background: white;
        padding: 25px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.04);
        height: 100%;
    }

    .chart-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
    }

    .chart-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #1e293b;
        position: relative;
        padding-left: 15px;
    }

    .chart-title::before {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 5px;
        height: 20px;
        background: #4e73df;
        border-radius: 10px;
    }

    body.dark-mode .chart-card {
        background: #1a233a !important;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15) !important;
    }

    body.dark-mode .chart-title {
        color: #f1f5f9 !important;
    }

    body.dark-mode .border-right {
        border-right-color: #222d4a !important;
    }
</style>
@endpush

@section('content')
<div class="dashboard-premium-wrapper">
    <div class="container-fluid p-4">

        <div class="row">
            <div class="col-12">
                <h3 class="dashboard-title">Tổng quan hệ thống</h3>
                <p class="dashboard-subtitle">
                    Chào mừng trở lại! Dưới đây là báo cáo hoạt động kinh doanh của bạn.
                </p>
            </div>
        </div>

        <div class="row d-flex align-items-stretch">

            <div class="col-md-4 mb-4">
                <div class="summary-card bg-grad-1" onclick="location.href='{{ url('/admin/houses') }}'">
                    <div class="card-content" id="card-main">
                        <div class="icon-circle">
                            <i class="fa fa-home"></i>
                        </div>

                        <div class="summary-num">
                            {{ $totalHouses ?? 0 }}
                        </div>

                        <div class="summary-label">
                            Nhà / Phòng quản lý
                        </div>
                    </div>

                    <i class="fa fa-building icon-bg"></i>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="summary-card bg-grad-2" onclick="location.href='{{ url('/admin/tenants') }}'">
                    <div class="card-content">
                        <div class="icon-circle">
                            <i class="fa fa-users"></i>
                        </div>

                        <div class="summary-num">
                            {{ $activeTenants ?? 0 }}
                        </div>

                        <div class="summary-label">
                            Khách đang thuê
                        </div>
                    </div>

                    <i class="fa fa-user-check icon-bg"></i>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="summary-card bg-grad-3" onclick="location.href='{{ url('/admin/reports') }}'">
                    <div class="card-content">
                        <div class="icon-circle">
                            <i class="fa fa-wallet"></i>
                        </div>

                        <div class="summary-num" style="font-size: 2.1rem;">
                            {{ number_format($monthlyRevenue ?? 0, 0, ',', '.') }}
                            <small style="font-size: 1.1rem; font-weight: 600;">đ</small>
                        </div>

                        <div class="summary-label">
                            Doanh thu tháng {{ date('m') }}
                        </div>
                    </div>

                    <i class="fa fa-coins icon-bg"></i>
                </div>
            </div>

        </div>

        <div class="row d-flex align-items-stretch">

            <div class="col-lg-8 col-md-12 mb-4">
                <div class="card chart-card">
                    <div class="chart-header">
                        <span class="chart-title">
                            Biểu đồ biến động doanh thu 6 tháng
                        </span>

                        <i class="fa fa-chart-bar text-muted"></i>
                    </div>

                    <div style="height: 350px;">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-12 mb-4">
                <div class="card chart-card">
                    <div class="chart-header">
                        <span class="chart-title">
                            Tỉ lệ lấp đầy căn hộ
                        </span>

                        <i class="fa fa-chart-pie text-muted"></i>
                    </div>

                    <div style="height: 230px; position: relative; margin-top: 15px;">
                        <canvas id="statusChart"></canvas>
                    </div>

                    <div class="mt-4 text-center">
                        <div class="row">
                            <div class="col-6 border-right">
                                <h4 class="font-weight-bold mb-1 text-success">
                                    {{ $activeTenants ?? 0 }}
                                </h4>

                                <small class="text-muted font-weight-bold">
                                    Đang ở
                                </small>
                            </div>

                            <div class="col-6">
                                <h4 class="font-weight-bold mb-1 text-warning">
                                    {{ $emptyHouses ?? 0 }}
                                </h4>

                                <small class="text-muted font-weight-bold">
                                    Còn trống
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    var isDarkMode = document.body.classList.contains('dark-mode');
    var chartTextColor = isDarkMode ? '#94a3b8' : '#64748b';
    var chartGridColor = isDarkMode ? '#222d4a' : '#f0f0f0';
    var chartTooltipBg = isDarkMode ? '#1e2942' : '#ffffff';
    var chartTooltipText = isDarkMode ? '#f8fafc' : '#333333';
    var doughnutBorderColor = isDarkMode ? '#1a233a' : '#ffffff';

    var ctxRevenue = document.getElementById('revenueChart').getContext('2d');
    var gradientFill = ctxRevenue.createLinearGradient(0, 0, 0, 350);
    gradientFill.addColorStop(0, 'rgba(78, 115, 223, 0.85)');
    gradientFill.addColorStop(1, 'rgba(78, 115, 223, 0.05)');

    var revenueChart = new Chart(ctxRevenue, {
        type: 'bar',
        data: {
            labels: @json($monthsLabels ?? []),
            datasets: [{
                label: 'Doanh thu',
                data: @json($revenueData ?? []),
                backgroundColor: gradientFill,
                borderColor: '#4e73df',
                borderWidth: 0,
                borderRadius: 8,
                barPercentage: 0.5,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: chartTooltipBg,
                    titleColor: chartTooltipText,
                    bodyColor: chartTooltipText,
                    borderColor: isDarkMode ? '#222d4a' : '#e2e8f0',
                    borderWidth: 1,
                    padding: 12,
                    cornerRadius: 10,
                    callbacks: {
                        label: function (context) {
                            return new Intl.NumberFormat('vi-VN', {
                                style: 'currency',
                                currency: 'VND'
                            }).format(context.raw);
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        borderDash: [4, 4],
                        color: chartGridColor,
                        drawBorder: false
                    },
                    ticks: {
                        color: chartTextColor,
                        font: {
                            family: "'Poppins', sans-serif",
                            size: 11
                        },
                        callback: function (value) {
                            if (value >= 1000000) return (value / 1000000) + ' Tr';
                            return value.toLocaleString('vi-VN');
                        }
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        color: chartTextColor,
                        font: {
                            family: "'Poppins', sans-serif",
                            size: 12
                        }
                    }
                }
            }
        }
    });

    var ctxStatus = document.getElementById('statusChart').getContext('2d');

    var statusChart = new Chart(ctxStatus, {
        type: 'doughnut',
        data: {
            labels: ['Đang thuê', 'Còn trống'],
            datasets: [{
                data: [
                    {{ $activeTenants ?? 0 }},
                    {{ $emptyHouses ?? 0 }}
                ],
                backgroundColor: ['#10b981', '#f59e0b'],
                borderWidth: 3,
                borderColor: doughnutBorderColor,
                hoverOffset: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '78%',
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        usePointStyle: true,
                        pointStyle: 'circle',
                        padding: 15,
                        color: chartTextColor,
                        font: {
                            family: "'Poppins', sans-serif",
                            size: 12,
                            weight: '500'
                        }
                    }
                },
                tooltip: {
                    backgroundColor: chartTooltipBg,
                    titleColor: chartTooltipText,
                    bodyColor: chartTooltipText,
                    borderColor: isDarkMode ? '#222d4a' : '#e2e8f0',
                    borderWidth: 1,
                    padding: 10,
                    cornerRadius: 8
                }
            }
        }
    });
</script>
@endpush