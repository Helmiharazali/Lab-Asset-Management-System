<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Maintenance Task</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600&display=swap');
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
    <h1>Update Maintenance Task</h1>
    <?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    require_once __DIR__ . '/../config/database.php';

    // Check if user is logged in and is a technician
    if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 4) {
        header('Location: ../public/index.php?page=login');
        exit();
    }

    if (!isset($_GET['id'])) {
        echo "<p>Error: No maintenance task ID provided.</p>";
        exit();
    }

    $maintenance_id = $_GET['id'];
    $stmt = $pdo->prepare('SELECT * FROM maintenance WHERE maintenance_id = ?');
    $stmt->execute([$maintenance_id]);
    $maintenance = $stmt->fetch();

    if (!$maintenance) {
        echo "<p>Error: Maintenance task not found.</p>";
        exit();
    }
    ?>
    <form action="../actions/update_maintenance_action.php" method="post">
        <input type="hidden" name="maintenance_id" value="<?php echo htmlspecialchars($maintenance_id); ?>">
        
        <label for="asset_id">Asset:</label>
        <select name="asset_id" id="asset_id" required>
            <?php
            $assets = $pdo->query('SELECT asset_id, asset_name FROM asset WHERE status != "Disposed"');
            while ($asset = $assets->fetch()) {
                $selected = $asset['asset_id'] == $maintenance['asset_id'] ? 'selected' : '';
                echo "<option value='{$asset['asset_id']}' $selected>{$asset['asset_name']}</option>";
            }
            ?>
        </select>

        <label for="maintenance_type">Maintenance Type:</label>
        <select name="maintenance_type" id="maintenance_type" required>
            <option value="Scheduled" <?php echo $maintenance['maintenance_type'] == 'Scheduled' ? 'selected' : ''; ?>>Scheduled</option>
            <option value="Unscheduled" <?php echo $maintenance['maintenance_type'] == 'Unscheduled' ? 'selected' : ''; ?>>Unscheduled</option>
        </select>

        <label for="details">Details:</label>
        <textarea name="details" id="details" required><?php echo htmlspecialchars($maintenance['details']); ?></textarea>

        <label for="next_maintenance_date">Next Maintenance Date:</label>
        <input type="date" name="next_maintenance_date" id="next_maintenance_date" value="<?php echo htmlspecialchars($maintenance['next_maintenance_date']); ?>">

        <label for="maintenance_cost">Maintenance Cost:</label>
        <input type="number" step="0.01" name="maintenance_cost" id="maintenance_cost" value="<?php echo htmlspecialchars($maintenance['maintenance_cost']); ?>">

        <label for="parts_replaced">Parts Replaced:</label>
        <textarea name="parts_replaced" id="parts_replaced"><?php echo htmlspecialchars($maintenance['parts_replaced']); ?></textarea>

        <button type="submit">Update Maintenance</button>
    </form>
</body>
</html>