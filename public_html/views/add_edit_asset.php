<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <?php include 'header.php'; ?>
    <title><?php echo isset($_GET['id']) ? 'Edit' : 'Add'; ?> Asset</title>
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
    </style>
</head>
<body>
    <h1><?php echo isset($_GET['id']) ? 'Edit' : 'Add'; ?> Asset</h1>
    <?php
    require_once __DIR__ . '/../config/database.php';
    $asset = [
        'asset_name' => '',
        'type_id' => '',
        'description' => '',
        'location' => '',
        'status' => 'Available',
        'purchase_date' => '',
        'warranty_expiry_date' => '',
        'acquisition_cost' => '',
        'depreciation_rate' => '',
        'current_user_id' => '',
        'department_id' => '',
        'supplier_id' => '',
        'asset_image' => ''
    ];
    if (isset($_GET['id'])) {
        $stmt = $pdo->prepare('SELECT * FROM asset WHERE asset_id = ?');
        $stmt->execute([$_GET['id']]);
        $asset = $stmt->fetch();
    }
    ?>
    <form action="../actions/save_asset_action.php" method="post">
        <input type="hidden" name="asset_id" value="<?php echo $_GET['id'] ?? ''; ?>">
        <label for="asset_name">Asset Name:</label>
        <input type="text" name="asset_name" id="asset_name" value="<?php echo htmlspecialchars($asset['asset_name']); ?>" required>
        
        <label for="type_id">Type:</label>
        <select name="type_id" id="type_id" required>
            <?php
            $types = $pdo->query('SELECT * FROM assettype');
            while ($type = $types->fetch()) {
                $selected = $type['type_id'] == $asset['type_id'] ? 'selected' : '';
                echo "<option value='{$type['type_id']}' $selected>{$type['type_name']}</option>";
            }
            ?>
        </select>
        
        <label for="description">Description:</label>
        <textarea name="description" id="description" required><?php echo htmlspecialchars($asset['description']); ?></textarea>
        
        <label for="location">Location:</label>
        <input type="text" name="location" id="location" value="<?php echo htmlspecialchars($asset['location']); ?>" required>
        
        <label for="status">Status:</label>
        <select name="status" id="status" required>
            <option value="Available" <?php echo $asset['status'] == 'Available' ? 'selected' : ''; ?>>Available</option>
            <option value="In Use" <?php echo $asset['status'] == 'In Use' ? 'selected' : ''; ?>>In Use</option>
            <option value="Under Maintenance" <?php echo $asset['status'] == 'Under Maintenance' ? 'selected' : ''; ?>>Under Maintenance</option>
            <option value="Disposed" <?php echo $asset['status'] == 'Disposed' ? 'selected' : ''; ?>>Disposed</option>
        </select>
        
        <label for="purchase_date">Purchase Date:</label>
        <input type="date" name="purchase_date" id="purchase_date" value="<?php echo $asset['purchase_date']; ?>" required>
        
        <label for="warranty_expiry_date">Warranty Expiry Date:</label>
        <input type="date" name="warranty_expiry_date" id="warranty_expiry_date" value="<?php echo $asset['warranty_expiry_date']; ?>" required>
        
        <label for="acquisition_cost">Acquisition Cost:</label>
        <input type="number" step="0.01" name="acquisition_cost" id="acquisition_cost" value="<?php echo $asset['acquisition_cost']; ?>" required>
        
        <label for="depreciation_rate">Depreciation Rate:</label>
        <input type="number" step="0.01" name="depreciation_rate" id="depreciation_rate" value="<?php echo $asset['depreciation_rate']; ?>" required>
        
        <label for="current_user_id">Current User:</label>
        <select name="current_user_id" id="current_user_id">
            <option value="">None</option>
            <?php
            $users = $pdo->query('SELECT * FROM user');
            while ($user = $users->fetch()) {
                $selected = $user['user_id'] == $asset['current_user_id'] ? 'selected' : '';
                echo "<option value='{$user['user_id']}' $selected>{$user['username']}</option>";
            }
            ?>
        </select>
        
        <label for="department_id">Department:</label>
        <select name="department_id" id="department_id" required>
            <?php
            $departments = $pdo->query('SELECT * FROM department');
            while ($department = $departments->fetch()) {
                $selected = $department['department_id'] == $asset['department_id'] ? 'selected' : '';
                echo "<option value='{$department['department_id']}' $selected>{$department['department_name']}</option>";
            }
            ?>
        </select>
        
        <label for="supplier_id">Supplier:</label>
        <select name="supplier_id" id="supplier_id" required>
            <?php
            $suppliers = $pdo->query('SELECT * FROM supplier');
            while ($supplier = $suppliers->fetch()) {
                $selected = $supplier['supplier_id'] == $asset['supplier_id'] ? 'selected' : '';
                echo "<option value='{$supplier['supplier_id']}' $selected>{$supplier['supplier_name']}</option>";
            }
            ?>
        </select>

        <label for="asset_image">Asset Image URL:</label>
        <input type="text" name="asset_image" id="asset_image" value="<?php echo htmlspecialchars($asset['asset_image']); ?>">
        
        <button type="submit"><?php echo isset($_GET['id']) ? 'Update' : 'Add'; ?> Asset</button>
    </form>
    <a href="index.php?page=assets">Back to Asset List</a>
</body>
</html>
