<!DOCTYPE html>
<html>
<head>
    @include('admin.css')
    <style>
        .container {
            margin-top: 20px;
        }
        .menu {
            z-index: 1000;
            position: relative;
        }
        .action-costs {
            margin-top: 20px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        .action-costs h3 {
            margin-bottom: 10px;
        }
        canvas {
            max-width: 100%;
            height: 400px; /* Ajustar altura de las gráficas */
            width: auto;
        }
        .chart-container {
            margin-bottom: 20px;
            width: 100%;
        }
        .user-stats-table {
            margin-top: 20px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #fff;
        }
        .user-stats-table h3 {
            margin-bottom: 10px;
        }
        .user-stats-table table {
            width: 100%;
            border-collapse: collapse;
        }
        .user-stats-table th, .user-stats-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .user-stats-table th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    @include('admin.header')
    @include('admin.sidebar')

    <div class="page-content">
        <div class="page-header">
            <div class="container-fluid">
                <div class="container">
                    <h1 class="mb-4">Dashboard de Auditoría</h1>

                    <!-- Formulario para seleccionar una fecha -->
                    <form action="{{ route('audits.dashboard') }}" method="GET" class="mb-4">
                        <div class="form-group">
                            <label for="date">Seleccione una fecha:</label>
                            <input type="date" name="date" id="date" class="form-control" value="{{ $selectedDate }}">
                        </div>
                        <button type="submit" class="btn btn-primary">Actualizar</button>
                    </form>

                    <!-- Sección de costos de acción -->
                    <div class="action-costs">
                        <h3>Costo de Cada Acción</h3>
                        <ul>
                            <li><strong>Creado:</strong> 5 puntos</li>
                            <li><strong>Actualizado:</strong> 3 puntos</li>
                            <li><strong>Eliminado:</strong> 1 punto</li>
                        </ul>
                    </div>

                    <!-- Gráfico de auditorías por fecha -->
                    <div class="chart-container">
                        <canvas id="auditsByDateChart"></canvas>
                    </div>

                    <!-- Gráfico de estadísticas de usuarios basado en la escala Likert -->
                    <div class="chart-container">
                        <canvas id="userStatisticsChart"></canvas>
                    </div>

                    <!-- Tabla de estadísticas por usuario -->
                    <div class="user-stats-table">
                        <h3>Estadísticas por Usuario</h3>
                        <table>
                            <thead>
                                <tr>
                                    <th>Nombre de Usuario</th>
                                    <th>Puntos Totales</th>
                                    <th>Acciones</th>
                                    <th>Conteo de Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($userNames as $index => $userName)
                                    <tr>
                                        <td>{{ $userName }}</td>
                                        <td>{{ $points[$index] }}</td>
                                        <td>
                                            @if (isset($actions[$userName]))
                                                @foreach ($actions[$userName] as $event => $count)
                                                    <div>{{ ucfirst($event) }}: {{ $count }}</div>
                                                @endforeach
                                            @else
                                                <div>No hay acciones registradas</div>
                                            @endif
                                        </td>
                                        <td>{{ $counts[$index] }}</td>
                                    </tr>
                                @endforeach
                                @if ($userNames->isEmpty())
                                    <tr>
                                        <td colspan="4">No hay datos disponibles.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Archivos JavaScript -->
    <script src="{{ asset('admincss/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('admincss/vendor/popper.js/umd/popper.min.js') }}"></script>
    <script src="{{ asset('admincss/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('admincss/vendor/jquery.cookie/jquery.cookie.js') }}"></script>
    <script src="{{ asset('admincss/vendor/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('admincss/vendor/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('admincss/js/charts-home.js') }}"></script>
    <script src="{{ asset('admincss/js/front.js') }}"></script>

    <!-- Script para las gráficas -->
    <script>
        $(document).ready(function() {
            // Datos para el gráfico de auditorías por fecha
            var ctxDate = document.getElementById('auditsByDateChart').getContext('2d');
            var auditsByDateChart = new Chart(ctxDate, {
                type: 'bar', // Cambiado de 'line' a 'bar'
                data: {
                    labels: @json($labels),
                    datasets: [{
                        label: 'Auditorías por Fecha',
                        data: @json($data),
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Datos para el gráfico de estadísticas de usuarios basado en la escala Likert
            var ctxUserStats = document.getElementById('userStatisticsChart').getContext('2d');
            var userStatisticsChart = new Chart(ctxUserStats, {
                type: 'bar', // Cambiado de 'line' a 'bar'
                data: {
                    labels: @json($userNames),
                    datasets: [{
                        label: 'Puntos Totales',
                        data: @json($points),
                        backgroundColor: 'rgba(153, 102, 255, 0.2)',
                        borderColor: 'rgba(153, 102, 255, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
</body>
</html>
