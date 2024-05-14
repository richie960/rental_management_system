<!-- index.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
  
    <title>House Status Chart</title>
    <!-- Include Chart.js from CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <canvas id="houseChart" width="100" height="100"></canvas>
    <script>
        <?php
        // PHP code
        // Include the database connection file
     include 'dbconnection.php';
        // Query to get the count of occupied and vacant houses
        $query = "SELECT COUNT(*) AS count, Status FROM default_deposits GROUP BY Status";
        $result = mysqli_query($db, $query);

        if (!$result) {
            die("Error fetching data: " . mysqli_error($db));
        }

        // Initialize variables
        $occupied = 0;
        $vacant = 0;

        // Process the query result
        while ($row = mysqli_fetch_assoc($result)) {
            $status = strtolower($row['Status']);
            if ($status === 'occupied') {
                $occupied = $row['count'];
            } elseif ($status === 'vacant') {
                $vacant = $row['count'];
            }
        }

        // Close the database connection
        mysqli_close($db);
        ?>

        // JavaScript code
        // Create a pie chart
        var ctx = document.getElementById('houseChart').getContext('2d');
        var myPieChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Occupied', 'Vacant'],
                datasets: [{
                    data: [<?php echo $occupied; ?>, <?php echo $vacant; ?>],
                    backgroundColor: ['#FF6384', '#36A2EB'],
                }],
            },
        });
    </script>
</body>
</html>
