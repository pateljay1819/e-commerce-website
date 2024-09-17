<?php
session_start();
include "../db.php";
require 'config.php';
    use PayPal\Api\Payer;
    use PayPal\Api\Item;
    use PayPal\Api\ItemList;
    use PayPal\Api\Details;
    use PayPal\Api\Amount;
    use PayPal\Api\Transaction;
    use PayPal\Api\RedirectUrls;
    use PayPal\Api\Payment;
if (isset($_SESSION["uid"]) && isset($_SESSION["last_order_id"])) {
    
    $sql0="SELECT * from `orders_info` where order_id = ".$_SESSION['last_order_id']." and user_id = ".$_SESSION['uid']."";
    $runquery=mysqli_query($con,$sql0);
    if (mysqli_num_rows($runquery) == 0) {
        echo "SOmethimg wrong";
    }else if (mysqli_num_rows($runquery) > 0) {
        $row = mysqli_fetch_array($runquery);
        $total_amt= $row["total_amt"];
        echo( mysqli_error($con));
    }

    // Create a new payer instance
    $payer = new Payer();
    $payer->setPaymentMethod("paypal");

    // Set the item details
    $item = new Item();
    $item->setName('Online shop Product')
        ->setCurrency('USD')
        ->setQuantity(1)
        ->setPrice($total_amt);

    $itemList = new ItemList();
    $itemList->setItems(array($item));

    // Set the amount details
    $amount = new Amount();
    $amount->setCurrency("USD")
        ->setTotal($total_amt);

    // Set the transaction details
    $transaction = new Transaction();
    $transaction->setAmount($amount)
                ->setItemList($itemList)
                ->setDescription("Payment description")
                ->setInvoiceNumber(uniqid());
    // Set the redirect URLs
    $redirectUrls = new RedirectUrls();
    $redirectUrls->setReturnUrl("http://localhost/online-shopping-system/paypal/execute_payment.php?success=true")
                ->setCancelUrl("http://localhost/online-shopping-system/paypal/execute_payment.php?success=false");

    // Create the payment instance
    $payment = new Payment();
    $payment->setIntent("sale")
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions(array($transaction));

    // Create the payment on PayPal
    try {
        $payment->create($apiContext);
        header("Location: " . $payment->getApprovalLink());
    } catch (Exception $ex) {
        // Handle error
        exit(1);
    }
}