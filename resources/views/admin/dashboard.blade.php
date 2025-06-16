@extends('layouts.admin')

@section('titulo', 'Panel de Administración')

@section('contenido')
    <div class="container-fluid admin-dashboard">
        <!-- Header con título y resumen rápido -->
        <div class="dashboard-header">
            <div class="header-content">
                <h1>Panel de Administración</h1>
                <p class="text-muted">Bienvenido al panel de control de Unisec</p>
            </div>
            <div class="dashboard-summary">
                <div class="summary-card">
                    <div class="summary-icon users">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="summary-info">
                        <h3>{{ $datosGraficas['usuarios']['total'] }}</h3>
                        <p>Usuarios</p>
                    </div>
                </div>
                <div class="summary-card">
                    <div class="summary-icon congress">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <div class="summary-info">
                        <h3>{{ $datosGraficas['eventos']['totalCongresos'] }}</h3>
                        <p>Congresos</p>
                    </div>
                </div>
                <div class="summary-card">
                    <div class="summary-icon contests">
                        <i class="fas fa-trophy"></i>
                    </div>
                    <div class="summary-info">
                        <h3>{{ $datosGraficas['eventos']['totalConcursos'] }}</h3>
                        <p>Concursos</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Primera fila: Gráficas principales -->
        <div class="row mb-4">
            <!-- Crecimiento de usuarios -->
            <div class="col-xl-6 col-lg-12 mb-4">
                <div class="dashboard-card">
                    <div class="card-header">
                        <div class="header-title">
                            <h5>Crecimiento de Usuarios</h5>
                            <p class="text-muted">Registro mensual de usuarios</p>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="userGrowthChart" style="height: 300px;"></div>
                    </div>
                </div>
            </div>

            <!-- Distribución de participantes -->
            <div class="col-xl-6 col-lg-12 mb-4">
                <div class="dashboard-card">
                    <div class="card-header">
                        <div class="header-title">
                            <h5>Distribución de Participantes</h5>
                            <p class="text-muted">Tipos de participantes registrados</p>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="participantDistributionChart" style="height: 300px;"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Segunda fila: Métricas financieras -->
        <div class="row mb-4">
            <!-- Ingresos por pagos -->
            <div class="col-xl-8 col-lg-12 mb-4">
                <div class="dashboard-card">
                    <div class="card-header">
                        <div class="header-title">
                            <h5>Ingresos por Pagos</h5>
                            <p class="text-muted">Historial de ingresos por tipo de pago</p>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="revenueChart" style="height: 250px;"></div>
                    </div>
                </div>
            </div>

            <!-- Resumen financiero -->
            <div class="col-xl-4 col-lg-12 mb-4">
                <div class="dashboard-card">
                    <div class="card-header">
                        <div class="header-title">
                            <h5>Resumen Financiero</h5>
                            <p class="text-muted">Ingresos totales por categoría</p>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="finance-metrics">
                            <div class="finance-metric">
                                <div class="metric-icon pre-reg">
                                    <i class="fas fa-file-invoice-dollar"></i>
                                </div>
                                <div class="metric-info">
                                    <h4>${{ number_format($datosGraficas['pagos']['preRegistro']['total'], 2) }}</h4>
                                    <p>Pre-Registros</p>
                                    <span class="trend positive">
                                        <i class="fas fa-arrow-up"></i> 12%
                                    </span>
                                </div>
                            </div>
                            <div class="finance-metric">
                                <div class="metric-icon reg">
                                    <i class="fas fa-money-bill-wave"></i>
                                </div>
                                <div class="metric-info">
                                    <h4>${{ number_format($datosGraficas['pagos']['inscripcion']['total'], 2) }}</h4>
                                    <p>Inscripciones</p>
                                    <span class="trend positive">
                                        <i class="fas fa-arrow-up"></i> 8%
                                    </span>
                                </div>
                            </div>
                            <div class="finance-metric">
                                <div class="metric-icon total">
                                    <i class="fas fa-chart-line"></i>
                                </div>
                                <div class="metric-info">
                                    <h4>${{ number_format($datosGraficas['pagos']['preRegistro']['total'] + $datosGraficas['pagos']['inscripcion']['total'], 2) }}</h4>
                                    <p>Total Ingresos</p>
                                    <span class="trend positive">
                                        <i class="fas fa-arrow-up"></i> 10%
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts para gráficos -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const datosGraficas = @json($datosGraficas);

            // Configuración común para los gráficos
            const chartTheme = {
                backgroundColor: 'transparent',
                textStyle: {
                    color: '#ffffff'
                },
                tooltip: {
                    trigger: 'axis',
                    axisPointer: {
                        type: 'shadow'
                    },
                    backgroundColor: 'rgba(22, 33, 62, 0.95)',
                    borderColor: 'rgba(255, 255, 255, 0.1)',
                    borderWidth: 1,
                    textStyle: {
                        color: '#ffffff'
                    },
                    padding: [8, 12],
                    extraCssText: 'box-shadow: 0 4px 6px rgba(0,0,0,0.1);'
                },
                grid: {
                    left: '3%',
                    right: '4%',
                    bottom: '3%',
                    containLabel: true
                },
                legend: {
                    textStyle: {
                        color: '#ffffff'
                    }
                },
                xAxis: {
                    axisLine: {
                        lineStyle: {
                            color: 'rgba(255, 255, 255, 0.1)'
                        }
                    },
                    axisLabel: {
                        color: '#ffffff'
                    }
                },
                yAxis: {
                    axisLine: {
                        lineStyle: {
                            color: 'rgba(255, 255, 255, 0.1)'
                        }
                    },
                    axisLabel: {
                        color: '#ffffff'
                    },
                    splitLine: {
                        lineStyle: {
                            color: 'rgba(255, 255, 255, 0.05)'
                        }
                    }
                }
            };

            // 1. Gráfico de crecimiento de usuarios
            const userGrowthChart = echarts.init(document.getElementById('userGrowthChart'));
            userGrowthChart.setOption({
                ...chartTheme,
                xAxis: {
                    type: 'category',
                    data: datosGraficas.usuarios.porMes.meses,
                    axisLabel: {
                        rotate: 45,
                        color: '#ffffff'
                    }
                },
                yAxis: {
                    type: 'value',
                    axisLabel: {
                        color: '#ffffff'
                    }
                },
                series: [{
                    data: datosGraficas.usuarios.porMes.totales,
                    type: 'line',
                    smooth: true,
                    symbol: 'circle',
                    symbolSize: 8,
                    lineStyle: {
                        width: 3,
                        color: '#4e79a7'
                    },
                    itemStyle: {
                        color: '#4e79a7'
                    },
                    areaStyle: {
                        color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [
                            {
                                offset: 0,
                                color: 'rgba(78, 121, 167, 0.3)'
                            },
                            {
                                offset: 1,
                                color: 'rgba(78, 121, 167, 0.1)'
                            }
                        ])
                    },
                    markLine: {
                        silent: true,
                        data: [{
                            type: 'average',
                            name: 'Promedio'
                        }],
                        lineStyle: {
                            color: '#f28e2b'
                        },
                        label: {
                            color: '#ffffff',
                            formatter: 'Promedio: {c}'
                        }
                    }
                }]
            });

            // 2. Gráfico de distribución de participantes
            const participantDistributionChart = echarts.init(document.getElementById('participantDistributionChart'));
            participantDistributionChart.setOption({
                ...chartTheme,
                tooltip: {
                    trigger: 'item',
                    formatter: '{a} <br/>{b}: {c} ({d}%)'
                },
                legend: {
                    orient: 'vertical',
                    right: 10,
                    top: 'center',
                    data: datosGraficas.participantes.tipos,
                    textStyle: {
                        color: '#ffffff'
                    }
                },
                series: [
                    {
                        name: 'Participantes',
                        type: 'pie',
                        radius: ['50%', '70%'],
                        avoidLabelOverlap: false,
                        itemStyle: {
                            borderRadius: 10,
                            borderColor: '#fff',
                            borderWidth: 2
                        },
                        label: {
                            show: false,
                            position: 'center',
                            color: '#ffffff'
                        },
                        emphasis: {
                            label: {
                                show: true,
                                fontSize: '18',
                                fontWeight: 'bold',
                                color: '#ffffff'
                            }
                        },
                        labelLine: {
                            show: false,
                            lineStyle: {
                                color: '#ffffff'
                            }
                        },
                        data: datosGraficas.participantes.tipos.map((tipo, index) => ({
                            value: datosGraficas.participantes.totales[index],
                            name: tipo,
                            itemStyle: {
                                color: ['#4e79a7', '#f28e2b', '#e15759', '#76b7b2', '#59a14f'][index % 5]
                            }
                        }))
                    }
                ]
            });

            // 3. Gráfico de ingresos por pagos
            const revenueChart = echarts.init(document.getElementById('revenueChart'));
            revenueChart.setOption({
                ...chartTheme,
                legend: {
                    data: ['Pre-Registro', 'Inscripción'],
                    bottom: 0,
                    textStyle: {
                        color: '#ffffff'
                    }
                },
                xAxis: {
                    type: 'category',
                    data: datosGraficas.pagos.preRegistro.fechas,
                    axisLabel: {
                        rotate: 45,
                        color: '#ffffff'
                    }
                },
                yAxis: {
                    type: 'value',
                    axisLabel: {
                        formatter: '${value}',
                        color: '#ffffff'
                    }
                },
                series: [
                    {
                        name: 'Pre-Registro',
                        type: 'bar',
                        stack: 'total',
                        emphasis: {
                            focus: 'series'
                        },
                        data: datosGraficas.pagos.preRegistro.montos,
                        itemStyle: {
                            color: '#4e79a7'
                        }
                    },
                    {
                        name: 'Inscripción',
                        type: 'bar',
                        stack: 'total',
                        emphasis: {
                            focus: 'series'
                        },
                        data: datosGraficas.pagos.inscripcion.montos,
                        itemStyle: {
                            color: '#f28e2b'
                        }
                    }
                ]
            });

            // Manejar el redimensionamiento de las ventanas
            window.addEventListener('resize', function() {
                userGrowthChart.resize();
                participantDistributionChart.resize();
                revenueChart.resize();
            });

            // Botones de filtro de período para ingresos
            document.querySelectorAll('[data-period]').forEach(btn => {
                btn.addEventListener('click', function() {
                    document.querySelectorAll('[data-period]').forEach(b => b.classList.remove('active'));
                    this.classList.add('active');
                });
            });
        });
    </script>

    <style>
        .admin-dashboard {
            background-color: #1a1a2e;
            color: #e9ecef;
            padding: 24px;
            min-height: 100vh;
        }
        
        .dashboard-header {
            margin-bottom: 32px;
        }
        
        .header-content {
            margin-bottom: 24px;
        }
        
        .header-content h1 {
            font-size: 28px;
            font-weight: 600;
            color: #ffffff;
            margin-bottom: 8px;
        }
        
        .header-content p {
            color: #adb5bd;
        }
        
        .dashboard-summary {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 24px;
            margin-top: 24px;
        }
        
        .summary-card {
            background: #16213e;
            border-radius: 12px;
            padding: 24px;
            display: flex;
            align-items: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .summary-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
            border-color: rgba(255, 255, 255, 0.2);
        }
        
        .summary-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 16px;
        }
        
        .summary-icon i {
            font-size: 24px;
            color: #fff;
        }
        
        .summary-icon.users {
            background: linear-gradient(135deg, #4e79a7, #76b7b2);
        }
        
        .summary-icon.congress {
            background: linear-gradient(135deg, #f28e2b, #e15759);
        }
        
        .summary-icon.contests {
            background: linear-gradient(135deg, #59a14f, #76b7b2);
        }
        
        .summary-info h3 {
            font-size: 24px;
            font-weight: 600;
            color: #ffffff;
            margin: 0;
        }
        
        .summary-info p {
            font-size: 14px;
            color: #adb5bd;
            margin: 4px 0 0;
        }
        
        .dashboard-card {
            background: #16213e;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            height: 100%;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .card-header {
            padding: 20px 24px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .header-title h5 {
            font-size: 18px;
            font-weight: 600;
            color: #ffffff;
            margin: 0;
        }
        
        .header-title p {
            font-size: 14px;
            color: #adb5bd;
            margin: 4px 0 0;
        }
        
        .card-body {
            padding: 24px;
        }
        
        .btn-icon {
            width: 32px;
            height: 32px;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #adb5bd;
        }
        
        .btn-icon:hover {
            background: rgba(255, 255, 255, 0.15);
            color: #ffffff;
        }
        
        .btn-group .btn {
            padding: 6px 12px;
            font-size: 14px;
            background: transparent;
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #adb5bd;
        }
        
        .btn-group .btn:hover,
        .btn-group .btn.active {
            background: rgba(255, 255, 255, 0.1);
            color: #ffffff;
            border-color: rgba(255, 255, 255, 0.3);
        }
        
        .finance-metrics {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }
        
        .finance-metric {
            display: flex;
            align-items: center;
            padding: 16px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 8px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .metric-icon {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 16px;
        }
        
        .metric-icon i {
            font-size: 20px;
            color: #fff;
        }
        
        .metric-icon.pre-reg {
            background: linear-gradient(135deg, #4e79a7, #76b7b2);
        }
        
        .metric-icon.reg {
            background: linear-gradient(135deg, #f28e2b, #e15759);
        }
        
        .metric-icon.total {
            background: linear-gradient(135deg, #59a14f, #76b7b2);
        }
        
        .metric-info {
            flex: 1;
        }
        
        .metric-info h4 {
            font-size: 20px;
            font-weight: 600;
            color: #ffffff;
            margin: 0;
        }
        
        .metric-info p {
            font-size: 14px;
            color: #adb5bd;
            margin: 4px 0;
        }
        
        .trend {
            font-size: 12px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }
        
        .trend.positive {
            color: #28a745;
        }
        
        .trend.negative {
            color: #dc3545;
        }

        /* Estilos para los gráficos */
        .chart-container {
            background: rgba(255, 255, 255, 0.02);
            border-radius: 8px;
            padding: 16px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        @media (max-width: 768px) {
            .admin-dashboard {
                padding: 16px;
            }
            
            .dashboard-summary {
                grid-template-columns: 1fr;
            }
            
            .summary-card {
                padding: 16px;
            }
            
            .card-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
            }
            
            .header-actions {
                width: 100%;
            }
            
            .btn-group {
                width: 100%;
                display: flex;
            }
            
            .btn-group .btn {
                flex: 1;
            }
        }
    </style>
@endsection