<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Page</title>
    <link rel="stylesheet" type="text/css" href="PaymentPage.css">
    <link rel="stylesheet" type="text/css" href="../styles.css">
    <?php
    include '../main.php';

        session_start();

    if (isset($_POST['fromAuth']) && isset($_POST['fromAuth']) == '01') {
        $_SESSION['id'] = $_POST['user_id'];
    }

    $id = $_SESSION['id'];
    $con = new mysqli("localhost", "root", "mysql", "therapy");

    if($con->connect_error) {
        exit('Could not connect');
    }

    function displayBalance(){
        $con = new mysqli("localhost", "root", "mysql", "therapy");
        $stmt = $con->prepare('SELECT * FROM balance WHERE userID = 1');
        $stmt->execute();
        echo $stmt->get_result();
    }
    ?>
    
</head>
<body>

    
    <main id="PaymentPage" class="container">

        <h1 id="Header1">Payment Page</h1>

        <div class="inner-container">

            <section id="CurrentBalanceSection">

                <h2 id="CurrentBalanceHeader">Current Balance</h2>

                <?php
                displayBalance();
                ?>
            

            
        <form action="<?php $self?>" method="POST" id="PaymentInformation">

            <section id="PaymentAmount">

                <h3 id="PaymentAmountHeader">Payment Amount</h3>

                    <label id="PaymentAmountLabel">
                      
                    </label>
        
                    <input type="text" name="PaymentAmount"
                    placeholder="$000,000.00"
                    id="PaymentAmountInput">

            </section>

            <h2>Credit Card Information</h2>

            <section id="CreditCardNumber">

                <h3 id="CreditCardNumberHeader">Credit Card Number</h3>

                    <label id="CreditCardNumberLabel">
                      
                    </label>
        
                    <input type="text" name="CreditCardNumber"
                    placeholder="1234 5678 9123 456"
                    id="CreditCardNumberInput">

            </section>

            <section id="ExpirationDate">

                <h3 id="ExpirationDateHeader">Expiration Date</h3>

                    <label id="ExpirationDateLabel">
                      
                    </label>
        
                    <input type="text" name="ExpirationDate"
                    placeholder="00/00"
                    id="ExpirationDateInput">

            </section>

            <section id="SecurityCode">

                <h3 id="SecurityCodeHeader">Security Code</h3>

                    <label id="SecurityCodeLabel">
                      
                    </label>
        
                    <input type="text" name="SecurityCode"
                    placeholder="000"
                    id="SecurityCodeInput">

            </section>

            <section id="NameOnCard">

                <h3 id="NameOnCardHeader">Name On Debit/Credit Card</h3>

                    <label id="NameOnCardLabel">
                      
                    </label>
        
                    <input type="text" name="NameOnCard"
                    placeholder="FirstName LastName"
                    id="NameOnCardInput">

            </section>

            <h2>Billing Address Information</h2>

            <section id="StreetAddress">

                <h3 id="StreetAddressHeader">Street Address</h3>

                    <label id="StreetAddressLabel">
                      
                    </label>
        
                    <input type="text" name="StreetAddress"
                    id="StreetAddressInput">

            </section>

            <section id="StateAddress">

                <h3 id="StateAddressHeader">State</h3>

                    <label id="StateAddressLabel">
                      
                    </label>
        
                    <input type="text" name="StateAddress"
                    id="StateAddressInput">

            </section>

            <section id="ZipCode">

                <h3 id="ZipCodeHeader">Zip Code</h3>

                    <label id="ZipCodeLabel">
                      
                    </label>
        
                    <input type="text" name="ZipCode"
                    id="ZipCodeInput">

            </section>

            <section id="Country">

                <h3 id="CountryHeader">Country</h3>

                    <label id="CountryLabel">
                      
                    </label>
        
                    <input type="text" name="Country"
                    id="CountryInput">

            </section>

            <section id="SubmitPayment">

                <label id="SubmitPaymentButtonButtonLabel"></label>

                <input type="submit" value="Submit Payment" id="SubmitPaymentButton">

            </section>

        </form>

</div>

    </main>

    <footer id="Footer"></footer>
</body>

</html>
