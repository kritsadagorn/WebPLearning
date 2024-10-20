<?php
    $hostname = "localhost";
    $username = "root";
    $password = "1234";
    $database = "mystore";

    $conn = new mysqli($hostname, $username, $password, $database);

    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }else{
        echo "Connected successfully";
    }

   
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $gender = $_POST['gender'];
        $birthdate_day = $_POST['day'];
        $birthdate_month = $_POST['month'];
        $birthdate_year = $_POST['year'];
        $address = $_POST['address'];
        $descripe = $_POST['descripe'];
        $province = $_POST['province'];
        $zipcode = $_POST['zipcode'];
        $telephone = $_POST['telephone'];
        $username = $_POST['username'];
        $password = $_POST['password'];

        // เปลี่ยนปีคศ เป็น พศ
        $birthdateyChange = $birthdate_year - 543;
        $birthdate = $birthdateyChange . '-' . $birthdate_month . '-' . $birthdate_day;

        $birthdateObject = new DateTime($birthdate); 
        $today = new DateTime(); 
        $age = $today->diff($birthdateObject)->y; 

        $sql = "INSERT INTO customer (Customer_Name, Customer_Lastname, Gender, Age, Birthdate, Address, Province, Zipcode, Telephone, Customer_Description, username, password)
                VALUES ('$fname', '$lname', '$gender', '$age', '$birthdate', '$address', '$province', '$zipcode', '$telephone', '$descripe', '$username', '$password')";

        // Check query
        if ($conn->query($sql) === TRUE) {
            echo "New customer added successfully!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    $conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Customer</title>
    <style>
    * {
        box-sizing: border-box;
    }

    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f9;
        margin: 0;
        padding: 0;
    }

    .container {
        max-width: 800px;
        margin: 50px auto;
        padding: 20px;
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    h2 {
        text-align: center;
        color: #333;
    }

    form {
        display: flex;
        flex-direction: column;
    }

    .information {
        margin-left: 50px;
        margin-top: 10px;
    }

    .information div {
        display: flex;
        justify-content: space-between;
        margin-bottom: 15px;
        align-items: center;
    }

    label {
        font-weight: bold;
        width: 150px;
        text-align: right;
        margin-right: 20px;
    }

    input[type="text"], input[type="password"], select, textarea {
        flex: 1;
        padding: 8px;
        font-size: 14px;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    textarea {
        resize: vertical;
    }

    input[type="radio"] {
        margin-right: 10px;
    }

    .birthdate select {
        width: 30%;
    }

    .buttons {
        display: flex;
        justify-content: flex-start;
        margin-top: 20px;
    }

    input[type="submit"], button {
        padding: 10px 20px;
        font-size: 14px;
        border: none;
        border-radius: 5px;
        background-color: #28a745;
        color: white;
        cursor: pointer;
        margin-right: 15px;
    }

    button {
        background-color: #dc3545;
    }

    input[type="submit"]:hover, button:hover {
        background-color: #218838;
    }

    button:hover {
        background-color: #c82333;
    }

    @media (max-width: 768px) {
        .container {
            margin: 20px;
            padding: 15px;
        }

        .information div {
            flex-direction: column;
            align-items: flex-start;
        }

        label {
            width: 100%;
            text-align: left;
            margin-bottom: 5px;
        }

        input[type="submit"], button {
            width: 100%;
            margin-top: 10px;
        }

    }

    </style>
</head>
<body>
    <div class="container">
        <form method='POST' name='AddCustomer'>
            <div style='colo r:red;text-decoration: underline;font-weight:bold;'>เพิ่มข้อมูลลูกค้า</div>
            <div style='margin: 30px 30px;font-weight:bold;'>ข้อมูลลูกค้า</div>
            <div class="information">
                <div class="fname">
                    <label for="fname">ชื่อ : </label>
                    <input type="text" name="fname">
                </div>
                <div class="lname">
                    <label for="lname">นามสกุล : </label>
                    <input type="text" name="lname">
                </div>
                <div class="gender">
                    <label for="gender">เพศ : </label>
                    <input type="radio" name="gender" value="ชาย"> ชาย
                    <input type="radio" name="gender" value="หญิง"> หญิง
                </div>
                <div class="birthdate">
                    <label for="birthdate">วัน-เดือน-ปี เกิด : </label>
                    <select name='day'>
                        <?php for ($i=1; $i <= 31; $i++) {
                            echo "<option value='$i'>$i</option>";
                        } ?>
                    </select>
                    <select name='month'>
                        <option value='01'>มกราคม</option>
                        <option value='02'>กุมภาพันธ์</option>
                        <option value='03'>มีนาคม</option>
                        <option value='04'>เมษายน</option>
                        <option value='05'>พฤษภาคม</option>
                        <option value='06'>มิถุนายน</option>
                        <option value='07'>กรกฎาคม</option>
                        <option value='08'>สิงหาคม</option>
                        <option value='09'>กันยายน</option>
                        <option value='10'>ตุลาคม</option>
                        <option value='11'>พฤศจิกายน</option>
                        <option value='12'>ธันวาคม</option>
                    </select>
                    <select name='year'>
                        <?php for ($i=2567; $i >= 2530; $i--) {
                            echo "<option value='$i'>$i</option>";
                        } ?>
                    </select>
                </div>
                <div class="address">
                    <label for="address">ที่อยู่ : </label>
                    <input type="text" name="address">
                </div>
                <div class="province">
                    <label for="province">จังหวัด : </label>
                    <select name='province'>
                        <option value='เชียงราย'>เชียงราย</option>
                        <option value='น่าน'>น่าน</option>
                        <option value='พะเยา'>พะเยา</option>
                        <option value='เชียงใหม่'>เชียงใหม่</option>
                        <option value='แม่ฮ่องสอน'>แม่ฮ่องสอน</option>
                        <option value='แพร่'>แพร่</option>
                        <option value='ลำปาง'>ลำปาง</option>
                        <option value='ลำพูน'>ลำพูน</option>
                        <option value='ตาก'>ตาก</option>
                        <option value='อุตรดิตถ์'>อุตรดิตถ์</option>
                        <option value='พิษณุโลก'>พิษณุโลก</option>
                        <option value='สุโขทัย'>สุโขทัย</option>
                        <option value='เพชรบูรณ์'>เพชรบูรณ์</option>
                        <option value='พิจิตร'>พิจิตร</option>
                        <option value='กำแพงเพชร'>กำแพงเพชร</option>
                        <option value='นครสวรรค์'>นครสวรรค์</option>
                        <option value='อุทัยธานี'>อุทัยธานี</option>
                    </select>
                </div>
                <div class="zipcode">
                    <label for="zipcode">รหัสไปรษณีย์ : </label>
                    <input type="text" name="zipcode">
                </div>
                <div class="telephone">
                    <label for="telephone">โทรศัพท์ : </label>
                    <input type="text" name="telephone">
                </div>
                <div class="descripe">
                    <label for="descripe">รายละเอียดอื่นๆ : </label>
                    <textarea name="descripe" id="descripe"></textarea>
                </div>
                <div class="username">
                    <label for="username">Username : </label>
                    <input type="text" name="username">
                </div>
                <div class="password">
                    <label for="password">Password : </label>
                    <input type="password" name="password">
                </div>

                <div class="buttons">
                    <input type="submit" value="เพิ่มข้อมูลลูกค้า">
                    <button type="button" onclick="window.location.href='show_customer.php';">กลับ</button>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
