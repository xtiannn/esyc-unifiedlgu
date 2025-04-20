<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Cases Chart</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
</head>

<body>
    <canvas id="casesChart" width="600" height="400"></canvas>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('casesChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($casesChartData['labels']) !!},
                    datasets: [{
                        label: 'Cases by Type',
                        data: {!! json_encode($casesChartData['data']) !!},
                        backgroundColor: {!! json_encode($casesChartData['colors']) !!},
                        borderWidth: 0,
                        borderRadius: 4
                    }]
                },
                options: {
                    responsive: false,
                    maintainAspectRatio: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)'
                            },
                            title: {
                                display: true,
                                text: 'Number of Cases',
                                font: {
                                    size: 14,
                                    family: 'Inter',
                                    weight: '600'
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            title: {
                                display: true,
                                text: 'Case Type',
                                font: {
                                    size: 14,
                                    family: 'Inter',
                                    weight: '600'
                                }
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        title: {
                            display: true,
                            text: 'Cases by Type',
                            font: {
                                size: 16,
                                family: 'Inter',
                                weight: '600'
                            },
                            padding: {
                                top: 10,
                                bottom: 20
                            }
                        }
                    }
                }
            });
        });
    </script>
</body>

</html>
