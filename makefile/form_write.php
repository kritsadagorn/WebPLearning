<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Webpage</title>
    <style>
        input[type='text']{
            margin-bottom:10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <form action="writefile.php" method="POST">
            <div class="name">
                <label for="name">Name : </label>
                <input type="text" name="name">
            </div>
            <div class="surname">
                <label for="surname">Surname : </label>
                <input type="text" name="surname">
            </div>
            <button type="submit">Save</button>
        </form>
    </div>
</body>
</html>