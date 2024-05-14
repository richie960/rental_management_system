<?php
include 'nav.php';
include 'dbconnection.php';

$searchResult = '';

// Check if house number is provided in the URL
if (isset($_GET['houseNumber'])) {
    $houseNumber = $_GET['houseNumber'];

    $filename = 'saveddata/transactions_data.txt';
    $displayedText = '';

    if (file_exists($filename)) {
        $searchWord = preg_quote($houseNumber, '/');
        $contextLines = 4;
        $handle = fopen($filename, 'r');

        if ($handle) {
            $lines = file($filename);
            $lineNumber = 0;

            while (($line = fgets($handle)) !== false) {
                $lineNumber++;

                if (preg_match("/\b$searchWord\b/i", $line)) {
                    $displayedText .= "Match found \n  $lineNumber:\n";
                    $startIndex = max(0, $lineNumber - $contextLines - 1);
                    $endIndex = min(count($lines) - 1, $lineNumber + $contextLines - 1);

                    // Add extra spacing between matched lines for better readability
                    $displayedText .= implode("\n", array_slice($lines, $startIndex, $endIndex - $startIndex + 1));
                    $displayedText .= " \n \n";
                }
            }

            fclose($handle);
        } else {
            // Display an error message when unable to open the file
            $searchResult = "<p>Error opening the file.</p>";
        }
    } else {
        // Display an error message when the file is not found
        $searchResult = "<p>File not found.</p>";
    }

    if (!empty($displayedText)) {
        // Output the text content
        echo "<pre>$displayedText</pre>";

        // Add the stylized "Go Back" button and define the goBack function
        echo '<button onclick="goBack()" style="width: 150px; background-color: #3498db; color: #fff; padding: 10px; border: none; border-radius: 5px; cursor: pointer;">';
        echo '<span class="arrow">&#8592;</span> Go Back';
        echo '</button>';
        
        echo '<script>';
        echo 'function goBack() {';
        echo '  window.history.back();';
        echo '}';
        echo '</script>';

        exit; // Exit to prevent further HTML rendering
    } else {
        // Display a message when no matches are found
        $searchResult = "<p>Give it about 2minutes</p>";
    }
}
?>
