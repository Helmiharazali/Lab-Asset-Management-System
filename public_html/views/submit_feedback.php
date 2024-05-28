<?php
require_once __DIR__ . '/../config/database.php';

// Check if the user is logged in and if they have the appropriate role
if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role_id'], [2, 3, 4])) { // Researchers (role_id = 2), Students (role_id = 3), and Technicians (role_id = 4)
    header('Location: ../public/index.php?page=login');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Submit Feedback</title>
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
        .success-message 
        {
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
    <?php include 'header.php'; ?>
    <h1>Submit Feedback</h1>
    <?php if (isset($_SESSION['feedback_submitted'])): ?>
        <p class="success-message">Feedback successfully submitted!</p>
        <?php unset($_SESSION['feedback_submitted']); ?>
    <?php endif; ?>
    <form action="../actions/submit_feedback_action.php" method="post">
        <label for="asset_id">Asset:</label>
        <select name="asset_id" id="asset_id" required>
            <?php
            $stmt = $pdo->query('SELECT * FROM asset');
            while ($asset = $stmt->fetch()) {
                echo "<option value='{$asset['asset_id']}'>{$asset['asset_name']}</option>";
            }
            ?>
        </select>
        <label for="rating">Rating:</label>
        <input type="number" name="rating" id="rating" min="1" max="5" required>
        <label for="comments">Comments:</label>
        <textarea name="comments" id="comments" required></textarea>
        <button type="submit">Submit Feedback</button>
    </form>
</body>
</html>
