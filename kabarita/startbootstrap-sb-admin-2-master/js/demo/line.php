<!-- index.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction Bar Graph</title>
    <!-- Include Chart.js from CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <canvas id="transactionGraph" width="800" height="400"></canvas>
    <script>
        // JavaScript code
        // Fetch data from the URL using Fetch API
        fetch('https://kabaritacoltd.000webhostapp.com/kabarita/C2bValidationData.txt')
            .then(response => response.json())
            .then(data => {
                // Process data and create a bar graph
                var ctx = document.getElementById('transactionGraph').getContext('2d');
                var labels = [];  // X-axis labels
                var amounts = []; // Y-axis values

                data.forEach(transaction => {
                    var timestamp = new Date(transaction['TransTime']);
                    labels.push(timestamp);
                    amounts.push(parseFloat(transaction['TransAmount']));
                });

                var myBarChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Transaction Amount',
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1,
                            data: amounts,
                        }],
                    },
                    options: {
                        scales: {
                            xAxes: [{
                                type: 'time',
                                time: {
                                    unit: 'day',
                                    displayFormats: {
                                        day: 'MMM D'
                                    }
                                },
                                scaleLabel: {
                                    display: true,
                                    labelString: 'Date'
                                }
                            }],
                            yAxes: [{
                                scaleLabel: {
                                    display: true,
                                    labelString: 'Amount'
                                }
                            }]
                        },
                        responsive: true,
                        maintainAspectRatio: false, // Set this to false to control the size
                    }
                });
            })
            .catch(error => {
                console.error('Error fetching data:', error);
            });
    </script>
</body>
</html>
