<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $callbackData = json_decode(file_get_contents('php://input'), true);

    $resultCode = $callbackData['Body']['stkCallback']['ResultCode'];
    $pnr = $callbackData['Body']['stkCallback']['CallbackMetadata']['Item'][0]['Value'];

    if ($resultCode === 0) {
       
        $stmt = $conn->prepare("UPDATE passengers SET payment_status = 'Paid' WHERE PNR = ?");
        $stmt->bind_param("s", $pnr);
        $stmt->execute();
        $stmt->close();
    } else {
        
    }
}
?>
