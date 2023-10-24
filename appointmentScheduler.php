<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Scheduler</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <style>
        label {padding: 5px; line-height: 3;}
        body {padding-left: 15%; padding-right: 15%;}
    </style>
</head>
<body>
    <?php
    /*
        $id = $_POST['user_id'];
        echo "user id is: ".$id;

        $con = new mysqli("localhost", "root", "mysql", "therapy");
        if($con->connect_error) {
            die("Failed to connect : ".$con->connect_error);
        }
        else {
            $stmt = $con->prepare("select * from users where id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt_result = $stmt->get_result();
            if($stmt_result->num_rows > 0) {
                $data = $stmt_result->fetch_assoc();
                echo "<h2>Welcome back, ".$data['first_name']." ".$data['last_name']."!</h2><br>";
                echo "Here is your information: <br>";
                echo "Gender: " . $data['Gender'] . "<br>";
                if($data['isTherapist'] === 0) {
                    echo "You are a therapist.";
                }
                else {
                    echo "You are NOT a therapist.";
                }
            }
        }   
        */ 
    ?>

    <header style="text-align: center;">
        <h1>Header Placeholder</h1>
    </header>

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
