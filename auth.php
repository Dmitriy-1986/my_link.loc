<?php
session_start();

if(isset($_SESSION['admin'])) {
    header("Location: index.php");
    exit;
}

$login = 'admin';
$password = '1b2e7b8e0b9a9a418874f5f300340930';
// echo md5('qwerty111');

if(isset($_POST['submit'])) {
    if($login == $_POST['login'] AND $password == md5($_POST['password'])) {
        $_SESSION['admin'] = $login;
        header("Location: index.php");
        exit;
    } else {
        echo "<div style='color: red;'>Не правильный логин или пароль!</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: calc(100vh - 16px);
            font-family: sans-serif;
        }

        .form-container {
            width: 350px;
            height: 300px;
            margin: 0 auto;
        }

        .form-input, .form-input-btn {
            margin: 5px 0;
            padding: 10px;
            width: 350px;
        }

        .form-input-btn {
            width: 110px;
            background-color: blue;
            color: white;
            border: 1px solid blue;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <form method="POST">
            <input type="text" name="login" class="form-input" placeholder="Логин"><br>
            <input type="password" name="password" class="form-input" placeholder="Пароль"><br>
            <input type="submit" name="submit" value="Отправить" class="form-input-btn">
        </form>
    </div>
</body>
</html>