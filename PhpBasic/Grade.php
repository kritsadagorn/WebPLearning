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

        body{   
            margin:200px;
        }

        .phpGrade{
            display: inline;
        }

        #GetF,
        #Cheat{
            background-color: red;
            color: white;

        }

        #GetA,
        #GetBp,
        #GetB{
            background-color: green;
        }

        #GetCp,
        #GetC,
        #GetDp,
        #GetD{
            background-color: yellow;
        }
        
        fieldset{
            background-color: #ffffe6;
        }

    </style>
</head>
<body>
<div class="GradeTable">
            <fieldset class="Table2">
                <legend>Grade</legend>
                <p class="GradeTp">แสดงเกณฑ์การตัดเกรด</p>
                <div class="phpGrade">
                    <?php

                        if (!isset($_GET['grade'])) {
                            // ถ้ายังไม่มีการกำหนดค่า grade ให้เพิ่มค่า grade=0 ลงใน URL
                            header("Location: ?grade=0");
                            exit;
                        }

                        $grade = intval($_GET['grade']); 
                        
                        if($grade > 100){
                            echo "<span id='Cheat'>$grade คะแนน : ไม่มีระดับเกณฑ์ในการตัดคะแนนนี้</span>";
                        }
                        elseif($grade >= 80){
                            echo "<span id='GetA'>$grade คะแนน : ได้รับระดับคะแนน A</span>";
                        }
                        elseif($grade >= 75){
                            echo "<span id='GetBp'>$grade คะแนน : ได้รับระดับคะแนน B+</span>";
                        }
                        elseif($grade >= 70){
                            echo "<span id='GetB'>$grade คะแนน : ได้รับระดับคะแนน B</span>";
                        }
                        elseif($grade >= 65){
                            echo "<span id='GetCp'>$grade คะแนน : ได้รับระดับคะแนน C+</span>";
                        }
                        elseif($grade >= 60){
                            echo "<span id='GetC'>$grade คะแนน : ได้รับระดับคะแนน C</span>";
                        }
                        elseif($grade >= 55){
                            echo "<span id='GetDp'>$grade คะแนน : ได้รับระดับคะแนน D+</span>";
                        }
                        elseif($grade >= 50){
                            echo "<span id='GetD'>$grade คะแนน : ได้รับระดับคะแนน D</span>";
                        }
                        else{
                            echo "<span id='GetF'>$grade คะแนน : ได้รับระดับคะแนน F</span>";
                        }

                    ?>
                </div>
            </fieldset>
</body>
</html>
