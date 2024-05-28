<?php
session_start();
require_once __DIR__ . '/../config/database.php';

function isExist($username, $email) {
    global $pdo;
    $stmt = $pdo->prepare('SELECT * FROM user WHERE username = ? OR email = ?');
    $stmt->execute([$username, $email]);
    return $stmt->fetch() ? true : false;
}

$username = $_POST['username'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_BCRYPT);
$role_id = $_POST['role_id'];
$department_id = $_POST['department_id'];

if (isExist($username, $email)) {
    $message = 'Username or email already exists';
} else {
    $stmt = $pdo->prepare('INSERT INTO registrationrequests (username, email, password, role_id, department_id) VALUES (?, ?, ?, ?, ?)');
    $stmt->execute([$username, $email, $password, $role_id, $department_id]);
    $message = 'Registration request submitted successfully';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registration Status</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap');
        *
        {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Quicksand', sans-serif;
        }
        body 
        {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: #000;
            color: #fff;
            padding: 20px;
        }
        .message 
        {
            background-color: #222;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .message p 
        {
            font-size: 1.5em;
            color: #0f0;
        }
        .message a 
        {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #0f0;
            color: #000;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s, box-shadow 0.3s;
        }
        .message a:hover 
        {
            background-color: #0c0;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="message">
        <p><?php echo $message; ?></p>
        <a href="../index.php?page=login">Go to Login</a>
    </div>
</body>
</html>
