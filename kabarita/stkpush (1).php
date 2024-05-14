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
    header("Location: index.php?error=CURL Error: " . curl_error($curl));
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
                header("Location: index.php?message=Transaction For HouseNumber: $account_reference  has been sent and is under way....Enter your pin please.");
                exit(); // Exit to prevent further output
            } else {
                // Log the error for debugging purposes
                error_log("Error response code: " . $ResponseCode);
                
                // Redirect to index.php with an error message
                header("Location: index.php?message=Error response code: " . $ResponseCode);
                exit(); // Exit to prevent further output
            }
        } else {
            // Log the error for debugging purposes
            error_log("Error: CheckoutRequestID or ResponseCode is missing in the JSON response.");
            
            // Redirect to index.php with an error message
            header("Location: index.php?message=Error: CheckoutRequestID or ResponseCode is missing in the JSON response.");
            exit(); // Exit to prevent further output
        }
    } else {
        // Log the error for debugging purposes
        error_log("Error decoding JSON response.");
        
        // Redirect to index.php with an error message
        header("Location: index.php?message=Error decoding JSON response.");
        exit(); // Exit to prevent further output
    }
}

curl_close($curl);
?>
