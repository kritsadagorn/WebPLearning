<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab6.1 65543206002-9</title>

    <style>
        legend{
            font-weight:bold;
            color:black;
            text-shadow: 1px 1px grey;
            letter-spacing: 3px;
        }

        .Table1{
            background-color: #fef9d8;
            margin: 10px;
        }

        body{   
            margin:200px;
        }

        .phpMulti{
            text-align: center;
            margin-bottom: 10px;
        }

        .MultiTp{
            text-align: center;
        }

    </style>
</head>
<body>  
    <div class="MulTable">
        <fieldset class="Table1">
            <legend>Multiplication Table</legend>
            <p class="MultiTp">แม่สูตรคูณของ <strong>2</strong> (ใช้ for loop) : </p>
            <p class="MultiTp">รหัสนักศึกษา 65543206002-9</p>
            <div class="phpMulti">
                <?php
                    $number = 2;
                    for ($i = 1; $i <= 12; $i++) {
                        echo "$number x $i = " . ($number * $i) . "<br>";
                    }
                ?>
            </div>
        </fieldset>
    </div>
</body>
</html>
