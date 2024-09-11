<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>Dashboard de Vendas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .chart-container {
            margin-bottom: 50px;
        }

        canvas {
            width: 100% !important;
            max-width: 600px;
            height: auto !important;
        }

        .navbar {
            background-color: #333;
            padding: 15px;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            margin-left: 15px;
        }

        .navbar form {
            margin: 0;
        }

        .navbar button {
            background-color: #f44336;
            border: none;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            /* margin: 4px 2px; */
            cursor: pointer;
            border-radius: 4px;
        }

        .navbar a.home {
            background-color: #4CAF50;
            padding: 10px 20px;
            border-radius: 4px;
        }
        .menu {
            display: flex;
            justify-content: space-between;
            gap: 20px;
        }
    </style>
</head>

<body>
    <div class="navbar">
        <a href="{{ route('dashboard') }}">Dashboard de Vendas</a>
        <div class="menu">
            <a href="{{ url('/') }}" class="home">Home</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">Logout</button>
            </form>
        </div>
    </div>

    <div class="container">
        <div class="chart-container">
            <h2>Vendas por Produto</h2>
            <canvas id="salesByProductChart"></canvas>
        </div>
        <div class="chart-container">
            <h2>Vendas por Mês</h2>
            <canvas id="salesByMonthChart"></canvas>
        </div>
        <div class="chart-container">
            <h2>Vendas por Ano</h2>
            <canvas id="salesByYearChart"></canvas>
        </div>
    </div>

    <script>
        var ctxProduct = document.getElementById('salesByProductChart').getContext('2d');
        var salesByProductChart = new Chart(ctxProduct, {
            type: 'bar',
            data: {
                labels: @json($salesByProduct->pluck('product_name')),
                datasets: [{
                    label: 'Total Vendido (em R$)',
                    data: @json($salesByProduct->pluck('total_sales')),
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
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

        var ctxMonth = document.getElementById('salesByMonthChart').getContext('2d');
        var salesByMonthChart = new Chart(ctxMonth, {
            type: 'line',
            data: {
                labels: @json($salesByMonth->pluck('month')),
                datasets: [{
                    label: 'Total Vendido (em R$)',
                    data: @json($salesByMonth->pluck('total_sales')),
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

        var ctxYear = document.getElementById('salesByYearChart').getContext('2d');
        var salesByYearChart = new Chart(ctxYear, {
            type: 'pie',
            data: {
                labels: @json($salesByYear->pluck('year')),
                datasets: [{
                    label: 'Total Vendido (em R$)',
                    data: @json($salesByYear->pluck('total_sales')),
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        enabled: true
                    }
                }
            }
        });
    </script>
</body>

</html>
