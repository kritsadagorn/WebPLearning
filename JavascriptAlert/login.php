<?php
    session_start();

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

    if($_SERVER['REQUEST_METHOD'] == 'POST' ){
        $username = $_POST['username'];
        $password = $_POST['password'];
    
        $sql = "SELECT * FROM customer WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0){
            $userid = $result->fetch_assoc();

            if($password == $userid['password']){
                $_SESSION['username'] = $username;
                header('Location: show_customer.php');
                exit;   
            } else {
                echo "รหัสผ่านไม่ถูกต้อง";
            }
        } else {
            echo "ไม่พบผู้ใช้นี้ในระบบ";
        }
    }

    

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Webpage</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 300px;
            margin: 100px auto;
            background: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .topic {
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }

        .username, .password {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        button {
            width: 48%;
            padding: 10px;
            background-color: #5cb85c;
            border: none;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #4cae4c;
        }

        button[type="reset"] {
            background-color: #d9534f;
        }

        button[type="reset"]:hover {
            background-color: #c9302c;
        }

    </style>
</head>
<body>
    <div class="container">
        <div class="topic">Log In</div>
        <form method="POST">
            <div class="username">
                <label for="Username">Username : </label>
                <input type="text" name="username" require>
            </div>
            <div class="password">
                <label for="Password">Password : </label>
                <input type="password" name="password" require>
                <button type="submit">Login</button>
                <button type="reset">Cancel</button>
            </div>
        </form>
        
    </div>
</body>
</html>