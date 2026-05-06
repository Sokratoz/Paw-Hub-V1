<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Database Status | Paw Hubs</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body { background: #f5faf8; font-family: 'Outfit', sans-serif; padding: 50px; }
        .card { background: #fff; padding: 30px; border-radius: 20px; box-shadow: 0 10px 30px rgba(107,181,168,0.12); max-width: 500px; margin: auto; }
        h2 { color: #6BB5A8; margin-top: 0; }
        .status-badge { display: inline-block; padding: 5px 12px; border-radius: 20px; background: #C8E4D6; color: #4f9186; font-weight: 600; font-size: 13px; margin-bottom: 20px; }
        .table-list { list-style: none; padding: 0; }
        .table-item { padding: 12px; border-bottom: 1px solid #d8ebe5; display: flex; align-items: center; gap: 10px; color: #2f4f4f; }
        .table-item i { color: #6BB5A8; }
    </style>
</head>
<body>

<div class="card">
    <h2><i class="fas fa-database"></i> Database Status</h2>
    <div class="status-badge"><i class="fas fa-check-circle"></i> Connected to 'pawhub'</div>
    
    <p style="font-weight: 600; margin-bottom: 10px;">Existing Tables:</p>
    <ul class="table-list">
        <?php foreach($tables as $table): ?>
            <li class="table-item">
                <i class="fas fa-table"></i> <?= htmlspecialchars($table) ?>
            </li>
        <?php endforeach; ?>
    </ul>
    
    <div style="margin-top: 20px; font-size: 13px; color: #718096;">
        Logic location: <code>app/core/Database.php</code>
    </div>
</div>

<?php require_once '../app/views/partials/theme_toggle.php'; ?>
</body>
</html>
