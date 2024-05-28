<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Unauthorized Access</title>
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
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background: #000;
            color: #fff;
            padding: 20px;
        }
        h1 
        {
            font-size: 2.5em;
            color: #f00;
            margin-bottom: 20px;
        }
        p 
        {
            font-size: 1.5em;
            margin-bottom: 20px;
        }
        a 
        {
            color: #0f0;
            text-decoration: none;
            padding: 10px 20px;
            background-color: #0f0;
            color: #000;
            border-radius: 5px;
            transition: background-color 0.3s, box-shadow 0.3s;
        }
        a:hover 
        {
            background-color: #0c0;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <h1>Unauthorized Access</h1>
    <p>You do not have permission to view this page.</p>
    <a href="index.php?page=dashboard">Go to Dashboard</a>
</body>
</html>
