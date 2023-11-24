<?php
include_once '../main.php'; // Include the database connection file

// Get the values from the form
$therapistId = $_POST['selectName'];
$clientId = $id; // Assuming $id is available in this context
$selectedDate = $_POST['selectDate'];
$selectedTimeId = $_POST['selectTime'];
$status = 1;

// Insert into the appointment table using prepared statements to prevent SQL injection
$query = "INSERT INTO appointment (therapistID, clientID, date, timeID, statusID) VALUES (?, ?, ?, ?, ?)";

$stmt = $con->prepare($query);

if ($stmt === false) {
    die('Error in preparing the statement.');
}

$stmt->bind_param('iissi', $therapistId, $clientId, $selectedDate, $selectedTimeId, $status);

if ($stmt->execute()) {
    echo "Appointment successfully scheduled.";
} else {
    echo "Error in scheduling appointment.";
}

$stmt->close();
$con->close();
?>
