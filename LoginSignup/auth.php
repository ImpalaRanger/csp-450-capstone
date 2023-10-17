<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authenticating...</title>
</head>
<body>

    <?php
        $email = $_POST['email'];
        $password = $_POST['password'];

        $con = new mysqli("localhost", "root", "mysql", "therapy");
        if($con->connect_error) {
            die("Failed to connect : ".$con->connect_error);
        }
        else {
            $stmt = $con->prepare("select * from users where email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt_result = $stmt->get_result();
            if($stmt_result->num_rows > 0) {
                $data = $stmt_result->fetch_assoc();
                if($data['password'] === $password) {
                    echo "<h2>Login successful for user ".$data['first_name']." ".$data['last_name'];
                    echo "<form id='redirect' action='../dash.php' method='POST'>";
                    echo "<input type='hidden' name='user_id' value='".$data['id']."'>";
                    echo "</form>";
                    echo "<script type='text/javascript'>";
                    echo "document.getElementById('redirect').submit();";
                    echo "</script>";
                }
                else {
                    echo "<h2>invalid password for <h2>";
                    echo $data['email'];
                    header('Location: login.html');
                    die();
                }
            } else {
                echo "<h2>Invalid Email<h2>";
                header('Location: login.html');
                die();
            }
        }
    //https://www.sitepoint.com/community/t/how-to-do-redirect-in-php-with-post-and-not-get/4968
    
    
    
    
    ?>
</body>
</html>
