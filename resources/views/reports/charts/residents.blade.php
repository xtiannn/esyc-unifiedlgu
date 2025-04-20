<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Residents Chart</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
</head>

<body>
    <canvas id="residentsChart" width="600" height="400"></canvas>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('residentsChart').getContext('2d');
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: {!! json_encode($residentsChartData['labels']) !!},
                    datasets: [{
                        data: {!! json_encode($residentsChartData['data']) !!},
                        backgroundColor: {!! json_encode($residentsChartData['colors']) !!},
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: false,
                    maintainAspectRatio: true,
                    cutout: '65%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                usePointStyle: true,
                                pointStyle: 'circle',
                                font: {
                                    size: 14,
                                    family: 'Inter'
                                }
                            }
                        },
                        title: {
                            display: true,
                            text: 'Residents by Gender',
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
