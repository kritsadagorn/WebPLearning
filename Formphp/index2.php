<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Show Data</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 20px;
        }
        .container {
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            margin: auto;
        }
        .container div {
            margin-bottom: 10px;
        }
        .container strong {
            display: inline-block;
            width: 150px; 
        }
        .error {
            color: red;
            font-weight: bold;
        }
        .success {
            color: green;
            font-weight: bold;
        }
        button {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
        //Name & Lastname
        if(isset($_POST["Fname"]) && isset($_POST["Lname"])){
            echo "<div><strong>ชื่อ - สกุล :</strong> " . $_POST["Fname"] . " " . $_POST["Lname"] . "</div>";
        } else {
            echo "<div><strong>ชื่อ - สกุล :</strong> - </div>";
        }

        //Gender
        if(isset($_POST["gender"])){
            $genderText = ($_POST["gender"] == "male") ? "ชาย" : "หญิง";
            echo "<div><strong>เพศ :</strong> $genderText </div>";
        }

        //Birthdate
        if(isset($_POST["day"]) && isset($_POST["month"]) && isset($_POST["year"])){
            echo "<div><strong>วันเกิด :</strong> " . $_POST["day"] . " " . $_POST["month"] . " " . ((int)$_POST["year"] - 543) . "</div>";
        }

        //Username
        if(isset($_POST["username"])){
            echo "<div><strong>Username :</strong> " . $_POST["username"] . "</div>";
        }

        //Password
        if(isset($_POST["password"])){
            $count = strlen($_POST["password"]);
            echo "<div><strong>Password :</strong> " . str_repeat("*", $count) . "</div>";
        }

        //Email
        if(isset($_POST["email"])){
            echo "<div><strong>Email :</strong> " . $_POST["email"] . "</div>";
        }

        //Current Time
        $currentTime = date("l F d,Y h:i:s a");
        echo "<div><strong>เวลาที่ลงทะเบียน :</strong> $currentTime</div>";

        $credit = 0;

        //Agree Check
        if(isset($_POST["SM"])){
            if(!isset($_POST["agree"])){
                echo "<div class='error'>ไม่ได้ยอมรับข้อตกลง!!</div>";
                echo "<a href='Lab7_65543206002-9.php'><button>BACK</button></a>";
                $credit = 0;
            } else {
                $credit += 1;
            }
        }

        //Password Check
        if(isset($_POST["password"]) && isset($_POST["re-password"])){
            if($_POST["password"] != $_POST["re-password"]){
                echo "<div class='error'>รหัสผ่านไม่ตรงกัน!!</div>";
                echo "<a href='Lab7_65543206002-9.php'><button>BACK</button></a>";
                $credit = 0;
            } else {
                $credit += 1;
            }
        }

        //Date Check
        $month = array(
            'มกราคม',
            'กุมภาพันธ์',
            'มีนาคม',
            'เมษายน',
            'พฤษภาคม',
            'มิถุนายน',
            'กรกฎาคม',
            'สิงหาคม',
            'กันยายน',
            'ตุลาคม',
            'พฤศจิกายน',
            'ธันวาคม'
        );

        $daysInMonth = array(
            'มกราคม' => 31,
            'กุมภาพันธ์' => 28,
            'มีนาคม' => 31,
            'เมษายน' => 30,
            'พฤษภาคม' => 31,
            'มิถุนายน' => 30,
            'กรกฎาคม' => 31,
            'สิงหาคม' => 31,
            'กันยายน' => 30,
            'ตุลาคม' => 31,
            'พฤศจิกายน' => 30,
            'ธันวาคม' => 31
        );

        function chDate($month, $day, $daysInMonth) {
            if (in_array($month, array_keys($daysInMonth))) {
                $dayLimit = $daysInMonth[$month];
                return $day > 0 && $day <= $dayLimit;
            }
            return false;
        }

        if (isset($_POST["month"]) && isset($_POST["day"])) {
            $selectedMonth = $_POST["month"];
            $selectedDay = (int)$_POST["day"];

            if (chDate($selectedMonth, $selectedDay, $daysInMonth)) {
                $credit += 1;
            } else {
                echo "<div class='error'>วันที่ไม่ถูกต้อง!!</div>";
                echo "<a href='Lab7_65543206002-9.php'><button>BACK</button></a>";
                $credit = 0;
            }
        }

        if ($credit == 3){
            echo "<div class='success'>ข้อมูลของคุณจัดถูกจัดเก็บแล้ว</div>";
        }
        ?>
    </div>
</body>
</html>
