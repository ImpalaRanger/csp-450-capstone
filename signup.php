<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup Page</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <?php
        $con = new mysqli("localhost", "root", "mysql", "therapy");
        if($con->connect_error) {
            die("Failed to connect : ".$con->connect_error);
        }
        else { // if connection works

            if(isset($_POST['first-name']) && isset($_POST['last-name'])
            && isset($_POST['email']) && isset($_POST['password'])) {
                // run query to see if email is unique

                $firstName = $_POST['first-name'];
                $lastName = $_POST['last-name'];
                $email = $_POST['email'];
                $password = $_POST['password'];

                $unique = true;

                $stmt = $con->prepare("select * from users where email = ?");
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $stmt_result = $stmt->get_result();
                if($stmt_result->num_rows > 0) {
                    // means email not unique
                    //$data = $stmt_result->fetch_assoc();
                    if(isset($_POST['hidSubmitFlag']) && $_POST['hidSubmitFlag'] == '01') {
                        echo "<h3>That email is already in use.</h3>";
                    }
                } else {
                    // email unique
                    $stmt = $con->prepare("INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `password`)
                    VALUES (NULL, ?, ?, ?, ?);");
                    $stmt->bind_param("ssss", $firstName, $lastName, $email, $password);
                    $stmt->execute();

                    header('Location: login.html');
                    die();
                }
            }
        }
    ?>


    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2>Sign Up</h2>
            </div>
            <div class="card-body">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                    <div class="form-group">
                        <label for="first-name">First name</label><br>
                        <input type="text" id="first-name" class="form-control" name="first-name" required/>
                    </div>
                    <div class="form-group">
                        <label for="last-name">Last name</label><br>
                        <input type="text" id="last-name" class="form-control" name="last-name" required/>
                    </div>
                    <div class="form-group">
                        <label id="email-label" for="email">Email</label><br>
                        <input type="email" id="email" class="form-control" name="email" required/>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label><br>
                        <input type="password" id="password" class="form-control" name="password" required/>
                    </div>
                    <input type='hidden' name='hidSubmitFlag' id='hidSubmitFlag' value='01'/>
                    <input type="submit" class="btn" value="Sign up" name="">
                </form>
            </div>
            <div class="card-footer">
                Already have an account?
                <form action="login.html">
                    <button class="btn" type="submit">Log in to account</button>
                 </form>
            </div>
        </div>
    </div>
</body>
</html>
