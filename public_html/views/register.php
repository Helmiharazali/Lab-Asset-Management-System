<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
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

        section .register
        {
            position: absolute;
            width: 400px;
            background: #222;  
            z-index: 1000;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px;
            border-radius: 4px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.9);
        }
        section .register .content 
        {
            position: relative;
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            gap: 40px;
        }
        section .register .content h2 
        {
            font-size: 2em;
            color: #0f0;
            text-transform: uppercase;
        }
        section .register .content .form 
        {
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 25px;
        }
        section .register .content .form .inputBox
        {
            position: relative;
            width: 100%;
        }
        section .register .content .form .inputBox input,
        section .register .content .form .inputBox select
        {
            position: relative;
            width: 100%;
            background: #333;
            border: none;
            outline: none;
            padding: 25px 10px 7.5px;
            border-radius: 4px;
            color: #fff;
            font-weight: 500;
            font-size: 1em;
        }
        section .register .content .form .inputBox i 
        {
            position: absolute;
            left: 0;
            padding: 15px 10px;
            font-style: normal;
            color: #aaa;
            transition: 0.5s;
            pointer-events: none;
        }
        .register .content .form .inputBox input:focus ~ i,
        .register .content .form .inputBox input:valid ~ i,
        .register .content .form .inputBox select:focus ~ i,
        .register .content .form .inputBox select:valid ~ i
        {
            transform: translateY(-7.5px);
            font-size: 0.8em;
            color: #fff;
        }
        .register .content .form .inputBox input[type="submit"],
        .register .content .form button
        {
            padding: 10px;
            background: #0f0;
            color: #000;
            font-weight: 600;
            font-size: 1.35em;
            letter-spacing: 0.05em;
            cursor: pointer;
            border: none;
            border-radius: 4px;
        }
        input[type="submit"]:active,
        button:active
        {
            opacity: 0.6;
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
        <div class="register">
            <div class="content">
                <h2>Register</h2>
                <form class="form" action="../actions/register_request_action.php" method="post">
                    <div class="inputBox">
                        <input type="text" name="username" id="username" required>
                        <i>Username</i>
                    </div>
                    <div class="inputBox">
                        <input type="email" name="email" id="email" required>
                        <i>Email</i>
                    </div>
                    <div class="inputBox">
                        <input type="password" name="password" id="password" required>
                        <i>Password</i>
                    </div>
                    <div class="inputBox">
                        <select name="role_id" id="role_id" required>
                            <option value="" disabled selected></option>
                            <?php
                            require '../config/database.php';
                            $roles = $pdo->query('SELECT * FROM Role');
                            while ($role = $roles->fetch()) {
                                echo "<option value='{$role['role_id']}'>{$role['role_name']}</option>";
                            }
                            ?>
                        </select>
                        <i>Role</i>
                    </div>
                    <div class="inputBox">
                        <select name="department_id" id="department_id" required>
                            <option value="" disabled selected></option>
                            <?php
                            $departments = $pdo->query('SELECT * FROM Department');
                            while ($department = $departments->fetch()) {
                                echo "<option value='{$department['department_id']}'>{$department['department_name']}</option>";
                            }
                            ?>
                        </select>
                        <i>Department</i>
                    </div>
                    <button type="submit">Submit Registration Request</button>
                </form>
            </div>
        </div>
    </section>
</body>
</html>
