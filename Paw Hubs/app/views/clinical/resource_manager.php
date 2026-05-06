<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clinical Resource Manager | Paw Hubs</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root {
            --teal: #6BB5A8;
            --green: #9BC870;
            --olive: #CAD7A5;
            --mint: #C8E4D6;
            --sky: #94CDD3;
            --ink: #2f4f4f;
            --muted: #718096;
            --line: #d8ebe5;
            --soft: #f5faf8;
            --panel: #ffffff;
            --danger: #e53e3e;
        }

        * { box-sizing: border-box; }
        body {
            margin: 0;
            min-height: 100vh;
            padding: 34px;
            font-family: 'Outfit', sans-serif;
            color: var(--ink);
            background: linear-gradient(135deg, var(--mint), #ffffff 45%, var(--sky));
        }

        .app-frame {
            max-width: 1480px;
            min-height: calc(100vh - 68px);
            margin: 0 auto;
            display: grid;
            grid-template-columns: 270px 1fr;
            background: rgba(255, 255, 255, 0.92);
            border: 1px solid var(--line);
            border-radius: 28px;
            overflow: hidden;
            box-shadow: 0 30px 80px rgba(47, 79, 79, 0.14);
        }

        .sidebar {
            background: #ffffff;
            border-right: 1px solid var(--line);
            padding: 28px 22px;
            display: flex;
            flex-direction: column;
            gap: 28px;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            color: var(--teal);
            font-size: 23px;
            font-weight: 800;
        }

        .brand i {
            width: 44px;
            height: 44px;
            border-radius: 14px;
            display: grid;
            place-items: center;
            background: var(--mint);
        }

        .menu-label {
            color: var(--muted);
            font-size: 12px;
            font-weight: 700;
            margin: 0 0 10px;
        }

        .menu {
            display: grid;
            gap: 8px;
        }

        .menu a {
            min-height: 44px;
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0 14px;
            border-radius: 12px;
            color: var(--ink);
            text-decoration: none;
            font-weight: 700;
            font-size: 14px;
        }

        .menu a.active,
        .menu a:hover {
            background: var(--mint);
            color: #4f9186;
        }

        .menu a i {
            width: 20px;
            text-align: center;
            color: var(--teal);
        }

        .sidebar-footer {
            margin-top: auto;
            display: grid;
            gap: 10px;
        }
        .content { padding: 26px; background: #f8fbfa; }

        .topbar,
        .panel,
        .stat-card {
            background: var(--panel);
            border: 1px solid var(--line);
            border-radius: 18px;
            box-shadow: 0 18px 38px rgba(107, 181, 168, 0.08);
        }

        .topbar {
            min-height: 70px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            padding: 14px 18px;
            margin-bottom: 22px;
        }

        .search {
            flex: 1;
            max-width: 560px;
            height: 46px;
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0 16px;
            border: 1px solid var(--line);
            border-radius: 14px;
            background: var(--soft);
            color: var(--muted);
        }

        .search input {
            width: 100%;
            border: 0;
            outline: 0;
            background: transparent;
            font: inherit;
        }

        .action-btn {
            min-height: 44px;
            padding: 0 16px;
            border: 1px solid var(--line);
            border-radius: 13px;
            background: #ffffff;
            color: var(--ink);
            font-weight: 800;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            text-decoration: none;
            cursor: pointer;
        }

        .action-btn.primary {
            background: var(--teal);
            color: #fff;
            border-color: transparent;
        }

        .page-head {
            display: flex;
            justify-content: space-between;
            gap: 18px;
            align-items: flex-end;
            margin: 4px 0 20px;
        }

        .page-head h1 {
            margin: 0;
            font-size: 32px;
            letter-spacing: 0;
        }

        .page-head p {
            margin: 7px 0 0;
            color: var(--muted);
            max-width: 720px;
            line-height: 1.55;
        }

        .role-pill,
        .badge {
            border-radius: 999px;
            padding: 8px 12px;
            background: var(--mint);
            color: #4f9186;
            font-size: 12px;
            font-weight: 800;
            white-space: nowrap;
            text-transform: capitalize;
        }

        .stat-card,
        .panel {
            background: var(--panel);
            border: 1px solid var(--line);
            border-radius: 18px;
            box-shadow: 0 18px 38px rgba(107, 181, 168, 0.08);
        }

        .stat-card {
            padding: 18px;
            min-height: 130px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .stat-icon {
            width: 42px;
            height: 42px;
            border-radius: 13px;
            display: grid;
            place-items: center;
            font-size: 18px;
        }

        .bg-teal { background: var(--mint); color: #4f9186; }
        .bg-green { background: var(--green); color: #ffffff; }
        .bg-olive { background: var(--olive); color: #4f6f35; }
        .bg-sky { background: var(--sky); color: #ffffff; }

        .stat-card span {
            color: var(--muted);
            font-size: 13px;
            font-weight: 700;
        }

        .stat-card strong {
            display: block;
            margin-top: 5px;
            font-size: 29px;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(5, minmax(150px, 1fr));
            gap: 16px;
            margin-bottom: 18px;
        }

        .dashboard-grid {
            display: grid;
            grid-template-columns: 1.2fr 0.85fr;
            gap: 18px;
        }

        .panel {
            padding: 20px;
            min-width: 0;
        }

        .panel-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            margin-bottom: 16px;
        }

        .panel h2 {
            margin: 0;
            font-size: 20px;
        }

        .panel small {
            color: var(--muted);
            font-weight: 700;
        }

        .chart {
            height: 240px;
            display: grid;
            grid-template-columns: repeat(8, 1fr);
            align-items: end;
            gap: 14px;
            padding: 18px 6px 0;
            border-top: 1px solid var(--line);
        }

        .bar {
            border-radius: 12px 12px 4px 4px;
            background: linear-gradient(180deg, var(--teal), var(--sky));
            min-height: 28px;
            position: relative;
        }

        .bar:nth-child(2n) { background: linear-gradient(180deg, var(--green), var(--olive)); }
        .bar:nth-child(3n) { background: linear-gradient(180deg, var(--sky), var(--mint)); }

        .bar span {
            position: absolute;
            bottom: -25px;
            left: 50%;
            transform: translateX(-50%);
            color: var(--muted);
            font-size: 12px;
        }

        .list {
            display: grid;
            gap: 11px;
        }

        .item {
            border: 1px solid var(--line);
            border-radius: 14px;
            padding: 13px;
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 10px;
            align-items: center;
            background: #ffffff;
        }

        .item strong {
            display: block;
            margin-bottom: 4px;
        }

        .item span {
            display: block;
            color: var(--muted);
            font-size: 13px;
            line-height: 1.45;
        }

        .badge.critical,
        .badge.cancelled,
        .badge.rejected { background: #fff5f5; color: #e53e3e; }
        .badge.completed,
        .badge.normal,
        .badge.accepted { background: var(--green); color: #fff; }
        .badge.pending,
        .badge.scheduled { background: var(--olive); color: #4f6f35; }

        .sections {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
            margin-top: 18px;
        }

        .audit-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        .audit-table th,
        .audit-table td {
            padding: 13px 10px;
            border-bottom: 1px solid var(--line);
            text-align: left;
            vertical-align: top;
        }

        .audit-table th {
            color: var(--muted);
            font-size: 12px;
            text-transform: uppercase;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 14px;
        }

        .input-group {
            display: grid;
            gap: 8px;
        }

        .input-group.full { grid-column: 1 / -1; }
        label {
            color: var(--muted);
            font-size: 13px;
            font-weight: 700;
        }

        .form-control {
            width: 100%;
            border: 1px solid var(--line);
            border-radius: 14px;
            padding: 12px 14px;
            background: #ffffff;
            font: inherit;
            color: var(--ink);
        }

        textarea.form-control {
            min-height: 96px;
            resize: vertical;
        }

        .notice {
            border-radius: 16px;
            padding: 15px 17px;
            margin-bottom: 16px;
            line-height: 1.6;
            font-weight: 700;
        }

        .notice.success {
            background: #e6fffa;
            color: #155e75;
            border: 1px solid #b2f5ea;
        }

        .notice.error {
            background: #fff5f5;
            color: #742a2a;
            border: 1px solid #fed7d7;
        }

        .notice ul {
            margin: 8px 0 0;
            padding-left: 20px;
        }

        .table-scroll { overflow-x: auto; }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        th,
        td {
            padding: 13px 10px;
            border-bottom: 1px solid var(--line);
            text-align: left;
            vertical-align: top;
        }

        th {
            color: var(--muted);
            font-size: 12px;
            text-transform: uppercase;
        }

        td small {
            color: var(--muted);
            font-weight: 700;
        }

        .badge.scheduled { background: var(--olive); color: #4f6f35; }
        .badge.completed { background: var(--green); color: #fff; }
        .badge.cancelled { background: #fff5f5; color: var(--danger); }

        .empty {
            min-height: 130px;
            display: grid;
            place-items: center;
            border: 1px dashed var(--line);
            border-radius: 14px;
            color: var(--muted);
            background: var(--soft);
            text-align: center;
            padding: 16px;
        }

        .bars {
            display: grid;
            gap: 14px;
        }

        .bar-row {
            display: grid;
            grid-template-columns: 1fr 2fr auto;
            align-items: center;
            gap: 14px;
        }

        .bar-track {
            height: 24px;
            background: var(--soft);
            border-radius: 12px;
            overflow: hidden;
        }

        .bar-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--teal), var(--sky));
            border-radius: 12px;
        }

        .form-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            align-items: center;
            margin-top: 10px;
        }

        @media (max-width: 1150px) {
            body { padding: 16px; }
            .app-frame { grid-template-columns: 1fr; }
            .sidebar { display: none; }
            .stats { grid-template-columns: repeat(2, minmax(150px, 1fr)); }
            .dashboard-grid,
            .sections { grid-template-columns: 1fr; }
        }

        @media (max-width: 640px) {
            .content { padding: 16px; }
            .topbar { grid-template-columns: 1fr; height: auto; padding: 14px; }
            .top-actions { flex-wrap: wrap; }
            .stats { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
<?php
$role = $role ?? 'admin';
$stats = $stats ?? [];
$procedures = $procedures ?? [];
$labReports = $labReports ?? [];
$referrals = $referrals ?? [];
$auditLogs = $auditLogs ?? [];
$pets = $pets ?? [];
$operatingRooms = $operatingRooms ?? [];
$equipment = $equipment ?? [];
$specialists = $specialists ?? [];
$bookings = $bookings ?? [];
$scheduleMessage = $scheduleMessage ?? null;
$scheduleErrors = $scheduleErrors ?? [];
$adminWorkspace = $adminWorkspace ?? [];
?>
<div class="app-frame">
    <aside class="sidebar">
        <div class="brand">
            <i class="fas fa-stethoscope"></i>
            <div>
                <span>Resource Manager</span>
                <small>Clinical Tools</small>
            </div>
        </div>

        <nav>
            <p class="menu-label">Navigation</p>
            <div class="menu">
                <a href="index.php?url=clinical/index"><i class="fas fa-chart-pie"></i> Overview</a>
                <a class="active" href="index.php?url=clinical/resourceManager"><i class="fas fa-cogs"></i> Resource Manager</a>
                <a href="index.php?url=audit/index"><i class="fas fa-shield-halved"></i> Audit Logs</a>
            </div>
        </nav>

        <div class="sidebar-footer">
            <nav class="menu">
                <a href="#"><i class="fas fa-circle-question"></i> Help Center</a>
                <a href="index.php?url=auth/logout"><i class="fas fa-arrow-right-from-bracket"></i> Logout</a>
            </nav>
        </div>
    </aside>

    <main class="content">
        <div class="topbar">
            <label class="search">
                <i class="fas fa-search"></i>
                <input type="search" placeholder="Search resources, bookings, reports">
            </label>
            <div class="top-actions">
                <button class="action-btn primary" type="button"><i class="fas fa-plus"></i> Add Resource</button>
                <button class="action-btn" type="button"><i class="far fa-bell"></i></button>
                <button class="action-btn" type="button"><i class="fas fa-gear"></i></button>
            </div>
        </div>

        <header class="page-head">
            <div>
                <h1>Clinical Resource Manager</h1>
                <p>Reports, rooms, equipment, surgery approval, and referral security all in one place.</p>
            </div>
            <span class="role-pill">Admin access</span>
        </header>

        <section class="stats">
            <article class="stat-card">
                <div class="stat-icon bg-teal"><i class="fas fa-briefcase-medical"></i></div>
                <div>
                    <span>Medical Procedures</span>
                    <strong><?= (int) $stats['procedures'] ?></strong>
                </div>
            </article>
            <article class="stat-card">
                <div class="stat-icon bg-green"><i class="fas fa-vial-circle-check"></i></div>
                <div>
                    <span>Lab Reports</span>
                    <strong><?= (int) $stats['lab_reports'] ?></strong>
                </div>
            </article>
            <article class="stat-card">
                <div class="stat-icon bg-olive"><i class="fas fa-share-nodes"></i></div>
                <div>
                    <span>Referral Requests</span>
                    <strong><?= (int) $stats['referrals'] ?></strong>
                </div>
            </article>
            <article class="stat-card">
                <div class="stat-icon bg-sky"><i class="fas fa-triangle-exclamation"></i></div>
                <div>
                    <span>Critical Labs</span>
                    <strong><?= (int) $stats['critical_labs'] ?></strong>
                </div>
            </article>
            <article class="stat-card">
                <div class="stat-icon bg-teal"><i class="fas fa-shield-halved"></i></div>
                <div>
                    <span>Audit Events</span>
                    <strong><?= (int) $stats['audit_logs'] ?></strong>
                </div>
            </article>
        </section>

        <section class="dashboard-grid">
            <div class="panel">
                <div class="panel-head">
                    <div><h2>Clinical Activity</h2><small>Monthly workload snapshot</small></div>
                    <span class="badge">This year</span>
                </div>
                <div class="chart" aria-label="Clinical activity chart">
                    <?php foreach ([42, 68, 54, 82, 65, 91, 74, 88] as $index => $height): ?>
                        <div class="bar" style="height: <?= (int) $height ?>%;"><span><?= date('M', mktime(0, 0, 0, $index + 1, 1)) ?></span></div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="panel">
                <div class="panel-head">
                    <div><h2>Urgent Watchlist</h2><small>Critical reports and pending referrals</small></div>
                    <i class="fas fa-ellipsis"></i>
                </div>
                <div class="list">
                    <?php
                    $watchItems = array_slice(array_merge($labReports, $referrals), 0, 5);
                    ?>
                    <?php if (empty($watchItems)): ?>
                        <div class="empty">No urgent clinical items yet.</div>
                    <?php else: ?>
                        <?php foreach ($watchItems as $item): ?>
                            <div class="item">
                                <div>
                                    <strong><?= htmlspecialchars($item['test_name'] ?? $item['specialty'] ?? 'Clinical item') ?></strong>
                                    <span><?= htmlspecialchars($item['pet_name'] ?? 'Unknown pet') ?> • <?= htmlspecialchars($item['result_summary'] ?? $item['reason'] ?? 'No details') ?></span>
                                </div>
                                <span class="badge <?= htmlspecialchars(strtolower($item['status'] ?? 'pending')) ?>"><?= htmlspecialchars($item['status'] ?? 'pending') ?></span>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <section class="sections">
            <div class="panel">
                <div class="panel-head"><div><h2>Reports</h2><small>Monthly operations and usage analytics</small></div></div>
                <?php $reportRows = $adminWorkspace['reports']['monthly'] ?? []; ?>
                <?php if (empty($reportRows)): ?>
                    <div class="empty">No report data yet.</div>
                <?php else: ?>
                    <?php $maxReport = max(array_map(fn($row) => (int) ($row['total'] ?? 0), $reportRows)) ?: 1; ?>
                    <div class="bars">
                        <?php foreach ($reportRows as $row): ?>
                            <?php $total = (int) ($row['total'] ?? 0); ?>
                            <div class="bar-row">
                                <strong><?= htmlspecialchars($row['label'] ?? 'Month') ?></strong>
                                <div class="bar-track"><div class="bar-fill" style="width: <?= (int) round(($total / $maxReport) * 100) ?>%;"></div></div>
                                <span class="badge"><?= $total ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="panel">
                <div class="panel-head"><div><h2>Operating Rooms</h2><small>Status and room schedule source</small></div><span class="badge"><?= count($adminWorkspace['rooms'] ?? []) ?> rooms</span></div>
                <?php if (empty($adminWorkspace['rooms'])): ?>
                    <div class="empty">No operating rooms yet.</div>
                <?php else: ?>
                    <table class="audit-table">
                        <thead><tr><th>Room</th><th>Location</th><th>Status</th></tr></thead>
                        <tbody>
                        <?php foreach ($adminWorkspace['rooms'] as $room): ?>
                            <tr><td><?= htmlspecialchars($room['name']) ?></td><td><?= htmlspecialchars($room['location'] ?? '-') ?></td><td><span class="badge <?= htmlspecialchars(strtolower($room['status'] ?? 'available')) ?>"><?= htmlspecialchars($room['status'] ?? 'available') ?></span></td></tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>

            <div class="panel">
                <div class="panel-head"><div><h2>Equipment</h2><small>Availability and maintenance state</small></div><span class="badge"><?= count($adminWorkspace['equipment'] ?? []) ?> items</span></div>
                <?php if (empty($adminWorkspace['equipment'])): ?>
                    <div class="empty">No equipment yet.</div>
                <?php else: ?>
                    <table class="audit-table">
                        <thead><tr><th>Name</th><th>Type</th><th>Status</th></tr></thead>
                        <tbody>
                        <?php foreach ($adminWorkspace['equipment'] as $item): ?>
                            <tr><td><?= htmlspecialchars($item['name']) ?></td><td><?= htmlspecialchars($item['type'] ?? '-') ?></td><td><span class="badge <?= htmlspecialchars(strtolower($item['status'] ?? 'available')) ?>"><?= htmlspecialchars($item['status'] ?? 'available') ?></span></td></tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>

            <div class="panel full">
                <div class="panel-head"><div><h2>Surgery Approval Center</h2><small>Latest requests with approve/reject status context</small></div><span class="badge"><?= count($adminWorkspace['bookings'] ?? []) ?> requests</span></div>
                <?php if (!empty($scheduleMessage)): ?>
                    <div class="notice success"><?= htmlspecialchars($scheduleMessage) ?></div>
                <?php endif; ?>
                <?php if (!empty($scheduleErrors)): ?>
                    <div class="notice error">
                        <strong>Scheduling errors:</strong>
                        <ul>
                            <?php foreach ($scheduleErrors as $error): ?>
                                <li><?= htmlspecialchars($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form method="post">
                    <input type="hidden" name="action" value="schedule_procedure">
                    <div class="form-grid">
                        <div class="input-group full">
                            <label for="pet_id">Patient record</label>
                            <select id="pet_id" name="pet_id" class="form-control">
                                <option value="">Choose pet</option>
                                <?php foreach ($pets as $pet): ?>
                                    <option value="<?= (int) $pet['id'] ?>" <?= (isset($_POST['pet_id']) && (int) $_POST['pet_id'] === (int) $pet['id']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($pet['name']) ?> (<?= htmlspecialchars($pet['species']) ?>) - <?= htmlspecialchars($pet['owner_name'] ?? 'Owner') ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="input-group">
                            <label for="procedure_name">Procedure name</label>
                            <input id="procedure_name" name="procedure_name" class="form-control" type="text" value="<?= htmlspecialchars($_POST['procedure_name'] ?? '') ?>" placeholder="Spay surgery">
                        </div>

                        <div class="input-group">
                            <label for="procedure_type">Procedure type</label>
                            <input id="procedure_type" name="procedure_type" class="form-control" type="text" value="<?= htmlspecialchars($_POST['procedure_type'] ?? '') ?>" placeholder="General surgery">
                        </div>

                        <div class="input-group">
                            <label for="procedure_date">Date</label>
                            <input id="procedure_date" name="procedure_date" class="form-control" type="date" value="<?= htmlspecialchars($_POST['procedure_date'] ?? '') ?>">
                        </div>

                        <div class="input-group">
                            <label for="room_id">Operating room</label>
                            <select id="room_id" name="room_id" class="form-control">
                                <option value="">Choose room</option>
                                <?php foreach ($operatingRooms as $room): ?>
                                    <option value="<?= (int) $room['id'] ?>" <?= (isset($_POST['room_id']) && (int) $_POST['room_id'] === (int) $room['id']) ? 'selected' : '' ?> >
                                        <?= htmlspecialchars($room['name']) ?> - <?= htmlspecialchars($room['location'] ?? 'Location') ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="input-group">
                            <label for="equipment_id">Surgical equipment</label>
                            <select id="equipment_id" name="equipment_id" class="form-control">
                                <option value="">Choose equipment</option>
                                <?php foreach ($equipment as $equip): ?>
                                    <option value="<?= (int) $equip['id'] ?>" <?= (isset($_POST['equipment_id']) && (int) $_POST['equipment_id'] === (int) $equip['id']) ? 'selected' : '' ?> >
                                        <?= htmlspecialchars($equip['name']) ?> (<?= htmlspecialchars($equip['type'] ?? 'Equipment') ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="input-group">
                            <label for="specialist_id">Specialist staff</label>
                            <select id="specialist_id" name="specialist_id" class="form-control">
                                <option value="">Choose specialist</option>
                                <?php foreach ($specialists as $specialist): ?>
                                    <option value="<?= (int) $specialist['id'] ?>" <?= (isset($_POST['specialist_id']) && (int) $_POST['specialist_id'] === (int) $specialist['id']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($specialist['username']) ?> (<?= htmlspecialchars($specialist['specialization'] ?: 'Specialist') ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="input-group">
                            <label for="start_time">Start time</label>
                            <input id="start_time" name="start_time" class="form-control" type="time" value="<?= htmlspecialchars($_POST['start_time'] ?? '') ?>">
                        </div>

                        <div class="input-group">
                            <label for="end_time">End time</label>
                            <input id="end_time" name="end_time" class="form-control" type="time" value="<?= htmlspecialchars($_POST['end_time'] ?? '') ?>">
                        </div>

                        <div class="input-group full">
                            <label for="notes">Notes</label>
                            <textarea id="notes" name="notes" class="form-control" placeholder="Additional procedure details..."><?= htmlspecialchars($_POST['notes'] ?? '') ?></textarea>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button class="action-btn primary" type="submit"><i class="fas fa-calendar-check"></i> Schedule Procedure</button>
                        <span class="badge"><?= count($bookings) ?> current bookings</span>
                    </div>
                </form>

                <?php if (empty($adminWorkspace['bookings'])): ?>
                    <div class="empty">No surgery requests yet.</div>
                <?php else: ?>
                    <div class="table-scroll" style="margin-top: 20px;">
                        <table class="audit-table">
                            <thead>
                                <tr>
                                    <th>Procedure</th>
                                    <th>Room / Equipment</th>
                                    <th>Specialist</th>
                                    <th>Schedule</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($adminWorkspace['bookings'] as $booking): ?>
                                    <tr>
                                        <td><strong><?= htmlspecialchars($booking['procedure_name'] ?? 'Procedure') ?></strong><br><small><?= htmlspecialchars($booking['pet_name'] ?? 'Unknown pet') ?></small></td>
                                        <td><?= htmlspecialchars($booking['room_name'] ?? 'No room') ?><br><small><?= htmlspecialchars($booking['equipment_name'] ?? 'No equipment') ?></small></td>
                                        <td><?= htmlspecialchars($booking['specialist_name'] ?? 'Unassigned') ?></td>
                                        <td><?= htmlspecialchars(date('Y-m-d H:i', strtotime($booking['start_time'] ?? 'now'))) ?><br><small>to <?= htmlspecialchars(date('H:i', strtotime($booking['end_time'] ?? 'now'))) ?></small></td>
                                        <td><span class="badge <?= htmlspecialchars(strtolower($booking['status'] ?? 'scheduled')) ?>"><?= htmlspecialchars($booking['status'] ?? 'scheduled') ?></span></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>

            <div class="panel">
                <div class="panel-head"><div><h2>Access Control</h2><small>Referral/file permission rules</small></div><span class="badge"><?= count($adminWorkspace['accessControls'] ?? []) ?> rules</span></div>
                <?php if (empty($adminWorkspace['accessControls'])): ?>
                    <div class="empty">No access rules yet.</div>
                <?php else: ?>
                    <table class="audit-table">
                        <thead><tr><th>Role</th><th>Resource</th><th>Permission</th><th>Status</th></tr></thead>
                        <tbody>
                        <?php foreach ($adminWorkspace['accessControls'] as $rule): ?>
                            <tr><td><?= htmlspecialchars($rule['subject_role']) ?></td><td><?= htmlspecialchars($rule['resource_type']) ?></td><td><?= htmlspecialchars($rule['permission_level']) ?></td><td><span class="badge <?= htmlspecialchars(strtolower($rule['status'] ?? 'active')) ?>"><?= htmlspecialchars($rule['status'] ?? 'active') ?></span></td></tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>

            <div class="panel">
                <div class="panel-head"><div><h2>Transfer Logs</h2><small>Referral and clinical file movement</small></div><span class="badge"><?= count($adminWorkspace['transferLogs'] ?? []) ?> logs</span></div>
                <?php if (empty($adminWorkspace['transferLogs'])): ?>
                    <div class="empty">No transfer logs yet.</div>
                <?php else: ?>
                    <table class="audit-table">
                        <thead><tr><th>Sender</th><th>Entity</th><th>Action</th><th>Time</th></tr></thead>
                        <tbody>
                        <?php foreach ($adminWorkspace['transferLogs'] as $log): ?>
                            <tr><td><?= htmlspecialchars($log['sender_name'] ?? 'System') ?></td><td><?= htmlspecialchars($log['entity_type'] ?? 'record') ?> #<?= htmlspecialchars((string) ($log['entity_id'] ?? '-')) ?></td><td><?= htmlspecialchars($log['action'] ?? 'transfer') ?></td><td><?= htmlspecialchars($log['created_at'] ?? '') ?></td></tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>

            <div class="panel full">
                <div class="panel-head"><div><h2>Security Monitoring</h2><small>Unauthorized access, abnormal download, and permission alerts</small></div><span class="badge"><?= count($adminWorkspace['securityAlerts'] ?? []) ?> alerts</span></div>
                <?php if (empty($adminWorkspace['securityAlerts'])): ?>
                    <div class="empty">No security alerts found.</div>
                <?php else: ?>
                    <table class="audit-table">
                        <thead><tr><th>Actor</th><th>Alert</th><th>Entity</th><th>IP</th><th>Time</th></tr></thead>
                        <tbody>
                        <?php foreach ($adminWorkspace['securityAlerts'] as $alert): ?>
                            <tr><td><?= htmlspecialchars($alert['actor_name'] ?? 'System') ?></td><td><?= htmlspecialchars($alert['action'] ?? 'alert') ?></td><td><?= htmlspecialchars($alert['entity_type'] ?? 'system') ?> #<?= htmlspecialchars((string) ($alert['entity_id'] ?? '-')) ?></td><td><?= htmlspecialchars($alert['ip_address'] ?? '-') ?></td><td><?= htmlspecialchars($alert['created_at'] ?? '') ?></td></tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </section>
    </main>
</div>
<?php require_once '../app/views/partials/theme_toggle.php'; ?>
</body>
</html>
