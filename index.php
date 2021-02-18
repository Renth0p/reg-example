<?php
    require_once 'connect.php';

    if(isset($_POST['done']) && !empty($_POST['login']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['password_check'])) {
        $password_check = trim($_POST['password_check']);
        $password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);
        $user_email = trim($_POST['email']);
        $user_login = trim($_POST['login']);
        $register = $db->prepare("INSERT INTO user (login, email, password) VALUES ($login, $email, $password)");
         
        $login_check = $db->prepare("SELECT * FROM user WHERE login = $login");
        $login_check->execute();
        $login = $login_check->fetch(PDO::FETCH_ASSOC);
        $login_confirm = $login['login'];

        $email_check = $db->prepare("SELECT * FROM user WHERE email = $email");
        $email_check->execute();
        $email = $email_check->fetch(PDO::FETCH_ASSOC);
        $email_confirm = $email['email'];

        if(count($login_confirm) < 1) {
            if(count($email_confirm) < 1) {
                if(password_verify($password_check, $password)) {
                    $register->execute();
                    $_SESSION['user_login'] = $user_login;
                    $_SESSION['user_email'] = $user_email;
                    header('Location: lk.php');
                } else {
                    echo 'Пароли не совпадают';
                }
            } else {
                echo 'Пользователь с таким email уже существует';
            }
        } else {
            echo 'Пользователь с таким логином уже существует';
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Test</title>
</head>
<body>
    <form method="post">
        <input type="text" name="login" required>
        <input type="text" name="email" required>
        <input type="password" name="password" required>
        <input type="password" name="password_check" required>
        <button name="done">Вход</button>
    </form>
</body>
</html>