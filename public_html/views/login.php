<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
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
        }
        section 
        {
            position: absolute;
            width: 100vw;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 2px;
            flex-wrap: wrap;
            overflow: hidden;
        }
        section::before 
        {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            background: linear-gradient(#000,#0f0,#000);
            animation: animate 5s linear infinite;
        }
        @keyframes animate 
        {
            0%
            {
                transform: translateY(-100%);
            }
            100%
            {
                transform: translateY(100%);
            }
        }
        section span 
        {
            position: relative;
            display: block;
            width: calc(6.25vw - 2px);
            height: calc(6.25vw - 2px);
            background: #181818;
            z-index: 2;
            transition: 1.5s;
        }
        section span:hover 
        {
            background: #0f0;
            transition: 0s;
        }

        section .signin
        {
            position: absolute;
            width: 400px;
            background: #222;  
            z-index: 1000;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            padding: 20px 40px;
            border-radius: 8px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.9);
        }
        section .signin .content 
        {
            position: relative;
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            gap: 20px;
        }
        section .signin .content h1 
        {
            font-size: 1.8em;
            color: #0f0;
            margin-bottom: 10px;
            text-align: center;
        }
        section .signin .content h2 
        {
            font-size: 1.5em;
            color: #0f0;
            text-transform: uppercase;
        }
        section .signin .content .form 
        {
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        section .signin .content .form .inputBox
        {
            position: relative;
            width: 100%;
        }
        section .signin .content .form .inputBox input 
        {
            position: relative;
            width: 100%;
            background: #333;
            border: none;
            outline: none;
            padding: 15px 10px 5px;
            border-radius: 4px;
            color: #fff;
            font-weight: 500;
            font-size: 1em;
        }
        section .signin .content .form .inputBox i 
        {
            position: absolute;
            left: 0;
            padding: 10px 10px;
            font-style: normal;
            color: #aaa;
            transition: 0.5s;
            pointer-events: none;
        }
        .signin .content .form .inputBox input:focus ~ i,
        .signin .content .form .inputBox input:valid ~ i
        {
            transform: translateY(-7.5px);
            font-size: 0.8em;
            color: #fff;
        }
        .signin .content .form .links 
        {
            position: relative;
            width: 100%;
            display: flex;
            justify-content: space-between;
        }
        .signin .content .form .links a 
        {
            color: #fff;
            text-decoration: none;
        }
        .signin .content .form .links a:nth-child(2)
        {
            color: #0f0;
            font-weight: 600;
        }
        .signin .content .form .inputBox input[type="submit"]
        {
            padding: 10px;
            background: #0f0;
            color: #000;
            font-weight: 600;
            font-size: 1.2em;
            letter-spacing: 0.05em;
            cursor: pointer;
            border: none;
            border-radius: 4px;
        }
        input[type="submit"]:active
        {
            opacity: 0.6;
        }
        .register-button 
        {
            display: inline-block;
            margin-top: 10px;
            padding: 10px 20px;
            background: #0f0;
            color: #000;
            border-radius: 4px;
            text-decoration: none;
            font-weight: 600;
            transition: background-color 0.3s, box-shadow 0.3s;
        }
        .register-button:hover 
        {
            background-color: #0c0;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }
        @media (max-width: 900px)
        {
            section span 
            {
                width: calc(10vw - 2px);
                height: calc(10vw - 2px);
            }
        }
        @media (max-width: 600px)
        {
            section span 
            {
                width: calc(20vw - 2px);
                height: calc(20vw - 2px);
            }
        }
        .error-message {
            color: #f00;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <section>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <div class="signin">
            <div class="content">
                <h1>Lab Asset Management System</h1>
                <h2>Login</h2>
                <?php
                if (isset($_GET['error'])) {
                    $error = $_GET['error'];
                    $errorMessage = '';
                    if ($error == 'invalid_credentials') {
                        $errorMessage = 'Invalid username or password. Please try again.';
                    } elseif ($error == 'account_locked') {
                        $errorMessage = 'Your account is locked. Please contact the system administrator.';
                    }
                    echo "<p class='error-message'>{$errorMessage}</p>";
                }
                ?>
                <form class="form" action="../actions/login_action.php" method="post">
                    <div class="inputBox">
                        <input type="text" name="username" id="username" required>
                        <i>Username</i>
                    </div>
                    <div class="inputBox">
                        <input type="password" name="password" id="password" required>
                        <i>Password</i>
                    </div>
                    <div class="inputBox">
                        <input type="submit" value="Login">
                    </div>
                </form>
                <a href="../views/register.php" class="register-button">Register</a>
            </div>
        </div>
    </section>
</body>
</html>
