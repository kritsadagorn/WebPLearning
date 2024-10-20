<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab7 65543206002-9</title>
    <style>
        .container{
            margin: 0;
            padding: 0;
            width: 400px;
            font-size: 13px;
            font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            letter-spacing: 0.1px;
        }
        
        .lastname span{
            padding-right: 42px;
        }
        .firstname span{
            padding-right: 40px;
        }

        .gender{
            padding: 0;
            margin: 0;
        }

        .Birth span{
            margin-right: 70px;
        }    

        select {
            margin-right: 10px;
        }

        .gender #male{
            margin: 0px 0px 20px 55px;
        }

        fieldset{
            margin: 0 20px;
        }
        
        #firstname{
            background-color: #cdc5bf;
            border: none;
            margin-bottom: 15px;
        }

        #lastname{
            background-color: #98fb98;
            border: none;
            margin-bottom: 15px;
        }
        
        #username{
            width: 120px;
            border: blue 2px solid;
            margin-bottom: 15px;
            margin-left: 50px;
        }

        #password{
            width: 120px;
            border: red 2px solid;
            margin-bottom: 15px;
            margin-left: 55px;
        }

        #re-password{
            width: 120px;
            border: red 2px solid;
            margin-bottom: 15px;
            margin-left: 5px;
        }

        #email{
            width: 180px;
            border: blue 2px solid;
            margin-bottom: 15px;
            margin-left: 75px;
        }

        #PI::first-letter,
        #AI::first-letter{
            font-size: 25px;
            color: red;
        }

        .check{
            padding-left: 5px;
        }

        .personal-info{
            margin: 5px;
        }

        .smBtn{
            padding: 5px 20px;
            margin: 15px 0px 10px 110px;
        }

        input[type="text"][name="Fname"]{
            color:blue;
        }

    </style>
</head>
<body>
    <form name="form1" action="index2.php" method="POST">
        <div class="container">
            <fieldset>
                <legend id="PI">Personal Info</legend>
                <div class="personal-info">
                    <div class="firstname">
                        <span>First name : </span>
                        <input type="text" name="Fname" id="firstname" required>
                    </div>
                    <div class="lastname">
                        <span>Last name : </span>
                        <input type="text" name="Lname" id="lastname" required>
                    </div>
                    <div class="gender">
                        <span>Gender : </span>
                        <input type="radio" id="male" value="male" name="gender" require>
                        <span for="male">Male</span>
                        <input type="radio" id="female" value="female" name="gender" require>
                        <span for="female">Female</span>
                    </div>
                    <div class="Birth">
                        <span id="birth">Birth : </span>
                        <select name="day" id="day" require>
                            <?php 
                                for ($i = 1; $i <= 31; $i++) echo "<option value='$i'>$i</option>"; 
                            ?>
                        </select>
                        <select name="month" id="month" require>
                            <option value="มกราคม">มกราคม</option>
                            <option value="กุมภาพันธ์">กุมภาพันธ์</option>
                            <option value="มีนาคม">มีนาคม</option>
                            <option value="เมษายน">เมษายน</option>
                            <option value="พฤษภาคม">พฤษภาคม</option>
                            <option value="มิถุนายน">มิถุนายน</option>
                            <option value="กรกฎาคม">กรกฎาคม</option>
                            <option value="สิงหาคม">สิงหาคม</option>
                            <option value="กันยายน">กันยายน</option>
                            <option value="ตุลาคม">ตุลาคม</option>
                            <option value="พฤศจิกายน">พฤศจิกายน</option>
                            <option value="ธันวาคม">ธันวาคม</option>
                        </select>
                        <select name="year" id="year">
                            <?php
                                for ($year = 2567; $year >= 2495; $year--){
                                    echo "<option value='$year'>$year</option>";
                                }
                            ?>
                        </select>
                    </div> 
                </div>
            </fieldset>
            <fieldset>
                <legend id="AI">Account Info</legend>
                <div class="AccountInfo">
                    <div class="username">
                        <span>Username : </span>
                        <input type="text" id="username" name ="username" required>
                    </div>
                    <div class="password">
                        <span>Password : </span>
                        <input type="password" id="password" name ="password" required>
                    </div>
                    <div class="re-password">
                        <span>Confirm Password : </span>
                        <input type="password" id="re-password" name ="re-password" required>
                    </div>
                    <div class="email">
                        <span>E-mail : </span>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="checkbox">
                        <input type="checkbox" name ="agree" >
                        <span class="check">I agree to the Terms of Service and Privacy Policy.</span>
                    </div>
                    <div class="smBtn">
                        <input type="submit" name="SM" value="Submit">
                    </div>
                </div>
            </fieldset>
        </div>
    </form>
</body>
</html>
