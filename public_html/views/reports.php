<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <?php include 'header.php'; ?>
    <title>Reports</title>
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
        h1, h2
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
            margin-bottom: 20px;
        }
        label 
        {
            display: block;
            margin: 10px 0 5px;
            color: #0f0;
        }
        input, select 
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
        table 
        {
            width: 100%;
            max-width: 1000px;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td 
        {
            border: 1px solid #333;
        }
        th, td 
        {
            padding: 15px;
            text-align: left;
        }
        th 
        {
            background-color: #0f0;
            color: #000;
        }
        tr:nth-child(even) 
        {
            background-color: #222;
        }
        tr:nth-child(odd) 
        {
            background-color: #333;
        }
        tr:hover 
        {
            background-color: #444;
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
    <h1>Reports</h1>
    <form action="index.php?page=reports" method="post">
        <label for="report_type">Select Report Type:</label>
        <select name="report_type" id="report_type" required>
            <option value="Utilization">Utilization</option>
            <option value="Maintenance">Maintenance</option>
            <option value="Compliance">Compliance</option>
        </select>
        
        <label for="asset_type">Select Asset Type (optional):</label>
        <select name="asset_type" id="asset_type">
            <option value="">All</option>
            <?php
            require_once __DIR__ . '/../config/database.php';
            $stmt = $pdo->query('SELECT * FROM assettype');
            while ($row = $stmt->fetch()) {
                echo "<option value='{$row['type_id']}'>{$row['type_name']}</option>";
            }
            ?>
        </select>
        
        <label for="start_date">Start Date (optional):</label>
        <input type="date" name="start_date" id="start_date">
        
        <label for="end_date">End Date (optional):</label>
        <input type="date" name="end_date" id="end_date">
        
        <button type="submit">Generate Report</button>
    </form>
    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['report_type'])) {
        $report_type = $_POST['report_type'];
        $asset_type = $_POST['asset_type'];
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];

        $where_clauses = [];
        if ($asset_type) {
            $where_clauses[] = 'asset.type_id = ' . $pdo->quote($asset_type);
        }
        if ($start_date) {
            $where_clauses[] = 'request.request_date >= ' . $pdo->quote($start_date);
        }
        if ($end_date) {
            $where_clauses[] = 'request.request_date <= ' . $pdo->quote($end_date);
        }
        $where_sql = '';
        if ($where_clauses) {
            $where_sql = 'WHERE ' . implode(' AND ', $where_clauses);
        }

        $report_data = [];
        switch ($report_type) {
            case 'Utilization':
                $stmt = $pdo->query('SELECT asset.asset_name, COUNT(request.request_id) AS usage_count FROM request JOIN asset ON request.asset_id = asset.asset_id ' . $where_sql . ' AND request.approval_status = "Approved" GROUP BY asset.asset_id');
                $report_data = $stmt->fetchAll();
                echo "<h2>Utilization Report</h2>";
                echo "<table><tr><th>Asset Name</th><th>Usage Count</th></tr>";
                foreach ($report_data as $row) {
                    echo "<tr><td>{$row['asset_name']}</td><td>{$row['usage_count']}</td></tr>";
                }
                echo "</table>";
                break;
            case 'Maintenance':
                $stmt = $pdo->query('SELECT asset.asset_name, COUNT(maintenance.maintenance_id) AS maintenance_count, SUM(maintenance.maintenance_cost) AS total_cost FROM maintenance JOIN asset ON maintenance.asset_id = asset.asset_id ' . $where_sql . ' GROUP BY asset.asset_id');
                $report_data = $stmt->fetchAll();
                echo "<h2>Maintenance Report</h2>";
                echo "<table><tr><th>Asset Name</th><th>Maintenance Count</th><th>Total Cost</th></tr>";
                foreach ($report_data as $row) {
                    echo "<tr><td>{$row['asset_name']}</td><td>{$row['maintenance_count']}</td><td>{$row['total_cost']}</td></tr>";
                }
                echo "</table>";
                break;
            case 'Compliance':
                $stmt = $pdo->query('SELECT asset.asset_name, asset.warranty_expiry_date FROM asset WHERE asset.warranty_expiry_date < CURDATE() ' . $where_sql);
                $report_data = $stmt->fetchAll();
                echo "<h2>Compliance Report</h2>";
                echo "<table><tr><th>Asset Name</th><th>Warranty Expiry Date</th></tr>";
                foreach ($report_data as $row) {
                    echo "<tr><td>{$row['asset_name']}</td><td>{$row['warranty_expiry_date']}</td></tr>";
                }
                echo "</table>";
                break;
        }
    }
    ?>
    <a href="index.php?page=dashboard">Back to Dashboard</a>
</body>
</html>
