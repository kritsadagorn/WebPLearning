<?php
session_start();
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: Arial, sans-serif;
            text-align: center;
        }
        .message {
            font-size: 24px;
            margin-bottom: 20px;
        }
        .login-link {
            font-size: 18px;
            color: blue;
            text-decoration: underline;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="message">
        ออกจากระบบแล้ว !!<br>
        <span class="login-link" onclick="location.href='login.php'">ลงชื่อเข้าใช้อีกครั้ง</span>
    </div>
</body>
</html>
