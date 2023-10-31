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

Dashboard
    <?php

        include 'main.php';

        $stmt = $con->prepare("select * from users where id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt_result = $stmt->get_result();
        if($stmt_result->num_rows > 0) {
            $data = $stmt_result->fetch_assoc();
            $_SESSION['id'] = $id;
            echo $id;
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
        

        
    
    
    
    
    ?>

    
</body>
</html>
