<?php
include_once '../main.php'; // Include the database connection file

// Get the values from the form
$therapistId = $_POST['selectName'];
$clientId = $id; // Assuming $id is available in this context
$selectedDate = $_POST['selectDate'];
$selectedTimeId = $_POST['selectTime'];
$status = 1;

// Insert into the appointment table using prepared statements to prevent SQL injection
$queryAppointment = "INSERT INTO appointment (therapistID, clientID, date, timeID, statusID) VALUES (?, ?, ?, ?, ?)";

$stmtAppointment = $con->prepare($queryAppointment);

if ($stmtAppointment === false) {
    die('Error in preparing the statement for appointment.');
}

$stmtAppointment->bind_param('iissi', $therapistId, $clientId, $selectedDate, $selectedTimeId, $status);

// Execute the appointment insertion
if ($stmtAppointment->execute()) {
    echo "Appointment successfully scheduled.";

    // Close the statement for the appointment
    $stmtAppointment->close();

    // Check if the client has an existing balance
    $queryCheckBalance = "SELECT * FROM clientBalance WHERE clientID = ?";
    $stmtCheckBalance = $con->prepare($queryCheckBalance);

    if ($stmtCheckBalance === false) {
        die('Error in preparing the statement for checking client balance.');
    }

    $stmtCheckBalance->bind_param('i', $clientId);

    // Execute the check for existing balance
    $stmtCheckBalance->execute();
    $resultCheckBalance = $stmtCheckBalance->get_result();

    // Close the statement for checking client balance
    $stmtCheckBalance->close();

    // If the client has an existing balance, update it
    if ($resultCheckBalance->num_rows > 0) {
        $queryUpdateBalance = "UPDATE clientBalance SET balanceAmount = balanceAmount + 150.00 WHERE clientID = ?";
    } else {
        // If the client doesn't have an existing balance, insert a new record
        $queryUpdateBalance = "INSERT INTO clientBalance (clientID, balanceAmount) VALUES (?, 150.00)";
    }

    $stmtUpdateBalance = $con->prepare($queryUpdateBalance);

    if ($stmtUpdateBalance === false) {
        die('Error in preparing the statement for updating/inserting client balance.');
    }

    $stmtUpdateBalance->bind_param('i', $clientId);

    // Execute the client balance update/insert
    if ($stmtUpdateBalance->execute()) {
        echo "Client balance updated/inserted.";
    } else {
        echo "Error updating/inserting client balance.";
    }

    // Close the statement for updating/inserting client balance
    $stmtUpdateBalance->close();

} else {
    echo "Error in scheduling appointment.";
}

// Close the database connection
$con->close();
?>
