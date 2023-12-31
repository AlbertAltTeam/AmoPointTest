<?php
session_start();

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header('Location: index.php');
    exit;
}

include 'db_connect.php';

$email = $password = '';
$email_err = $password_err = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty(trim($_POST["email"]))) {
        $email_err = "Введите почту";
    } else {
        $email = trim($_POST["email"]);
    }

    if (empty(trim($_POST['password']))) {
        $password_err = "Введите пароль";
    } else {
        $password = trim($_POST['password']);
    }

    if (empty($email_err) && empty($password_err)) {
        $sql = "SELECT id, username, email, password FROM users WHERE email = ?";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("s", $param_email);
            $param_email = $email;

            if ($stmt->execute()) {
                $stmt->store_result();

                if ($stmt->num_rows == 1) {
                    $stmt->bind_result($id, $username, $email, $hashed_password);
                    if ($stmt->fetch()) {
                        if (password_verify($password, $hashed_password)) {
                            session_start();

                            $_SESSION['loggedin'] = true;
                            $_SESSION['username'] = $username;
                            $_SESSION['id'] = $id;

                            header('Location: index.php');
                        } else {
                            $password_err = 'Неверный пароль';
                        }
                    }
                } else {
                    $email_err = 'Пользователь с такой почтой не найден';
                }
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
    <title>Вход</title>
</head>
<body>
    <h2>Вход</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
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
            <input type="submit" value="Войти">
        </div>
        <p>Нет аккаунта? <a href="register.php">Зарегистрироваться</a>.</p>
    </form>
</body>
</html>
