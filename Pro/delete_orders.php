<?php
$hostname = "localhost";
$username = "root";
$password = "";
$dbname = "shabudbtest";

$conn = new mysqli($hostname, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => "Connection failed: " . $conn->connect_error]));
}

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['orders']) && is_array($data['orders'])) {
    $successCount = 0;
    $errorCount = 0;

    foreach ($data['orders'] as $order) {
        $orderList = $conn->real_escape_string($order['orderList']);
        $customerId = $conn->real_escape_string($order['customerId']);

        $sql = "DELETE FROM admintable WHERE orderList = '$orderList' AND Customer_ID = '$customerId'";
        
        if ($conn->query($sql) === TRUE) {
            $successCount++;
        } else {
            $errorCount++;
        }
    }

    if ($errorCount == 0) {
        echo json_encode(['success' => true, 'message' => "$successCount รายการถูกลบเรียบร้อยแล้ว"]);
    } else {
        echo json_encode(['success' => false, 'message' => "ลบสำเร็จ $successCount รายการ, ล้มเหลว $errorCount รายการ"]);
    }
} else {
    echo json_encode(['success' => false, 'message' => "ไม่มีข้อมูลที่จะลบ"]);
}

$conn->close();
?>