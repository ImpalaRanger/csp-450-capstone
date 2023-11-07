<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <link rel="stylesheet" type="text/css" href="ProfilePage.css">
    <link rel="stylesheet" type="text/css" href="../styles.css">
    <?php
    include_once '../nav.php';
    ?>
</head>
<body>
    
    <?php
    
    include_once '../main.php';

    $stmt = $con->prepare('select * from users where id = ?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    while($userInfo = $result->fetch_assoc()) {
        $firstName = $userInfo['first_name'];
        $lastName = $userInfo['last_name'];
        $email = $userInfo['email'];
    }
    
    ?>

    <main id="ProfilePage" class="container">

        <h1 id="Header1">Profile Page</h1>
    <div class="inner-container">

        <section id="TextFields">
        
            <form action="">

                <section id="FirstName">

                    <h2 id="FirstNameHeader">First Name</h2>

                    <?php echo '<p id="FirstName">'. $firstName .'</p>' ?>

                </section>

                <section id="LastName">

                    <h2 id="LastNameHeader">Last Name</h2>

                    <?php echo '<p id="LastName">'. $lastName .'</p>' ?>

                </section>

                <section id="EmailSection">

                    <h2 id="EmailHeader">Email</h2>

                    <?php echo '<p id="EmailAddress">'. $email .'</p>' ?>

                </section>

                <section id="UserIDSection">

                    <h2 id="UserIDHeader">User ID</h2>
        
                    <?php echo '<p id="Id">' . $id . '</p>' ?>

                </section>

            </form>


        </section>

    </div>
    </main>

    <footer id="Footer">

    </footer>
</body>

</html>
