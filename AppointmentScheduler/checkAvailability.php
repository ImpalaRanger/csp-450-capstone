<?php
include_once '../main.php'; // Include the database connection file

// Check if therapistId, selectedDate, and selectedTime are set in the URL
if (
    isset($_GET['therapistId']) &&
    isset($_GET['selectedDate']) &&
    isset($_GET['selectedTimeID'])
) {
    // Sanitize and store the values
    $therapistId = $_GET['therapistId'];
    $selectedDate = $_GET['selectedDate'];
    $selectedTimeID = $_GET['selectedTimeID'];

    // Check if therapistId is empty
    if (empty($therapistId)) {
        // Therapist not selected
        echo "therapist not selected";
        exit();
    }

    // Prepare the SQL query to check availability
    $availabilityQuery = "SELECT * FROM appointment WHERE therapistID = ? AND date = ? AND timeID = ?";
    $availabilityStmt = $con->prepare($availabilityQuery);

    if ($availabilityStmt === false) {
        die('Error in preparing the statement.');
    }

    // Bind parameters and execute the query
    $availabilityStmt->bind_param("iss", $therapistId, $selectedDate, $selectedTimeID);
    $availabilityStmt->execute();

    // Get the result set
    $availabilityResult = $availabilityStmt->get_result();

    // Check if there is any existing appointment for the selected therapist, date, and time
    if ($availabilityResult->num_rows > 0) {
        // Appointment slot is not available
        echo "not available";
    } else {
        // Appointment slot is available
        echo "available";
    }

    // Close the statement
    $availabilityStmt->close();
} else {
    // Invalid or missing parameters in the URL
    echo "invalid parameters";
}

// Close the database connection
$con->close();
?>
