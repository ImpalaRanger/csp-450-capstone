<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Scheduler</title>
    <link rel="stylesheet" type="text/css" href="../styles.css">
    <?php
    include_once '../nav.php';
    include_once '../main.php'; // Include the database connection file

    // Query to select users where isTherapist is null
    $query = "SELECT id, first_name, last_name FROM users WHERE isTherapist IS NOT NULL";

    // Use a prepared statement to execute the query
    $stmt = $con->prepare($query);

    if ($stmt === false) {
        die('Error in preparing the statement.');
    }

    // Execute the statement
    $stmt->execute();

    // Get the result set
    $result = $stmt->get_result();

    // Query to select time values from the appointmenttime table
    $timeQuery = "SELECT timeID, timeStart, timeFinish FROM appointmenttime";
    $timeResult = $con->query($timeQuery);
    ?>
</head>
<body>
    <main class="container">
        <h1 style="text-align:center">Appointment Scheduler</h1>
        <div id="appointment-form" class="inner-container">
            <form id="aptForm" method="post" action="submitAppointment.php">
                <label for="selectName">Select a Name:</label>
                <select id="selectName" name="selectName">
                    <option value="">Select a Therapist</option>
                    <?php
                    while ($row = $result->fetch_assoc()) {
                        $fullName = $row['first_name'] . ' ' . $row['last_name'];
                        echo "<option value='{$row['id']}'>$fullName</option>";
                    }
                    ?>
                </select><br>

                <label for="selectDate">Select a Date:</label>
                <input type="date" id="selectDate" name="selectDate"><br>

                <label for="selectTime">Select a Time:</label>
                <select id="selectTime" name="selectTime">
                    <option value="">Select a Time</option>
                    <?php
                    while ($timeRow = $timeResult->fetch_assoc()) {
                        $formattedTime = date('h:i A', strtotime($timeRow['timeStart'])) . ' - ' . date('h:i A', strtotime($timeRow['timeFinish']));
                        echo "<option value='{$timeRow['timeID']}'>$formattedTime</option>";
                    }
                    ?>
                </select><br>

                <button class="btn" type="button" onclick="checkAvailability()">Check Availability</button>
                <div id="submit-container"></div> <!-- Container for the submit button -->
            </form>
        </div>
    </main>

    <footer style="text-align: center;">
        <h1>Footer Placeholder</h1>
    </footer>

    <?php
    $stmt->close();
    $con->close();
    ?>

<script>
    function checkAvailability() {
        // Get selected values
        var therapistId = document.getElementById('selectName').value;
        var selectedDate = document.getElementById('selectDate').value;
        var selectedTimeId = document.getElementById('selectTime').value;

        // Ajax request to check availability
        var xhttp = new XMLHttpRequest();

        // Send the request to the server
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                // Handle the response, show a popup or modify the UI accordingly
                var response = this.responseText.trim();
                if (response === "available") {
                    alert("Appointment slot is available. You can proceed to schedule.");
                    showSubmitButton(); // Show the submit button
                } else {
                    alert("Selected appointment slot is not available. Please pick a new time.");
                }
            }
        };

        xhttp.open("GET", "checkAvailability.php?therapistId=" + therapistId + "&selectedDate=" + selectedDate + "&selectedTimeID=" + selectedTimeId, true);
        xhttp.send();
    }

    function showSubmitButton() {
        // Create a submit button
        var submitButton = document.createElement("button");
        submitButton.className = "btn";
        submitButton.type = "button"; // Change to "button" to prevent form submission
        submitButton.textContent = "Submit Appointment";

        // Add a click event listener to the submit button
        submitButton.addEventListener("click", function () {
            submitAppointment();
        });

        // Append the submit button to the submit-container
        document.getElementById("submit-container").appendChild(submitButton);
    }

    function submitAppointment() {
        // Submit the form when the button is clicked
        //document.querySelector('form').submit();
        var therapistId = document.getElementById('selectName').value;
        var selectedDate = document.getElementById('selectDate').value;
        var selectedTimeId = document.getElementById('selectTime').value;

        // Create a form data object
        var formData = new FormData();
        formData.append('selectName', therapistId);
        formData.append('selectDate', selectedDate);
        formData.append('selectTime', selectedTimeId);

        // Use fetch to submit the form asynchronously
        fetch('submitAppointment.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            // Open a new pop-up window and write the data
            var popupWindow = window.open('', 'appointmentPopup', 'width=600,height=400,scrollbars=yes,resizable=yes');
            popupWindow.document.write(data);

            // Add an event listener for the unload event on the pop-up window
            popupWindow.addEventListener('unload', function () {
                // Refresh the original page when the pop-up window is closed
                location.reload();
            });
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while processing the request.');
        });
    }
</script>

</body>
</html>
