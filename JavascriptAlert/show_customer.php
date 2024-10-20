<?php
    session_start();

    if(!isset($_SESSION['username'])){
        header('Location: login.php');
        exit();
    }

    $hostname = "localhost";
    $username = "root";
    $password = "1234";
    $database = "mystore";

    // สร้างการเชื่อมต่อฐานข้อมูล
    $conn = new mysqli($hostname, $username, $password, $database);

    // ตรวจสอบการเชื่อมต่อ
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // ตรวจสอบว่ามี customer_id 
    if (isset($_GET['delete_id'])) {
        $customer_id = $_GET['delete_id'];

        // คำสั่ง SQL เพื่อลบข้อมูลลูกค้า
        $sql = "DELETE FROM customer WHERE Customer_id = $customer_id";

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('ลบข้อมูลสำเร็จ');</script>";
        } else {
            echo "<script>alert('เกิดข้อผิดพลาดในการลบข้อมูล: " . $conn->error . "');</script>";
        }

        // รีเฟรช
        echo "<script>window.location.href='show_customer.php';</script>";
        exit();
    }

    if(isset($_POST['logout'])){
        session_destroy();
        header('Location: logout.php');
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Show Customer Webpage</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap');
        table {
            border: 1px solid black;
            border-collapse: collapse;
            margin: 10px auto;
            width: 80%;
            font-family: Kanit, Static;
        }
        th, td {
            border: 1px solid black;
            padding: 1px;
            text-align: center;
            font-weight: bold;
            font-size: 16px;
        }
        th {
            color: blue;
            padding: 5px;
        }
        .name {
            margin-right: 5px;
        }
        .lastname {
            margin-left: 5px;
        }
        .addCustomerContainer {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            margin-bottom: 10px;
            width: 80%;
            margin: 0 auto;
        }
        .addCustPic {
            width: 40px;
            margin-right: 10px;
        }
        .addCustText {
            color: red;
            font-size: 18px;
            text-decoration: underline;
        }
        .editIcon,
        .deleteIcon {
            width: 30px;
            cursor: pointer;
            margin: 5px;
        }
        .userLogoutContainer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 80%;
            margin: 20px auto; 
        }
        .showUser {
            font-weight: bold;
            margin: 0; 
        }
        .logout {
            margin-left: auto; 
        }
    </style>
</head>
<body>
    <div class="userLogoutContainer">
        <div class="showUser">
            <form action="" method="POST">
                <?php
                    $sql = "SELECT Customer_Name, Customer_Lastname FROM customer LIMIT 1";
                    $result = $conn->query($sql);

                    while ($data = $result->fetch_array()){
                        echo "Customer name : ";
                        echo "{$data['Customer_Name']} {$data['Customer_Lastname']}";
                    }
                ?>
            </form>
        </div>
        <div class="logout">
            <form action="" method="POST">
                <label for="logout" style="color: red; cursor: pointer; font-size: 18px; font-weight:bold; text-decoration:underline;">Logout</label>
                <input type="submit" name="logout" id="logout" style="display: none;">
            </form>
        </div>
    </div>
    
    <div class="addCustomerContainer">
        <a href="add_customer.php">
            <img class="addCustPic" src="https://shorturl.asia/euS4h" alt="addCustPic">
            <span class="addCustText">เพิ่มข้อมูลลูกค้า</span>
        </a>
    </div>

    <table>
        <tr>
            <th>ID</th>
            <th>ชื่อ - สกุล</th>
            <th>จังหวัด</th>
            <th>โทรศัพท์</th>
            <th>แก้ไข</th>
            <th>ลบ</th>
        </tr>
        <?php
            $sql = "SELECT * FROM customer";
            $result = $conn->query($sql);

            while ($data = $result->fetch_array()) {
                echo "<tr>";
                echo "<td>{$data['Customer_id']}</td>";
                echo "<td><span class='name'>{$data['Customer_Name']}</span> <span class='lastname'>{$data['Customer_Lastname']}</span></td>";
                echo "<td>{$data['Province']}</td>";
                echo "<td>{$data['Telephone']}</td>";
                echo "<td><a href='edit_customer.php?id={$data['Customer_id']}'><img class='editIcon' src='https://shorturl.asia/eR0qm' alt='Edit'></a></td>";
                echo "<td><a href='show_customer.php?delete_id={$data['Customer_id']}' onclick='return confirm(\"คุณต้องการลบข้อมูลนี้หรือไม่?\")'><img class='deleteIcon' src='https://shorturl.asia/egBdI' alt='Delete'></a></td>";
                echo "</tr>";
            }

            $conn->close();
        ?>
    </table>
</body>
</html>
