<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <?php include 'header.php'; ?>
    <title>Request Details</title>
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
            min-height: 100vh;
            background: #000;
            color: #fff;
            padding: 20px;
        }
        h1 
        {
            font-size: 2.5em;
            color: #0f0;
            margin-bottom: 20px;
        }
        p 
        {
            margin: 10px 0;
            font-size: 1.2em;
        }
        strong 
        {
            color: #0f0;
        }
        a 
        {
            color: #0f0;
            text-decoration: none;
            margin-top: 20px;
            transition: color 0.3s;
        }
        a:hover 
        {
            color: #fff;
        }
        .request-details
        {
            background-color: #222;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <h1>Request Details</h1>
    <div class="request-details">
    <?php
    require_once __DIR__ . '/../config/database.php';
    if (isset($_GET['id'])) {
        $stmt = $pdo->prepare('SELECT request.*, asset.asset_name, user.username FROM request JOIN asset ON request.asset_id = asset.asset_id JOIN user ON request.user_id = user.user_id WHERE request_id = ?');
        $stmt->execute([$_GET['id']]);
        $request = $stmt->fetch();
        if ($request) {
            echo "<p><strong>Asset:</strong> {$request['asset_name']}</p>";
            echo "<p><strong>User:</strong> {$request['username']}</p>";
            echo "<p><strong>Request Date:</strong> {$request['request_date']}</p>";
            echo "<p><strong>Status:</strong> {$request['approval_status']}</p>";
            echo "<p><strong>Usage Purpose:</strong> {$request['usage_purpose']}</p>";
            echo "<p><strong>Required By Date:</strong> {$request['required_by_date']}</p>";
            echo "<p><strong>Justification:</strong> {$request['justification']}</p>";
            if ($request['approval_status'] != 'Pending') {
                echo "<p><strong>Approved By:</strong> {$request['approved_by']}</p>";
                echo "<p><strong>Approval Date:</strong> {$request['approval_date']}</p>";
            }
        } else {
            echo "<p>Request not found.</p>";
        }
    } else {
        echo "<p>No request selected.</p>";
    }
    ?>
    </div>
    <a href="index.php?page=requests">Back to Request List</a>
</body>
</html>
