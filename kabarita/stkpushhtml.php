 <!DOCTYPE html>
<html>
<head>

  <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="google-site-verification" content="Jku6XAuvT9K_eTw7d7uRVU-3QxNQauONnHuT8XZvkvU" />
    <title>MPESA Callback Processing</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        p {
            color: green; /* Change this to your desired text color */
            font-size: 18px;
        }
        
        /* Apply styles to the body */
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
}

/* Style the header */
h1 {
    color: #333;
    text-align: center;
    padding: 20px;
    background-color: #fff;
    border-bottom: 1px solid #ccc;
}

/* Style the form container */
form {
    max-width: 400px;
    margin: 0 auto;
    padding: 20px;
    background-color: #fff;
    border: 1px solid #ccc;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

/* Style labels and input fields */
label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
    color: #555;
}

input[type="text"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 4px;
    transition: border-color 0.3s ease-in-out;
}

input[type="text"]:focus {
    border-color: #007bff;
    outline: none;
}

/* Style the submit button */
input[type="submit"] {
    display: block;
    width: 100%;
    padding: 10px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease-in-out;
}

input[type="submit"]:hover {
    background-color: #0056b3;
}

/* Style success message */
p {
    color: green;
    font-size: 18px;
    text-align: center;
    margin-top: 20px;
}

        
        
        
    </style>
</head>
<body>
    <h1>MPESA Callback Processing</h1>
    <form action="" method="post">
        <label for="phone_number">Phone Number:</label>
        <input type="text" id="phone_number" name="phone_number" placeholder="eg. 0712345679"  required><br><br>
        
        <label for="amount">Amount:</label>
        <input type="text" id="amount" name="amount" placeholder="RENT/DEPOSIT" required><br><br>

         <label for="account_reference">HouseNumber:</label>
    <input type="text" name="account_reference"placeholder="eg. D2" required>

        <input type="submit" value="Initiate STK Push">
    </form>
    
    <script>
        document.querySelector('form').addEventListener('submit', function (event) {
            const phoneNumberInput = document.getElementById('phone_number');
            const rawPhoneNumber = phoneNumberInput.value.trim();
            
            // Check if the number starts with '0'
            if (rawPhoneNumber.startsWith('0')) {
                // Remove the leading '0' and add '254' at the beginning
                const formattedPhoneNumber = '254' + rawPhoneNumber.substr(1);
                phoneNumberInput.value = formattedPhoneNumber;
            }
        });
        
            // Parse the URL to get the query string
        const queryString = window.location.search;
        
        // Create a new URLSearchParams object with the query string
        const params = new URLSearchParams(queryString);
        
        // Get the value of the 'message' parameter
        const message = params.get('message');
        
        // Display the message on the page
        if (message) {
            const messageElement = document.createElement('p');
            messageElement.textContent = message;
            document.body.appendChild(messageElement);
        }  
        
    </script>
            
    
    <button id="goBackButton" style="background-color: blue; color: white; font-size: 18px; padding: 10px 20px; display: block; margin: 0 auto;">
    Go Back
    <span style="margin-left: 5px;">&#8592;</span>
</button>
<script>
    // Get the current URL's search parameters
    const urlParams = new URLSearchParams(window.location.search);

    // Get the values you want from the search parameters
    const houseNumber = urlParams.get('houseNumber');
    const otp = urlParams.get('otp');

    // Build the modified URL with the extracted information
    const modifiedLink = `https://kabaritacoltd.000webhostapp.com/kabarita/startbootstrap-sb-admin-2-master/index.php?houseNumber=${houseNumber}&otp=${otp}`;

    // Set the modified link as the href of your button or link
    document.getElementById('goBackButton').onclick = function() {
        window.location.href = modifiedLink; // Redirect to the modified link when the button is clicked
    };
</script>
</body>
</html>





<?php
include 'accessToken.php';
date_default_timezone_set('Africa/Nairobi');
$processrequestUrl = 'https://api.safaricom.co.ke/mpesa/stkpush/v1/processrequest';

$callbackurl = 'https://kabaritacoltd.000webhostapp.com/kabarita/callback.php';
$passkey = "3da26f11a8f1d70281011645bce7356644238a81013daa9a58a2bd2b30e6cfd1";
$BusinessShortCode = '4118403';
$Timestamp = date('YmdHis');

// ENCRYPT DATA TO GET PASSWORD
$Password = base64_encode($BusinessShortCode . $passkey . $Timestamp);

// Get user-provided data from the form
$phone = $_POST['phone_number'];
$money = $_POST['amount'];
$account_reference = $_POST['account_reference']; 

$PartyA = $phone;
$PartyB = '254722295457';
$AccountReference = $account_reference;
$TransactionDesc = 'STKPush';
$Amount = $money;
$stkpushheader = ['Content-Type: application/json', 'Authorization: Bearer ' . $access_token];

// INITIATE CURL
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $processrequestUrl);
curl_setopt($curl, CURLOPT_HTTPHEADER, $stkpushheader); // setting custom header
$curl_post_data = array(
    // Fill in the request parameters with valid values
    'BusinessShortCode' => $BusinessShortCode,
    'Password' => $Password,
    'Timestamp' => $Timestamp,
    'TransactionType' => 'CustomerPayBillOnline',
    'Amount' => $Amount,
    'PartyA' => $PartyA,
    'PartyB' => $BusinessShortCode,
    'PhoneNumber' => $PartyA,
    'CallBackURL' => $callbackurl,
    'AccountReference' => $AccountReference,
    'TransactionDesc' => $TransactionDesc
);

$data_string = json_encode($curl_post_data);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
$curl_response = curl_exec($curl);

// Log the raw response for debugging purposes
error_log("Raw Response: " . $curl_response);

if ($curl_response === false) {
    // Log the CURL error for debugging purposes
    error_log("CURL Error: " . curl_error($curl));
    
    // Redirect to index.php with an error message
   // header("Location: index.php?error=CURL Error: " . curl_error($curl));
    echo "CURL Error: . curl_error $curl";
    exit(); // Exit to prevent further output
} else {
    // ECHO RESPONSE
    $data = json_decode($curl_response);

    if ($data !== null) {
        // Check if CheckoutRequestID and ResponseCode exist
        if (isset($data->CheckoutRequestID) && isset($data->ResponseCode)) {
            $CheckoutRequestID = $data->CheckoutRequestID;
            $ResponseCode = $data->ResponseCode;

            if ($ResponseCode == "0") {
                // Redirect to loader.php with CheckoutRequestID parameter
               // header("Location: index.php?message=Transaction For HouseNumber: $account_reference  has been sent and is under way....Enter your pin please.");
               echo "Transaction For HouseNumber: $account_reference  has been sent and is under way....Enter your pin please.";
                exit(); // Exit to prevent further output
            } else {
                // Log the error for debugging purposes
                error_log("Error response code: " . $ResponseCode);
                
                // Redirect to index.php with an error message
              //  header("Location: index.php?message=Error response code: " . $ResponseCode);
              echo "Error response code:  . $ResponseCode";

                exit(); // Exit to prevent further output
            }
        } else {
            // Log the error for debugging purposes
            error_log("Error: CheckoutRequestID or ResponseCode is missing in the JSON response.");
            
            // Redirect to index.php with an error message
          //  header("Location: index.php?message=Error: CheckoutRequestID or ResponseCode is missing in the JSON response.");
       //   echo "CheckoutRequestID or ResponseCode is missing in the JSON response";
            exit(); // Exit to prevent further output
        }
    } else {
        // Log the error for debugging purposes
        error_log("Error decoding JSON response.");
        
        // Redirect to index.php with an error message
       // header("Location: index.php?message=Error decoding JSON response.");
        echo "Error decoding JSON response.";
        exit(); // Exit to prevent further output
    }
}

curl_close($curl);
?>

<!-- Your existing HTML code ... -->


