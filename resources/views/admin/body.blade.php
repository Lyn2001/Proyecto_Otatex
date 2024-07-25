<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        .chart-container {
            width: 45%;
            margin: 0 auto;
            display: inline-block;
            padding: 10px;
            height: 240px;
            /* Ajustar altura para gráficos más pequeños */
        }

        .small-chart {
            display: flex;
            justify-content: center;
            height: 250px !important;
            /* Ajustar altura para gráficos doughnut un poco más grandes */
        }

        .footer {
            /* background-color: #000; Color de fondo negro */
            color: #fff; /* Texto blanco */
            padding: 10px 0;
            position: relative;
            width: 100%;
            bottom: 0;
            text-align: center;
        }

        .footer__block {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .no-margin-bottom {
            margin-bottom: 0;
        }

    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>

<body>
    <h2 class="h5 no-margin-bottom" style="text-align: center;">Dashboard</h2>
    <section class="no-padding-top no-padding-bottom">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-3 col-sm-6">
                            <div class="statistic-block block">
                                <div class="progress-details d-flex align-items-end justify-content-between">
                                    <div class="title">
                                        <div class="icon"><i class="icon-user-1"></i></div><strong>Total
                                            de Clientes</strong>
                                    </div>
                                    <div class="number dashtext-1">{{ $user }}</div>
                                </div>
                                <div class="progress progress-template">
                                    <div role="progressbar" style="width: 30%" aria-valuenow="30" aria-valuemin="0"
                                        aria-valuemax="100" class="progress-bar progress-bar-template dashbg-1"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="statistic-block block">
                                <div class="progress-details d-flex align-items-end justify-content-between">
                                    <div class="title">
                                        <div class="icon"><i class="icon-contract"></i></div><strong>Total
                                            de Productos</strong>
                                    </div>
                                    <div class="number dashtext-2">{{ $product }}</div>
                                </div>
                                <div class="progress progress-template">
                                    <div role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0"
                                        aria-valuemax="100" class="progress-bar progress-bar-template dashbg-2"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="statistic-block block">
                                <div class="progress-details d-flex align-items-end justify-content-between">
                                    <div class="title">
                                        <div class="icon"><i class="icon-paper-and-pencil"></i></div><strong>Total
                                            de Pedidos</strong>
                                    </div>
                                    <div class="number dashtext-3">{{ $order }}</div>
                                </div>
                                <div class="progress progress-template">
                                    <div role="progressbar" style="width: 55%" aria-valuenow="55" aria-valuemin="0"
                                        aria-valuemax="100" class="progress-bar progress-bar-template dashbg-3"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="statistic-block block">
                                <div class="progress-details d-flex align-items-end justify-content-between">
                                    <div class="title">
                                        <div class="icon"><i class="icon-writing-whiteboard"></i></div><strong>Total
                                            de Entregados</strong>
                                    </div>
                                    <div class="number dashtext-4">{{ $delivered }}</div>
                                </div>
                                <div class="progress progress-template">
                                    <div role="progressbar" style="width: 35%" aria-valuenow="35" aria-valuemin="0"
                                        aria-valuemax="100" class="progress-bar progress-bar-template dashbg-4"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <div class="chart-container small-chart">
                                <canvas id="clientsChart"></canvas>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="chart-container small-chart">
                                <canvas id="productsChart"></canvas>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="chart-container small-chart">
                                <canvas id="ordersChart"></canvas>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="chart-container small-chart">
                                <canvas id="deliveredChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-12">
                            <canvas id="barChart" class="chart-container"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <footer class="footer">
        <div class="footer__block block no-margin-bottom">
            <div class="container-fluid text-center">
                <p class="no-margin-bottom" style="margin: 0;">2018 &copy; Microempresa Otatex. Descarga aqui <a target="_blank" href="https://templateshub.net">Templates Hub</a>.</p>
            </div>
        </div>
    </footer>

    <script>
        var ctxBar = document.getElementById('barChart').getContext('2d');
        var ctxClients = document.getElementById('clientsChart').getContext('2d');
        var ctxProducts = document.getElementById('productsChart').getContext('2d');
        var ctxOrders = document.getElementById('ordersChart').getContext('2d');
        var ctxDelivered = document.getElementById('deliveredChart').getContext('2d');

        var barChart = new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: ['Total Clients', 'Total Products', 'Total Orders', 'Total Delivered'],
                datasets: [{
                    label: 'Counts',
                    data: [{{ $user }}, {{ $product }}, {{ $order }},
                        {{ $delivered }}
                    ],
                    backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0'],
                    borderColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        var clientsChart = new Chart(ctxClients, {
            type: 'doughnut',
            data: {
                labels: ['Total Clients'],
                datasets: [{
                    data: [{{ $user }}, 100 - {{ $user }}],
                    backgroundColor: ['#FF6384', '#e9e9e9'],
                    hoverBackgroundColor: ['#FF6384', '#e9e9e9']
                }]
            },
            options: {
                responsive: true,
                animation: {
                    animateRotate: true,
                    animateScale: true
                }
            }
        });

        var productsChart = new Chart(ctxProducts, {
            type: 'doughnut',
            data: {
                labels: ['Total Products'],
                datasets: [{
                    data: [{{ $product }}, 100 - {{ $product }}],
                    backgroundColor: ['#36A2EB', '#e9e9e9'],
                    hoverBackgroundColor: ['#36A2EB', '#e9e9e9']
                }]
            },
            options: {
                responsive: true,
                animation: {
                    animateRotate: true,
                    animateScale: true
                }
            }
        });

        var ordersChart = new Chart(ctxOrders, {
            type: 'doughnut',
            data: {
                labels: ['Total Orders'],
                datasets: [{
                    data: [{{ $order }}, 100 - {{ $order }}],
                    backgroundColor: ['#FFCE56', '#e9e9e9'],
                    hoverBackgroundColor: ['#FFCE56', '#e9e9e9']
                }]
            },
            options: {
                responsive: true,
                animation: {
                    animateRotate: true,
                    animateScale: true
                }
            }
        });

        var deliveredChart = new Chart(ctxDelivered, {
            type: 'doughnut',
            data: {
                labels: ['Total Delivered'],
                datasets: [{
                    data: [{{ $delivered }}, 100 - {{ $delivered }}],
                    backgroundColor: ['#4BC0C0', '#e9e9e9'],
                    hoverBackgroundColor: ['#4BC0C0', '#e9e9e9']
                }]
            },
            options: {
                responsive: true,
                animation: {
                    animateRotate: true,
                    animateScale: true
                }
            }
        });

    </script>
</body>

</html>
