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

    //Create MySQL Procedural Style
    // $conn = mysqli_connect($hostname,$username,$password,$database);
    // ObjO      Style
    $conn = new mysqli($hostname,$username,$password,$database);
    
    // Check conection Method 1 (Procedural)
    // if (mysqli_connect_errno()){
    //     echo "Failed to connect to MySQL: " . mysqli_connect_error();
    //     exit(); 
    // }

    // Check Connection Method2 (ObjO)
    if ($conn -> connect_error){
        die("Connection failed: " . $conn->connect_error);
    }
    echo "Connected successfully";
    
    if (isset($_GET['id'])) {
        $customer_id = $_GET['id'];

        // Fetch the customer data to display in the form
        $sql = "SELECT * FROM customer WHERE Customer_ID = $customer_id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $customer = $result->fetch_assoc();
        } else {
            echo "Customer not found.";
            exit();
        }
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $gender = $_POST['gender'];
        $birthdate_day = $_POST['day'];
        $birthdate_month = $_POST['month'];
        $birthdate_year = $_POST['year'];
        $address = $_POST['address'];
        $province = $_POST['province'];
        $zipcode = $_POST['zipcode'];
        $telephone = $_POST['telephone'];
        $descripe = $_POST['descripe'];

        $birthdateyChange = $birthdate_year - 543;
        $birthdate = $birthdateyChange . '-' . $birthdate_month . '-' . $birthdate_day;

        $birthdateObject = new DateTime($birthdate); 
        $today = new DateTime(); 
        $age = $today->diff($birthdateObject)->y; 

        $sql = "UPDATE customer SET 
            Customer_Name = '$fname',
            Customer_Lastname = '$lname',
            Gender = '$gender',
            Age = '$age',
            Birthdate = '$birthdate',
            Address = '$address',
            Province ='$province',
            Zipcode = '$zipcode',
            Telephone = '$telephone',
            Customer_Description = '$descripe'
            WHERE Customer_ID = $customer_id";

        if ($conn -> query($sql) === TRUE){
            echo "Data Updated";
        } else{
            echo "Error updating Record : " . $conn -> error;
        }
    }

    $conn -> close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Customer Webpage</title>

    <style>
    .container {
        margin: 20px;
        font-family: Tahoma, sans-serif;
        font-size: 14px;
        border: 1px solid #000;
        padding: 20px;
        width: 600px;
        background-color: #f9f9f9;
    }

    .information {
        margin-left: 50px;
        margin-top: 10px;
    }

    label {
        padding-right: 20px;
        font-weight: bold;
        display: inline-block;
        width: 150px;
        text-align: right;
    }

    input[type="text"],
    select,
    textarea {
        padding: 5px;
        width: 300px;
        font-size: 14px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    input[type="radio"] {
        margin-left: 10px;
        margin-right: 5px;
    }

    .buttons {
        margin-top: 20px;
        text-align: center;
    }

    .back_button {
        margin-top: 20px;
    }

    input[type="submit"], 
    button {
        background-color: #4CAF50;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    input[type="submit"]:hover, 
    button:hover {
        background-color: #45a049;
    }

    textarea {
        width: 300px;
        height: 80px;
        border: 1px solid #ccc;
        border-radius: 5px;
        resize: none;
    }

    div.fname,
    div.lname,
    div.gender,
    div.birthdate,
    div.address,
    div.province,
    div.zipcode,
    div.tel,
    div.descripe {
        margin-bottom: 10px;
    }

    div.fname input,
    div.lname input,
    div.address input,
    div.zipcode input,
    div.tel input {
        width: 300px;
    }

    div.descripe textarea {
        width: 300px;
    }

    div.buttons input[type="submit"] {
        margin-right: 10px;
    }

    div.back_button button {
        margin-left: 10px;
        background-color: #f44336;
    }

    div.back_button button:hover {
        background-color: #d32f2f;
    }

    .error {
        color: red;
        font-weight: bold;
        margin-bottom: 15px;
        text-align: center;
    }
    .birthdate {
        display: flex;
        justify-content: space-between;
        width: 500px;
    }

    .birthdate label {
        padding-right: 20px;
        font-weight: bold;
        width: 150px;
        text-align: right;
    }

    .birthdate select {
        padding: 5px;
        width: 45%;
        font-size: 14px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    </style>
</head>
<body>
    <div class="container">
        <form method = 'POST' name = 'EditCustomer'>
        <div style='color:red;text-decoration: underline;font-weight:bold;'>แก้ไขข้อมูลลูกค้า</div>
            <div style='margin: 30px 30px;font-weight:bold;'>ข้อมูลลูกค้า</div>
            <div class="information">
                <div class="fname">
                    <label for="fname">ชื่อ : </label>
                    <input type="text" name="fname" value="<?php echo $customer['Customer_Name']; ?>"><br>
                </div>
                
                <div class="lname">
                    <label for="lname">ชื่อ : </label>
                    <input type="text" name="lname" value="<?php echo $customer['Customer_Lastname']; ?>"><br>
                </div>

                <div class="gender">
                    <label for="gender">เพศ : </label>
                    <input type="radio" name="gender" value="ชาย" <?php echo ($customer['Gender'] == 'ชาย') ? 'checked' : ''; ?>>ชาย
                    <input type="radio" name="gender" value="หญิง" <?php echo ($customer['Gender'] == 'หญิง') ? 'checked' : ''; ?>>หญิง
                </div>

                <div class="birthdate">
                    <label for="birthdate">วันเกิด : </label>
                    <select name="day">
                        <?php for ($i = 1; $i <= 31; $i++) { ?>
                            <option value="<?php echo $i; ?>" <?php echo ($i == date('j', strtotime($customer['Birthdate']))) ? 'selected' : ''; ?>><?php echo $i; ?></option>
                        <?php } ?>
                    </select>
                    <select name="month">
                        <?php
                        $months = array("มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
                        foreach ($months as $index => $month) {
                            $selected = ($index + 1 == date('n', strtotime($customer['Birthdate']))) ? 'selected' : '';
                            echo "<option value='" . ($index + 1) . "' $selected>$month</option>";
                        }
                        ?>
                    </select>
                    <select name="year">
                        <?php for ($i = date('Y'); $i >= 1900; $i--) { ?>
                            <option value="<?php echo $i; ?>" <?php echo ($i == date('Y', strtotime($customer['Birthdate']))) ? 'selected' : ''; ?>><?php echo $i; ?></option>
                        <?php } ?>
                    </select>
                </div>
                    <div class="address">
                        <label for="address">ที่อยู่ : </label>
                        <input type="text" name="address" value="<?php echo $customer['Address']; ?>"><br>
                    </div>

                    <div class="province">
                        <label for="province">จังหวัด : </label>
                        <select name="province" id="province">
                        <?php
                        $province_array = array("เชียงราย","น่าน","พะเยา","เชียงใหม่","แม่ฮ่องสอน","แพร่","ลำปาง","ลำพูน","ตาก","อุตรดิตถ์","พิษณุโลก","สุโขทัย","เพชรบูรณ์","พิจิตร","กำแพงเพชร","นครสวรรค์","อุทัยธานี");
                        foreach ($province_array as $province) {
                            // เช็คว่า province ในฐานข้อมูลตรงกับ option ปัจจุบันหรือไม่
                            $selected = ($province == $customer['Province']) ? 'selected' : '';
                            echo "<option value='$province' $selected>$province</option>";
                        }    
                        ?>  
                        </select>
                    </div>

                    <div class="zipcode">
                        <label for="zipcode">รหัสไปรษณีย์ : </label>
                        <input type="text" name="zipcode" value="<?php echo $customer['Zipcode']; ?>"><br>
                    </div>

                    <div class="tel">
                        <label for="telephone">โทรศัพท์ : </label>
                        <input type="text" name="telephone" value="<?php echo $customer['Telephone']; ?>"><br>
                    </div>

                    <div class="descripe">
                        <label for="descripe">รายละเอียดอื่นๆ : </label>
                        <textarea name="descripe" id="descripe"><?php echo $customer['Customer_Description']; ?></textarea><br>
                    </div>

                    <div class="back_button">
                        <input type="submit" value="เพิ่มข้อมูลลูกค้า">
                        <button type="button" onclick="window.location.href='show_customer.php';">กลับ</button>
                    </div>
                
            </div>
        </form>
    </div>
</body>
</html>