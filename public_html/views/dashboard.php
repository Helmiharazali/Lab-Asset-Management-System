<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <?php include 'header.php'; ?>
    <title>Dashboard</title>
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
        .dashboard-cards 
        {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            gap: 20px;
            width: 100%;
            max-width: 1000px;
        }
        .dashboard-cards .card 
        {
            background-color: #222;
            border-radius: 8px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.9);
            padding: 20px;
            text-align: center;
            flex: 1 1 200px;
            transition: transform 0.3s, box-shadow 0.3s;
            color: #fff;
        }
        .dashboard-cards .card:hover 
        {
            transform: translateY(-5px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }
        .dashboard-cards .card h2 
        {
            font-size: 1.5em;
            margin-bottom: 10px;
            color: #0f0;
        }
        .dashboard-cards .card p 
        {
            font-size: 2em;
            margin: 0;
            color: #fff;
        }
        .recent-activities 
        {
            margin-bottom: 20px;
            width: 100%;
            max-width: 800px;
        }
        .recent-activities h2 
        {
            text-align: center;
            margin-bottom: 20px;
            color: #0f0;
        }
        .recent-activities ul 
        {
            list-style-type: none;
            padding: 0;
        }
        .recent-activities li 
        {
            background-color: #333;
            margin: 10px 0;
            padding: 15px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .recent-activities li:hover 
        {
            transform: translateY(-3px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }
        .quick-actions 
        {
            text-align: center;
            margin-bottom: 20px;
        }
        .quick-actions button 
        {
            margin: 10px;
            padding: 10px 20px;
            background-color: #0f0;
            color: #000;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s, box-shadow 0.3s;
            font-weight: 600;
        }
        .quick-actions button:hover 
        {
            background-color: #0c0;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .links 
        {
            margin-top: 20px;
        }
        .links a 
        {
            color: #0f0;
            text-decoration: none;
            margin: 0 10px;
            transition: color 0.3s;
        }
        .links a:hover 
        {
            color: #fff;
        }
        @media (max-width: 900px) 
        {
            .dashboard-cards 
            {
                flex-direction: column;
                align-items: center;
            }
        }
    </style>
</head>
<body>
    <h1>Dashboard</h1>
    <?php
    require_once __DIR__ . '/../config/database.php';

    // Fetch key metrics
    $totalAssets = $pdo->query('SELECT COUNT(*) FROM asset')->fetchColumn();
    $assetsInUse = $pdo->query('SELECT COUNT(*) FROM asset WHERE status = "In Use"')->fetchColumn();
    $pendingRequests = $pdo->query('SELECT COUNT(*) FROM request WHERE approval_status = "Pending"')->fetchColumn();
    $maintenanceSchedules = $pdo->query('SELECT COUNT(*) FROM maintenance')->fetchColumn();

    // Fetch recent activities
    $recentActivities = $pdo->query('SELECT message, notification_date FROM notification ORDER BY notification_date DESC LIMIT 5')->fetchAll();
    ?>

    <!-- Statistics and Key Metrics -->
    <div class="dashboard-cards">
        <div class="card">
            <h2>Total Assets</h2>
            <p><?php echo $totalAssets; ?></p>
        </div>
        <div class="card">
            <h2>Assets in Use</h2>
            <p><?php echo $assetsInUse; ?></p>
        </div>
        <div class="card">
            <h2>Maintenance Schedules</h2>
            <p><?php echo $maintenanceSchedules; ?></p>
        </div>
        <div class="card">
            <h2>Pending Requests</h2>
            <p><?php echo $pendingRequests; ?></p>
        </div>
    </div>

    <br>

    <!-- Recent Activities -->
    <div class="recent-activities">
        <h2>Recent Activities</h2>
        <ul>
            <?php foreach ($recentActivities as $activity) : ?>
                <li><?php echo $activity['message'] . ' - ' . $activity['notification_date']; ?></li>
            <?php endforeach; ?>
        </ul>
    </div>

    <!-- Quick Actions -->
    <div class="quick-actions">
        <button onclick="location.href='index.php?page=add_edit_asset'">Add New Asset</button>
        <button onclick="location.href='index.php?page=request_asset'">Request Asset</button>
        <button onclick="location.href='index.php?page=schedule_maintenance'">Schedule Maintenance</button>
    </div>

    <!-- Links -->
    <div class="links">
        <a href="index.php?page=role_management">Manage Roles</a>
        <a href="../actions/logout_action.php">Logout</a>
    </div>
</body>
</html>
