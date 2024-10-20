<?php
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $name = isset($_POST['name']) ? trim($_POST['name']) : '';
        $surname = isset($_POST['surname']) ? trim($_POST['surname']) : '';

        $file = 'myfile.txt';
        $open = fopen($file, 'a');

        if ($open){
            fwrite($open,"My Name is $name\nMy Surname is $surname");
            fclose($open);
        }   
    }
?>