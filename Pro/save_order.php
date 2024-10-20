<?php
$hostname = "localhost";
$username = "root";
$password = "";
$dbname = "shabudbtest";

$conn = new mysqli($hostname, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // รับค่า customer_id จาก POST
    $customer_id = isset($_POST['customer_id']) ? intval($_POST['customer_id']) : 0;

    // เช็คว่ามี order จาก customer_id นี้แล้วหรือยัง ถ้าไม่มีก็เริ่มจาก orderList ที่ 1
    $sql = "SELECT MAX(orderList) as max_order FROM admintable WHERE Customer_ID = $customer_id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $orderList = $row['max_order'] ? $row['max_order'] + 1 : 1;

    // รับค่าของ order ที่ส่งมาในรูปแบบ JSON
    $order = json_decode($_POST['order'], true);

    // เริ่มสร้างคำสั่ง SQL เพื่อ INSERT ข้อมูล
    $sql = "INSERT INTO admintable (Customer_ID, orderList, ";
    $values = "VALUES ($customer_id, $orderList, ";

    // Loop เพื่อสร้าง SQL และตรวจสอบว่ามีอาหารที่เลือกไว้หรือไม่
    for ($i = 1; $i <= 15; $i++) {
        $sql .= "`$i`, ";
        $values .= (isset($order[$i]) && $order[$i] != 0) ? $order[$i] . ", " : "null, ";
    }

    // ตัดเครื่องหมาย comma สุดท้ายออกแล้วปิด SQL Statement
    $sql = rtrim($sql, ", ") . ") " . rtrim($values, ", ") . ")";

    // ทำการบันทึกข้อมูลลงฐานข้อมูล
    if ($conn->query($sql) === TRUE) {
        echo "Order saved successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();

?>
