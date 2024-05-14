<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dynamic Line Chart</title>
    <!-- Include Chart.js from CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <canvas id="myAreaChart" width="800" height="400"></canvas>
    <script>
        window.onload = function() {
            // Set new default font family and font color to mimic Bootstrap's default styling
            Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
            Chart.defaults.global.defaultFontColor = '#858796';

            function number_format(number, decimals, dec_point, thousands_sep) {
                // ... (unchanged)
            }

            // Fetch data from the URL
            fetch('https://kabaritacoltd.000webhostapp.com/kabarita/C2bValidationData.txt')
                .then(response => response.text())
                .then(text => {
                    const data = JSON.parse(text);
                    const labels = data.map(transaction => transaction.TransTime);
                    const amounts = data.map(transaction => parseFloat(transaction.TransAmount));

                    // Line Chart Example
                    var ctx = document.getElementById("myAreaChart");
                    var myLineChart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: "Earnings",
                                lineTension: 0.3,
                                backgroundColor: "rgba(78, 115, 223, 0.05)",
                                borderColor: "rgba(78, 115, 223, 1)",
                                pointRadius: 3,
                                pointBackgroundColor: "rgba(78, 115, 223, 1)",
                                pointBorderColor: "rgba(78, 115, 223, 1)",
                                pointHoverRadius: 3,
                                pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                                pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                                pointHitRadius: 10,
                                pointBorderWidth: 2,
                                data: amounts,
                            }],
                        },
                        options: {
                            maintainAspectRatio: false,
                            // ... (unchanged)
                        }
                    });
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                });
        };
    </script>
</body>
</html>
