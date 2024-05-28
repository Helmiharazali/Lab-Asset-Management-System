<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Asset Details</title>
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
        img 
        {
            max-width: 80%;  /* Adjusts the maximum width */
            max-height: 400px;  /* Adjusts the maximum height */
            height: auto;  /* Maintains aspect ratio */
            width: auto;  /* Maintains aspect ratio */
            border-radius: 8px;
            margin-bottom: 20px;
            object-fit: contain;  /* Ensures the image fits within the dimensions */
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>
    <h1>Asset Details</h1>
    <?php
    require '../config/database.php';
    if (isset($_GET['id'])) {
        $stmt = $pdo->prepare('SELECT Asset.*, AssetType.type_name, User.username, Department.department_name, Supplier.supplier_name FROM Asset JOIN AssetType ON Asset.type_id = AssetType.type_id LEFT JOIN User ON Asset.current_user_id = User.user_id LEFT JOIN Department ON Asset.department_id = Department.department_id LEFT JOIN Supplier ON Asset.supplier_id = Supplier.supplier_id WHERE asset_id = ?');
        $stmt->execute([$_GET['id']]);
        $asset = $stmt->fetch();
        if ($asset) {
            if (!empty($asset['asset_image'])) {
                echo "<img src='{$asset['asset_image']}' alt='Asset Image'>";
            }
            echo "<p><strong>Asset Name:</strong> {$asset['asset_name']}</p>";
            echo "<p><strong>Type:</strong> {$asset['type_name']}</p>";
            echo "<p><strong>Description:</strong> {$asset['description']}</p>";
            echo "<p><strong>Location:</strong> {$asset['location']}</p>";
            echo "<p><strong>Status:</strong> {$asset['status']}</p>";
            echo "<p><strong>Purchase Date:</strong> {$asset['purchase_date']}</p>";
            echo "<p><strong>Warranty Expiry Date:</strong> {$asset['warranty_expiry_date']}</p>";
            echo "<p><strong>Acquisition Cost:</strong> {$asset['acquisition_cost']}</p>";
            echo "<p><strong>Depreciation Rate:</strong> {$asset['depreciation_rate']}</p>";
            echo "<p><strong>Current User:</strong> {$asset['username']}</p>";
            echo "<p><strong>Department:</strong> {$asset['department_name']}</p>";
            echo "<p><strong>Supplier:</strong> {$asset['supplier_name']}</p>";
        } else {
            echo "<p>Asset not found.</p>";
        }
    } else {
        echo "<p>No asset selected.</p>";
    }
    ?>
    <a href="index.php?page=assets">Back to Asset List</a>
</body>
</html>
