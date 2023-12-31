<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <?php
    include_once 'nav.php';
    ?>
</head>
<body>

<main class="container">
    <div class="inner-container">
        <div class="index">
            <?php
            include 'main.php';

            $stmt = $con->prepare("SELECT a.*, at.timeStart, at.timeFinish FROM appointment a
                                INNER JOIN appointmentTime at ON a.timeID = at.timeID
                                WHERE a.clientID = ? AND a.date >= CURDATE() ORDER BY a.date ASC LIMIT 5");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $appointments_result = $stmt->get_result();

            $stmt = $con->prepare("SELECT first_name, last_name FROM users WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt_result = $stmt->get_result();

            echo "<div class='grid-item' id='header'>";
            if($stmt_result->num_rows > 0) {
                $data = $stmt_result->fetch_assoc();
                echo "<h2>Welcome back, " . $data['first_name'] . " " . $data['last_name'] . "!</h2><br>";
            }
            echo "</div>";

            // Display upcoming appointments
            echo "<div class='grid-item' id='upcomingApts'>";
            echo "<h3>Upcoming Appointments</h3>";
            if($appointments_result->num_rows > 0) {
                echo "<ul>";
                while ($appointment = $appointments_result->fetch_assoc()) {
                    $formattedStartTime = date('g:i A', strtotime($appointment['timeStart']));
                    $formattedEndTime = date('g:i A', strtotime($appointment['timeFinish']));

                    echo "<li>Appointment on " . $appointment['date'] . " from " . $formattedStartTime . " to " . $formattedEndTime . "</li>";
                }
                echo "</ul>";
            } else {
                echo "<p>No Upcoming Appointments.</p>";
            }
            echo "</div>";

            // Get the client's account balance
            $stmtBalance = $con->prepare("SELECT balanceAmount FROM balance WHERE userID = ?");
            $stmtBalance->bind_param("i", $id);
            $stmtBalance->execute();
            $balance_result = $stmtBalance->get_result();
            
            // Get the client's account balance
            echo "<div class='grid-item' id='actBal'>";
            echo "<h3>Account Balance</h3>";
            if($balance_result->num_rows > 0) {
                $balance = $balance_result->fetch_assoc()['balanceAmount'];
                echo "<p>Your current balance: $" . $balance . "</p>";
            } else {
                echo "<p>No account balance found.</p>";
            }
            echo "</div>";

            $stmt->close();
            $stmtBalance->close();
            $con->close();
            ?>
        </div>    
    </div>
</main>

</body>
</html>
