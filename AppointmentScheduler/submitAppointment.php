<?php
include_once '../main.php'; // Include the database connection file

// Input validation
if (!isset($_POST['selectName'], $id, $_POST['selectDate'], $_POST['selectTime'])) {
    die('Invalid input.');
}

// Get the values from the form
$therapistId = $_POST['selectName'];
$clientId = $id;
$selectedDate = $_POST['selectDate'];
$selectedTimeId = $_POST['selectTime'];
$status = 1;

// Insert into the appointment table using prepared statements to prevent SQL injection
$queryAppointment = "INSERT INTO appointment (therapistID, clientID, date, timeID, statusID) VALUES (?, ?, ?, ?, ?)";
$stmtAppointment = $con->prepare($queryAppointment);

if (!$stmtAppointment) {
    die('Error in preparing the statement for appointment: ' . $stmtAppointment->error);
}

$stmtAppointment->bind_param('iissi', $therapistId, $clientId, $selectedDate, $selectedTimeId, $status);

// Use a transaction
$con->begin_transaction();

// Execute the appointment insertion
if ($stmtAppointment->execute()) {
    echo "Appointment successfully scheduled.";

    // Check if the client has an existing balance
    $queryCheckBalance = "SELECT balanceID, balanceAmount FROM balance WHERE userID = ?";
    $stmtCheckBalance = $con->prepare($queryCheckBalance);

    if ($stmtCheckBalance === false) {
        die('Error in preparing the statement for checking client balance: ' . $con->error);
    }


    $stmtCheckBalance->bind_param('i', $clientId);

    // Execute the check for existing balance
    $stmtCheckBalance->execute();
    $resultCheckBalance = $stmtCheckBalance->get_result();

    // Close the statement for checking client balance
    $stmtCheckBalance->close();

    // If the client has an existing balance, update it
    if ($resultCheckBalance->num_rows > 0) {
        $queryUpdateBalance = "UPDATE balance SET balanceAmount = balanceAmount - ? WHERE userID = ?";
        $stmtUpdateBalance = $con->prepare($queryUpdateBalance);

        if (!$stmtUpdateBalance) {
            die('Error in preparing the statement for updating client balance: ' . $stmtUpdateBalance->error);
        }

        $balanceDecrement = 150.00;
        $stmtUpdateBalance->bind_param('di', $balanceDecrement, $clientId);

    } else {
        // If the client doesn't have an existing balance, insert a new record
        $queryUpdateBalance = "INSERT INTO balance (balanceAmount, userID) VALUES (?, ?)";
        $stmtUpdateBalance = $con->prepare($queryUpdateBalance);

        if (!$stmtUpdateBalance) {
            die('Error in preparing the statement for inserting client balance: ' . $stmtUpdateBalance->error);
        }

        $initialBalance = -150.00; // Set the initial balance to a negative value
        $stmtUpdateBalance->bind_param('di', $initialBalance, $clientId);
    }

    // Execute the client balance update/insert
    if ($stmtUpdateBalance->execute()) {
        echo "Client balance updated/inserted.";

        // Commit the transaction
        $con->commit();

    } else {
        // Roll back the transaction if updating/inserting client balance fails
        $con->rollback();
        echo "Error updating/inserting client balance: " . $stmtUpdateBalance->error;
    }

    // Close the statement for updating/inserting client balance
    $stmtUpdateBalance->close();

} else {
    // Roll back the transaction if scheduling appointment fails
    $con->rollback();
    echo "Error in scheduling appointment: " . $stmtAppointment->error;
}

// Close the statement for the appointment
$stmtAppointment->close();

// Close the database connection
$con->close();
?>
