<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction Summary</title>
    <!-- Include Chart.js library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .date-range {
            display: flex;
            justify-content: space-between;
            font-size: 18px;
        }
        .date-label {
            font-weight: bold;
        }
        .date-range span {
            margin-right: 20px; /* Increase the margin for spacing */
        }
        #chart-container {
            width: auto;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    
    <div class="date-range">
  
        <?php
    // Specify the URL of the text file
    $fileUrl = 'https://kabaritacoltd.000webhostapp.com/kabarita/saveddata/transactions_data.txt';

    // Fetch the contents of the file from the URL
    $fileContent = file_get_contents($fileUrl);

    // Define an array to store the amounts for each month
    $monthlyAmounts = [];

    // Split the file content into lines
    $lines = explode("\n", $fileContent);

    foreach ($lines as $line) {
        // Check if the line contains "Amount:"
        if (strpos($line, 'Amount:') !== false) {
            // Extract the amount value (assuming it's in the format "Amount: X.XX")
            $amount = (float)str_replace("Amount: ", "", $line);

            // Extract the year, month, and date using string manipulation
            $year = substr($line, 0, 4);
            $month = substr($line, 5, 2);
            $date = substr($line, 8, 2);
            
            // Combine year, month, and date to form YYYY-MM
            $formattedDate = "$year-$month-$date";

            // Debugging: Display the formatted date
          //  echo "Formatted Date: $formattedDate<br>";

            // Add the amount to the corresponding month in the array
            if (!isset($monthlyAmounts[$formattedDate])) {
                $monthlyAmounts[$formattedDate] = 0;
            }
            $monthlyAmounts[$formattedDate] += $amount;
                
        }
    }

    ?>


    </div>

    <div id="chart-container" class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Earnings Overview</h6>
        </div>
        <div class="card-body">
            <canvas id="transactionChart"></canvas>
        </div>
    </div>

    <script>
        // Create a bar graph using Chart.js
        var ctx = document.getElementById('transactionChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($formattedDates); ?>,
                datasets: [{
                    label: 'Total Amount',
                    data: <?php echo json_encode(array_values($monthlyAmounts)); ?>,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)', // Bar color
                    borderColor: 'rgba(75, 192, 192, 1)', // Border color
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Total Amount'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Date'
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>