<?php
session_start();
include "../db.php";
require 'config.php';
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;

if (isset($_GET['success']) && $_GET['success'] == 'true') {
    $paymentId = $_GET['paymentId'];
    $payment = Payment::get($paymentId, $apiContext);

    $execution = new PaymentExecution();
    $execution->setPayerId($_GET['PayerID']);

    try {
        $result = $payment->execute($execution, $apiContext);

        $sql = "UPDATE orders_info SET paymentId='$paymentId' AND p_status=1 WHERE order_id = ".$_SESSION['last_order_id']." AND user_id = '$_SESSION[uid]'";
        if(mysqli_query($con,$sql)){
            unset($_SESSION['last_order_id']);
            echo"<script>window.location.href='http://localhost/online-shopping-system/store.php'</script>";
        }
    } catch (Exception $ex) {
        // Handle error
        exit(1);
    }
} else {
    echo "User cancelled the payment.";
}
