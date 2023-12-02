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

    
    include_once '../nav.php';
    
    global $balance;
    global $hasBalance;
    $id = $_SESSION['id'];

    //1 needs to be replaced with the id variable
    $stmt = $con->prepare('SELECT * FROM balance WHERE userID ='.$id);
    $stmt->execute();
    $result= $stmt->get_result(); 
        if($result->num_rows > 0){
            foreach($result as $row) {
                $balance= $row['balanceAmount']; 
                $hasBalance= true;
            }      
        }else{
            $hasBalance= true;
        }

    function displayBalance(){
        global $balance;
        global $hasBalance;
        if($hasBalance){
            echo number_format($balance, 2);
        }
        else{
            echo '0.00';
        }        
      }
      if(isset($_POST['submit'])){
        addRecord();
      }
      function addRecord(){
        global $con;
        global $balance;
        global $id;
        $paymentAmount=(float)$_POST['txtPaymentAmount'];
        $newUserBalance=(float)$balance-$paymentAmount;
        $balance=$newUserBalance;
        
        //Update the balance of the user in the balance table.
        
        $stmt = $con->prepare('UPDATE balance SET balanceAmount='.$newUserBalance.' WHERE userID='.$id);
        $stmt->execute();
        $result= $stmt->get_result();
        //Insert a new record into the transaction table.
        $tableName='transaction';
        $stmt1=$con->prepare("INSERT INTO `transaction` (`transactionAmount`, `userID`) VALUES (".$paymentAmount.", ".$id.")");
        $stmt1->execute();
        $result1=$stmt1->get_result();

        unset($_POST['submit']);
        unset($_POST['txtPaymentAmount']);
        $_POST['txtPaymentAmount']=0;
        $_POST = array();
        
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
        
                    <input type="text" name="txtPaymentAmount"
                    placeholder="$000,000.00"
                    id="PaymentAmountInput" required>

            </section>

            <h2>Credit Card Information</h2>

            <section id="CreditCardNumber">

                <h3 id="CreditCardNumberHeader">Credit Card Number</h3>

                    <label id="CreditCardNumberLabel">
                      
                    </label>
        
                    <input type="text" name="CreditCardNumber"
                    placeholder="1234 5678 9123 456"
                    id="CreditCardNumberInput" required>

            </section>

            <section id="ExpirationDate">

                <h3 id="ExpirationDateHeader">Expiration Date</h3>

                    <label id="ExpirationDateLabel">
                      
                    </label>
        
                    <input type="text" name="ExpirationDate"
                    placeholder="00/00"
                    id="ExpirationDateInput" pattern="../.." required>

            </section>

            <section id="SecurityCode">

                <h3 id="SecurityCodeHeader">Security Code</h3>

                    <label id="SecurityCodeLabel">
                      
                    </label>
        
                    <input type="text" name="SecurityCode"
                    placeholder="000"
                    id="SecurityCodeInput" pattern="..." required>

            </section>

            <section id="NameOnCard">

                <h3 id="NameOnCardHeader">Name On Debit/Credit Card</h3>

                    <label id="NameOnCardLabel">
                      
                    </label>
        
                    <input type="text" name="NameOnCard"
                    placeholder="FirstName LastName"
                    id="NameOnCardInput" required>

            </section>

            <h2>Billing Address Information</h2>

            <section id="StreetAddress">

                <h3 id="StreetAddressHeader">Street Address</h3>

                    <label id="StreetAddressLabel">
                      
                    </label>
        
                    <input type="text" name="StreetAddress"
                    id="StreetAddressInput" required>

            </section>

            <section id="StateAddress">

                <h3 id="StateAddressHeader">State</h3>

                    <label id="StateAddressLabel">
                      
                    </label>
        
                    <input type="text" name="StateAddress"
                    id="StateAddressInput" pattern=".." placeholder="Two Letter Abbreviation" required>

            </section>

            <section id="ZipCode">

                <h3 id="ZipCodeHeader">Zip Code</h3>

                    <label id="ZipCodeLabel">
                      
                    </label>
        
                    <input type="text" name="ZipCode"
                    id="ZipCodeInput" pattern="....." required>

            </section>

            <section id="Country">

                <h3 id="CountryHeader">Country</h3>

                    <label id="CountryLabel">
                      
                    </label>
        
                    <input type="text" name="Country"
                    id="CountryInput" required>

            </section>

            <section id="SubmitPayment">

                <label id="SubmitPaymentButtonButtonLabel"></label>

                <input type="submit" value="Submit Payment" id="SubmitPaymentButton" name="submit" >

            </section>

        </form>

</div>

    </main>

    <footer id="Footer"></footer>
</body>

</html>
