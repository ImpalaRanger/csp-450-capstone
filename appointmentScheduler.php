<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Scheduler</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" type="text/css" href="styles.css">
    <?php
    include_once 'nav.php';
    ?>
    <style>
        label {padding: 5px; line-height: 3;}
        body {padding-left: 15%; padding-right: 15%;}
    </style>
</head>
<body>
    <main class="container" style="background-color: white;">
        <div id="appointment-form">
            <h1>Appointment Scheduler</h1>
            <form>
                <label for="selectName">Select a Name:</label>
                <select id="selectName" name="selectName">
                    <!-- Populate this dropdown with names from the database -->
                    <option value="Name1">Name1</option>
                    <option value="Name2">Name2</option>
                </select><br>
                
                <label for="selectDate">Select a Date:</label>
                <input type="date" id="selectDate" name="selectDate"><br>

                

                <label for="selectTime">Select a Time:</label>
                <select id="selectTime" name="selectTime">
                    <option value="07:00">7:00 AM</option>
                    <option value="08:00">8:00 AM</option>
                </select><br>

                <button class="btn" type="submit">Schedule Appointment</button>
            </form>
        </div>
    </main>

    <footer style="text-align: center;">
        <h1>Footer Placeholder</h1>
    </footer>

</body>
</html>
