<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" type="text/css" href="../styles.css">
    <?php
    include_once '../nav.php';

    // Check if the form has been submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $firstName = htmlspecialchars($_POST['firstName']);
        $lastName = htmlspecialchars($_POST['lastName']);
        $username = htmlspecialchars($_POST['username']);
        $email = htmlspecialchars($_POST['email']);
        $question = htmlspecialchars($_POST['question']);

        $to = 'dirzyk@comcast.net';
        $subject = 'New Contact Us Message';
        $message = "First Name: $firstName\nLast Name: $lastName\nUsername: $username\nEmail: $email\nQuestion: $question";
        $headers = "From: webmaster@example.com\r\n";
        $headers .= "Reply-To: webmaster@example.com\r\n";
        $headers .= "X-Mailer: PHP/" . phpversion();

        if (mail($to, $subject, $message, $headers)) {
            echo "<p>Message sent successfully!</p>";
        } else {
            echo "<p>Message sending failed.</p>";
        }
    }
    ?>
</head>
<body>

    <main class="container">
        <div class="inner-container">
            <div class="contact-info">
                <section class="contact-section">
                    <h1>Contact Us</h1>
                </section>
                
                <section class="contact-section">
                    <h3>Our Phone Number</h3>
                    <p>123-456-7890</p>
                </section>

                <section class="contact-section">
                    <h3>Our Email Address</h3>
                    <p>info@example.com</p>
                </section>

                <section class="contact-section">
                    <h3>Contact Form</h3>
                    <form class="contact-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" id="contactForm">
                        <label for="firstName">First Name:</label>
                        <input type="text" id="firstName" name="firstName" required>

                        <label for="lastName">Last Name:</label>
                        <input type="text" id="lastName" name="lastName" required>

                        <label for="username">Username:</label>
                        <input type="text" id="username" name="username" required>

                        <label for="email">Email Address:</label>
                        <input type="email" id="email" name="email" required>

                        <label for="question">Your Question:</label>
                        <textarea id="question" name="question" rows="4" required></textarea>

                        <input type="submit" value="Submit">
                    </form>
                </section>
            </div>
        </div>
    </main>

    <footer>
        <!-- Footer content goes here -->
    </footer>
    <script src="ContactUs.js"></script>
</body>
</html>

