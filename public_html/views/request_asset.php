<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <?php include 'header.php'; ?>
    <title>Request Asset</title>
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
        form 
        {
            background-color: #222;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
        }
        label 
        {
            display: block;
            margin: 10px 0 5px;
            color: #0f0;
        }
        input, select, textarea 
        {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #333;
            border-radius: 5px;
            background: #333;
            color: #fff;
            font-size: 1em;
        }
        button 
        {
            padding: 10px;
            background-color: #0f0;
            color: #000;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s, box-shadow 0.3s;
            font-weight: 600;
        }
        button:hover 
        {
            background-color: #0c0;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <h1>Request Asset</h1>
    <form action="../actions/request_asset_action.php" method="post">
        <label for="asset_id">Asset:</label>
        <select name="asset_id" id="asset_id" required>
            <?php
            require_once __DIR__ . '/../config/database.php';
            $assets = $pdo->query('SELECT asset_id, asset_name FROM asset WHERE status = "Available"');
            while ($asset = $assets->fetch()) {
                echo "<option value='{$asset['asset_id']}'>{$asset['asset_name']}</option>";
            }
            ?>
        </select>
        <label for="usage_purpose">Usage Purpose:</label>
        <textarea name="usage_purpose" id="usage_purpose" required></textarea>
        <label for="required_by_date">Required By Date:</label>
        <input type="date" name="required_by_date" id="required_by_date" required>
        <label for="justification">Justification:</label>
        <textarea name="justification" id="justification" required></textarea>
        <button type="submit">Request Asset</button>
    </form>
</body>
</html>
