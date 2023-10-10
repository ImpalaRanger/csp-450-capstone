<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
Dashboard
    <?php
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
                echo "<h2>Welcome back, ".$data['first_name']." ".$data['last_name']."!";
            }
        }
    
    
    
    
    ?>
</body>
</html>
