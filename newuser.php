<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Process new user</title>
</head>
<body>
    <?php
        $firstName = $_POST['first-name'];
        $lastName = $_POST['last-name'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        $con = new mysqli("localhost", "root", "mysql", "therapy");
        if($con->connect_error) {
            die("Failed to connect : ".$con->connect_error);
        }
        else { // if connection works

            
            
            // if email is unique redirect to login page
            $stmt = $con->prepare("INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `password`)
            VALUES (NULL, ?, ?, ?, ?);");
            $stmt->bind_param("ssss", $firstName, $lastName, $email, $password);
            $stmt->execute();

            header('Location: login.html');
            die();

        }
    ?>
</body>
</html>
