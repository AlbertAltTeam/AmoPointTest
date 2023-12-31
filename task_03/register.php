<?php
session_start();

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header('Location: index.php');
    exit;
}

include 'db_connect.php';

$username = $password = $email = '';
$username_err = $password_err = $email_err = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty(trim($_POST["username"]))) {
        $username_err = "Введите имя пользователя";
    } else {
        $username = trim($_POST["username"]);
    }

    if (empty(trim($_POST['password']))) {
        $password_err = "Введите пароль";
    } elseif (strlen(trim($_POST['password'])) < 6) {
        $password_err = "Пароль должен содержать минимум 6 символов";
    } else {
        $password = trim($_POST['password']);
    }

    if (empty(trim($_POST["email"]))) {
        $email_err = "Введите почту";
    } else {
        $email = trim($_POST["email"]);
    }

    if (empty($username_err) && empty($password_err) && empty($email_err)) {
        $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("sss", $param_username, $param_email, $param_password);

            $param_username = $username;
            $param_email = $email;
            $param_password = password_hash($password, PASSWORD_DEFAULT);

            if ($stmt->execute()) {
                header("location: login.php");
            } else {
                echo "Что-то пошло не так. Попробуйте позже.";
            }
        }

        $stmt->close();
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Регистрация</title>
</head>
<body>
    <h2>Регистрация</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div>
            <label for="username">Имя пользователя:</label>
            <input type="text" name="username" value="<?php echo $username; ?>">
            <span><?php echo $username_err; ?></span>
        </div>
        <div>
            <label for="email">Email:</label>
            <input type="text" name="email" value="<?php echo $email; ?>">
            <span><?php echo $email_err; ?></span>
        </div>
        <div>
            <label for="password">Пароль:</label>
            <input type="password" name="password">
            <span><?php echo $password_err; ?></span>
        </div>
        <div>
            <input type="submit" value="Зарегистрироваться">
        </div>
        <p>Уже есть аккаунт? <a href="login.php">Войти</a>.</p>
    </form>
</body>
</html>
