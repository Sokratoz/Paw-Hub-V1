<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Paw Hubs</title>
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
            font-size: 22px;
            font-weight: 800;
        }

        .brand i,
        .stat-icon,
        .avatar {
            display: grid;
            place-items: center;
        }

        .brand i {
            width: 44px;
            height: 44px;
            border-radius: 14px;
            background: var(--mint);
        }

        .menu-label {
            color: var(--muted);
            font-size: 12px;
            font-weight: 700;
            margin: 0 0 10px;
        }

        .menu { display: grid; gap: 8px; }
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

        .sidebar-footer { margin-top: auto; }
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

        .page-head h1 { margin: 0; font-size: 32px; letter-spacing: 0; }
        .page-head p {
            margin: 7px 0 0;
            color: var(--muted);
            max-width: 760px;
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

        .stats {
            display: grid;
            grid-template-columns: repeat(5, minmax(140px, 1fr));
            gap: 16px;
            margin-bottom: 18px;
        }

        .stat-card {
            min-height: 128px;
            padding: 18px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .stat-icon {
            width: 42px;
            height: 42px;
            border-radius: 14px;
            font-size: 18px;
        }

        .bg-teal { background: var(--mint); color: #4f9186; }
        .bg-green { background: var(--green); color: #fff; }
        .bg-olive { background: var(--olive); color: #4f6f35; }
        .bg-sky { background: var(--sky); color: #fff; }
        .stat-card span,
        .panel small,
        td small { color: var(--muted); font-weight: 700; }
        .stat-card span { font-size: 13px; }
        .stat-card strong { display: block; margin-top: 5px; font-size: 28px; }

        .grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 18px; }
        .content > .grid,
        .content > div[id="referrals"] { margin-bottom: 18px; scroll-margin-top: 18px; }
        .content > .stats { scroll-margin-top: 18px; }
        .panel { padding: 20px; min-width: 0; }
        .panel.full { grid-column: 1 / -1; }
        .module-heading {
            grid-column: 1 / -1;
            padding: 18px 20px;
            border: 1px solid var(--line);
            border-radius: 18px;
            background: #ffffff;
            box-shadow: 0 18px 38px rgba(107, 181, 168, 0.08);
            scroll-margin-top: 18px;
        }
        .module-heading h2 { margin: 0; font-size: 21px; }
        .module-heading p { margin: 6px 0 0; color: var(--muted); font-weight: 700; line-height: 1.5; }
        .panel-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            margin-bottom: 16px;
        }
        .panel h2 { margin: 0; font-size: 20px; }
        .form-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 14px; }
        .input-group { display: grid; gap: 8px; }
        .input-group.full { grid-column: 1 / -1; }
        label { color: var(--muted); font-size: 13px; font-weight: 700; }
        .form-control {
            width: 100%;
            border: 1px solid var(--line);
            border-radius: 14px;
            padding: 12px 14px;
            background: #fff;
            font: inherit;
            color: var(--ink);
        }
        textarea.form-control { min-height: 90px; resize: vertical; }
        .table-scroll { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; font-size: 14px; }
        th, td { padding: 13px 10px; border-bottom: 1px solid var(--line); text-align: left; vertical-align: top; }
        th { color: var(--muted); font-size: 12px; text-transform: uppercase; }
        .notice { border-radius: 16px; padding: 15px 17px; margin-bottom: 16px; line-height: 1.6; font-weight: 700; }
        .notice.success { background: #e6fffa; color: #155e75; border: 1px solid #b2f5ea; }
        .notice.error { background: #fff5f5; color: #742a2a; border: 1px solid #fed7d7; }
        .empty { min-height: 130px; display: grid; place-items: center; border: 1px dashed var(--line); border-radius: 14px; color: var(--muted); background: var(--soft); text-align: center; padding: 16px; }
        .avatar { width: 34px; height: 34px; border-radius: 12px; background: var(--mint); color: #4f9186; font-weight: 900; }
        .actor { display: flex; align-items: center; gap: 10px; }
        .inline-actions { display: flex; flex-wrap: wrap; gap: 8px; }
        .badge.approved, .badge.available, .badge.completed { background: var(--green); color: #fff; }
        .badge.rejected, .badge.unavailable, .badge.maintenance { background: #fff5f5; color: var(--danger); }
        .badge.scheduled, .badge.pending, .badge.reserved { background: var(--olive); color: #4f6f35; }
        .bars { display: grid; gap: 12px; }
        .bar-row { display: grid; grid-template-columns: minmax(120px, 0.8fr) 1fr auto; gap: 12px; align-items: center; }
        .bar-track { height: 12px; border-radius: 999px; background: var(--soft); overflow: hidden; }
        .bar-fill { height: 100%; border-radius: inherit; background: linear-gradient(90deg, var(--teal), var(--sky)); }
        .shortcut-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 14px; }
        .shortcut {
            min-height: 86px;
            border: 1px solid var(--line);
            border-radius: 14px;
            padding: 16px;
            display: flex;
            align-items: center;
            gap: 14px;
            color: var(--ink);
            text-decoration: none;
            background: #fff;
        }
        .shortcut i {
            width: 42px;
            height: 42px;
            border-radius: 14px;
            display: grid;
            place-items: center;
            background: var(--mint);
            color: #4f9186;
            flex: 0 0 auto;
        }
        .shortcut strong { display: block; margin-bottom: 4px; }
        .shortcut span { color: var(--muted); font-size: 13px; font-weight: 700; }
        .work-grid { display: grid; grid-template-columns: 1.4fr 0.8fr; gap: 18px; }
        .feed { display: grid; gap: 12px; }
        .feed-item {
            display: grid;
            grid-template-columns: auto 1fr;
            gap: 12px;
            align-items: start;
            border: 1px solid var(--line);
            border-radius: 14px;
            padding: 13px;
            background: #fff;
        }
        .feed-item p { margin: 4px 0 0; color: var(--muted); line-height: 1.45; }
        .muted { color: var(--muted); font-weight: 700; }
        .modal-backdrop {
            position: fixed;
            inset: 0;
            z-index: 50;
            display: none;
            place-items: center;
            padding: 18px;
            background: rgba(47, 79, 79, 0.38);
        }
        .modal-backdrop.open { display: grid; }
        .modal {
            width: min(720px, 100%);
            max-height: min(88vh, 780px);
            overflow-y: auto;
            background: #fff;
            border: 1px solid var(--line);
            border-radius: 18px;
            box-shadow: 0 28px 70px rgba(47, 79, 79, 0.22);
            padding: 22px;
        }
        .modal-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            margin-bottom: 18px;
        }
        .modal-head h2 { margin: 0; font-size: 20px; }
        .icon-btn {
            width: 42px;
            height: 42px;
            border: 1px solid var(--line);
            border-radius: 13px;
            background: #fff;
            color: var(--ink);
            cursor: pointer;
        }

        @media (max-width: 1150px) {
            body { padding: 16px; }
            .app-frame { grid-template-columns: 1fr; }
            .sidebar { display: none; }
            .stats, .grid, .work-grid { grid-template-columns: 1fr; }
            .panel.full { grid-column: auto; }
        }
        @media (max-width: 640px) {
            .content { padding: 16px; }
            .topbar, .page-head { align-items: stretch; flex-direction: column; }
            .form-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
<?php
$page = $page ?? 'dashboard';
$titles = [
    'dashboard' => ['Main Dashboard', 'A quick summary of users, surgeries, available rooms, and revenue.'],
    'users' => ['User Management', 'Manage pet owners, vets, and staff accounts from the database.'],
    'rooms' => ['Operating Rooms Management', 'Add operating rooms, track room status, and review room schedule.'],
    'equipment' => ['Equipment Management', 'Manage surgical devices, maintenance notes, and availability.'],
    'approvals' => ['Surgery Approval Center', 'Review surgery requests, conflicts, room suggestions, approvals, rejections, and reschedules.'],
    'staff' => ['Staff Scheduling', 'Organize doctors, specialists, and clinical staff workload.'],
    'reports' => ['Reports & Analytics', 'Monthly surgeries, top doctors, room usage, and equipment usage.'],
    'referrals' => ['Veterinary Referrals Workflow', 'Secure medical record transfer between clinics during referrals.'],
    'clinical' => ['Clinical Workspace', 'Medical procedures history, lab reports, referral requests, and audit logs.'],
    'clinical_surgery' => ['Surgery & Procedure Resource Manager', 'Operating rooms, equipment, surgery approvals, and medical procedure history.'],
    'clinical_labs' => ['Lab Result Interpretation Hub', 'Lab reports, result summaries, interpretations, and report status.'],
    'clinical_audit' => ['Data Privacy Audit Logger', 'Clinical privacy and data access audit events.']
];
$activeTitle = $titles[$page] ?? $titles['dashboard'];
$nav = [
    'dashboard' => ['Main Dashboard', 'fa-gauge-high', 'admin/index'],
    'users' => ['User Management', 'fa-users', 'admin/users'],
    'staff' => ['Staff Scheduling', 'fa-user-nurse', 'admin/staff'],
    'reports' => ['Reports', 'fa-chart-line', 'admin/reports']
];
$clinicalNav = [
    'clinical_surgery' => ['Surgery & Procedure Resource Manager', 'fa-briefcase-medical', 'admin/surgery'],
    'clinical_labs' => ['Lab Result Interpretation Hub', 'fa-vial-circle-check', 'admin/labHub'],
    'referrals' => ['Veterinary Referrals Workflow', 'fa-share-nodes', 'admin/referrals'],
    'clinical_audit' => ['Data Privacy Audit Logger', 'fa-shield-halved', 'admin/privacyAudit']
];
?>
<div class="app-frame">
    <aside class="sidebar">
        <div class="brand"><i class="fas fa-user-tie"></i><span>Paw Admin</span></div>
        <div>
            <p class="menu-label">Admin Dashboard</p>
            <nav class="menu">
                <?php foreach ($nav as $key => $item): ?>
                    <a class="<?= $page === $key ? 'active' : '' ?>" href="index.php?url=<?= htmlspecialchars($item[2]) ?>"><i class="fas <?= htmlspecialchars($item[1]) ?>"></i> <?= htmlspecialchars($item[0]) ?></a>
                <?php endforeach; ?>
            </nav>
        </div>
        <div>
            <p class="menu-label">Clinical</p>
            <nav class="menu">
                <?php foreach ($clinicalNav as $key => $item): ?>
                    <a class="<?= $page === $key ? 'active' : '' ?>" href="index.php?url=<?= htmlspecialchars($item[2]) ?>"><i class="fas <?= htmlspecialchars($item[1]) ?>"></i> <?= htmlspecialchars($item[0]) ?></a>
                <?php endforeach; ?>
            </nav>
        </div>
        <div class="sidebar-footer">
            <nav class="menu">
                <a href="index.php?url=home/index"><i class="fas fa-home"></i> Home</a>
                <a href="index.php?url=auth/logout"><i class="fas fa-arrow-right-from-bracket"></i> Logout</a>
            </nav>
        </div>
    </aside>

    <main class="content">
        <div class="topbar">
            <label class="search"><i class="fas fa-search"></i><input type="search" placeholder="Search admin workspace"></label>
            <a class="action-btn" href="index.php?url=audit/index"><i class="fas fa-shield-halved"></i> Audit Logs</a>
        </div>

        <header class="page-head">
            <div>
                <h1><?= htmlspecialchars($activeTitle[0]) ?></h1>
                <p><?= htmlspecialchars($activeTitle[1]) ?></p>
            </div>
            <span class="role-pill">Admin only</span>
        </header>

        <?php if (!empty($message)): ?><div class="notice success"><?= htmlspecialchars($message) ?></div><?php endif; ?>
        <?php if (!empty($errors)): ?><div class="notice error"><?= htmlspecialchars(implode(' ', $errors)) ?></div><?php endif; ?>

        <?php if ($page === 'dashboard'): ?>
            <section class="stats" id="dashboard">
                <article class="stat-card"><div class="stat-icon bg-teal"><i class="fas fa-users"></i></div><div><span>Users</span><strong><?= (int) $stats['users'] ?></strong></div></article>
                <article class="stat-card"><div class="stat-icon bg-green"><i class="fas fa-user-doctor"></i></div><div><span>Vets</span><strong><?= (int) $stats['vets'] ?></strong></div></article>
                <article class="stat-card"><div class="stat-icon bg-olive"><i class="fas fa-briefcase-medical"></i></div><div><span>Surgeries</span><strong><?= (int) $stats['procedures'] ?></strong></div></article>
                <article class="stat-card"><div class="stat-icon bg-sky"><i class="fas fa-door-open"></i></div><div><span>Available Rooms</span><strong><?= (int) $stats['available_rooms'] ?></strong></div></article>
                <article class="stat-card"><div class="stat-icon bg-teal"><i class="fas fa-coins"></i></div><div><span>Revenue</span><strong><?= number_format((float) $stats['revenue'], 0) ?></strong></div></article>
            </section>
            <section class="grid">
                <?php renderBookingsPanel($bookings); ?>
                <?php renderReportBars('Room Usage', $reports['room_usage'] ?? []); ?>
                <div class="panel full">
                    <div class="panel-head"><div><h2>Quick Access</h2><small>Open each workspace from its own page.</small></div></div>
                    <div class="shortcut-grid">
                        <a class="shortcut" href="index.php?url=admin/users"><i class="fas fa-users"></i><div><strong>User Management</strong><span>View registered owners, vets, and staff.</span></div></a>
                        <a class="shortcut" href="index.php?url=admin/clinical"><i class="fas fa-stethoscope"></i><div><strong>Clinical Workspace</strong><span>Procedures, lab reports, referrals, and clinical audit logs.</span></div></a>
                    </div>
                </div>
            </section>

        <?php elseif ($page === 'users'): ?>
            <section class="grid" id="users">
                <?php renderUsersPanel('Pet Owners', $users['owners'] ?? []); ?>
                <?php renderUsersPanel('Vets', $users['vets'] ?? []); ?>
                <?php renderUsersPanel('Staff', $users['staff'] ?? [], true); ?>
            </section>

        <?php elseif ($page === 'rooms'): ?>
            <?php renderSurgeryResourceManager($clinicalData ?? [], $rooms ?? [], $equipment ?? [], $bookings ?? []); ?>

        <?php elseif ($page === 'equipment'): ?>
            <?php renderSurgeryResourceManager($clinicalData ?? [], $rooms ?? [], $equipment ?? [], $bookings ?? []); ?>

        <?php elseif ($page === 'approvals'): ?>
            <?php renderSurgeryResourceManager($clinicalData ?? [], $rooms ?? [], $equipment ?? [], $bookings ?? []); ?>

        <?php elseif ($page === 'staff'): ?>
            <section class="grid" id="staff">
                <?php renderStaffPanel($staff); ?>
            </section>

        <?php elseif ($page === 'reports'): ?>
            <section class="grid" id="reports">
                <?php renderReportBars('Monthly Surgeries', $reports['monthly'] ?? [], 'month'); ?>
                <?php renderReportBars('Top Doctors', $reports['top_vets'] ?? [], 'username'); ?>
                <?php renderReportBars('Room Usage', $reports['room_usage'] ?? []); ?>
                <?php renderReportBars('Equipment Usage', $reports['equipment_usage'] ?? []); ?>
            </section>

        <?php elseif ($page === 'referrals'): ?>
            <div id="referrals">
                <?php renderReferralWorkspace($referralData ?? []); ?>
            </div>

        <?php elseif ($page === 'clinical'): ?>
            <?php renderClinicalWorkspace($clinicalData ?? [], $rooms ?? [], $equipment ?? [], $bookings ?? []); ?>
        <?php elseif ($page === 'clinical_surgery'): ?>
            <?php renderSurgeryResourceManager($clinicalData ?? [], $rooms ?? [], $equipment ?? [], $bookings ?? []); ?>
        <?php elseif ($page === 'clinical_labs'): ?>
            <?php renderLabResultHub($clinicalData ?? []); ?>
        <?php elseif ($page === 'clinical_audit'): ?>
            <?php renderPrivacyAuditLogger($auditData ?? []); ?>
        <?php endif; ?>
    </main>
</div>
<?php require_once '../app/views/partials/theme_toggle.php'; ?>
<script>
document.querySelectorAll('[data-modal-target]').forEach((button) => {
    button.addEventListener('click', () => {
        const modal = document.getElementById(button.dataset.modalTarget);
        if (modal) modal.classList.add('open');
    });
});
document.querySelectorAll('[data-modal-close]').forEach((button) => {
    button.addEventListener('click', () => {
        const modal = button.closest('.modal-backdrop');
        if (modal) modal.classList.remove('open');
    });
});
document.querySelectorAll('.modal-backdrop').forEach((modal) => {
    modal.addEventListener('click', (event) => {
        if (event.target === modal) modal.classList.remove('open');
    });
});
document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') {
        document.querySelectorAll('.modal-backdrop.open').forEach((modal) => modal.classList.remove('open'));
    }
});
(() => {
    const search = document.getElementById('auditSearch');
    const rows = Array.from(document.querySelectorAll('.audit-row'));
    if (!search) return;
    search.addEventListener('input', () => {
        const value = search.value.trim().toLowerCase();
        rows.forEach((row) => {
            row.style.display = row.textContent.toLowerCase().includes(value) ? '' : 'none';
        });
    });
})();
</script>
</body>
</html>

<?php
function renderBookingsPanel($bookings) { ?>
    <div class="panel">
        <div class="panel-head"><div><h2>Latest Surgery Requests</h2><small>Procedure bookings from the database.</small></div><span class="badge"><?= count($bookings) ?> requests</span></div>
        <div class="table-scroll"><?php renderBookingsTable($bookings, false); ?></div>
    </div>
<?php }

function renderBookingsTable($bookings, $actions) { ?>
    <?php if (empty($bookings)): ?><div class="empty">No surgery requests yet.</div><?php else: ?>
    <table><thead><tr><th>Procedure</th><th>Room / Equipment</th><th>Specialist</th><th>Time</th><th>Conflict / Suggestion</th><th>Status</th><?= $actions ? '<th>Actions</th>' : '' ?></tr></thead><tbody>
    <?php foreach ($bookings as $booking): ?>
        <tr>
            <td><strong><?= htmlspecialchars($booking['procedure_name'] ?? 'Procedure') ?></strong><br><small><?= htmlspecialchars($booking['pet_name'] ?? 'Unknown pet') ?></small></td>
            <td><?= htmlspecialchars($booking['room_name'] ?? 'No room') ?><br><small><?= htmlspecialchars($booking['equipment_name'] ?? 'No equipment') ?></small></td>
            <td><?= htmlspecialchars($booking['specialist_name'] ?? 'Unassigned') ?></td>
            <td><?= htmlspecialchars(date('Y-m-d H:i', strtotime($booking['start_time'] ?? 'now'))) ?><br><small>to <?= htmlspecialchars(date('H:i', strtotime($booking['end_time'] ?? 'now'))) ?></small></td>
            <td>
                <?= htmlspecialchars($booking['conflict_summary'] ?? 'No conflicts') ?><br>
                <small><?= !empty($booking['room_suggestion']) ? 'Suggested room: ' . htmlspecialchars($booking['room_suggestion']) : 'No room suggestion' ?></small>
            </td>
            <td><span class="badge <?= htmlspecialchars(strtolower($booking['status'] ?? 'scheduled')) ?>"><?= htmlspecialchars($booking['status'] ?? 'scheduled') ?></span></td>
            <?php if ($actions): ?>
                <td>
                    <div class="inline-actions">
                        <form method="post"><input type="hidden" name="booking_id" value="<?= (int) $booking['id'] ?>"><button class="action-btn" name="action" value="approve" type="submit">Approve</button></form>
                        <form method="post"><input type="hidden" name="booking_id" value="<?= (int) $booking['id'] ?>"><button class="action-btn" name="action" value="reject" type="submit">Reject</button></form>
                    </div>
                </td>
            <?php endif; ?>
        </tr>
    <?php endforeach; ?></tbody></table>
    <?php endif; ?>
<?php }

function renderUsersPanel($title, $rows) { ?>
    <div class="panel <?= $title === 'Staff' ? 'full' : '' ?>">
        <div class="panel-head"><div><h2><?= htmlspecialchars($title) ?></h2><small><?= count($rows) ?> accounts</small></div></div>
        <div class="table-scroll">
            <?php if (empty($rows)): ?><div class="empty">No records yet.</div><?php else: ?>
            <table><thead><tr><th>User</th><th>Email</th><th>Role</th><th>Status</th></tr></thead><tbody>
            <?php foreach ($rows as $row): ?><tr><td><div class="actor"><span class="avatar"><?= htmlspecialchars(strtoupper(substr($row['username'] ?? 'U', 0, 1))) ?></span><strong><?= htmlspecialchars($row['username'] ?? 'User') ?></strong></div></td><td><?= htmlspecialchars($row['email'] ?? '') ?></td><td><?= htmlspecialchars($row['role'] ?? '') ?></td><td><span class="badge <?= htmlspecialchars(strtolower($row['status'] ?? 'active')) ?>"><?= htmlspecialchars($row['status'] ?? 'active') ?></span></td></tr><?php endforeach; ?>
            </tbody></table><?php endif; ?>
        </div>
    </div>
<?php }

function renderRoomsPanel($rooms, $bookings) { ?>
    <div class="panel">
        <div class="panel-head"><div><h2>Rooms Schedule</h2><small>Room status and upcoming bookings.</small></div></div>
        <?php if (empty($rooms)): ?><div class="empty">No operating rooms yet.</div><?php else: ?>
        <div class="table-scroll"><table><thead><tr><th>Room</th><th>Location</th><th>Status</th><th>Scheduled</th></tr></thead><tbody>
        <?php foreach ($rooms as $room): $count = count(array_filter($bookings, fn($b) => (int) ($b['room_id'] ?? 0) === (int) $room['id'])); ?>
            <tr><td><?= htmlspecialchars($room['name']) ?></td><td><?= htmlspecialchars($room['location'] ?? '') ?></td><td><span class="badge <?= htmlspecialchars(strtolower($room['status'] ?? 'available')) ?>"><?= htmlspecialchars($room['status'] ?? 'available') ?></span></td><td><?= $count ?></td></tr>
        <?php endforeach; ?></tbody></table></div><?php endif; ?>
    </div>
<?php }

function renderEquipmentPanel($equipment) { ?>
    <div class="panel">
        <div class="panel-head"><div><h2>Equipment Inventory</h2><small>Availability and maintenance.</small></div></div>
        <?php if (empty($equipment)): ?><div class="empty">No equipment yet.</div><?php else: ?>
        <div class="table-scroll"><table><thead><tr><th>Name</th><th>Type</th><th>Status</th><th>Notes</th></tr></thead><tbody>
        <?php foreach ($equipment as $item): ?><tr><td><?= htmlspecialchars($item['name']) ?></td><td><?= htmlspecialchars($item['type'] ?? '') ?></td><td><span class="badge <?= htmlspecialchars(strtolower($item['status'] ?? 'available')) ?>"><?= htmlspecialchars($item['status'] ?? 'available') ?></span></td><td><?= htmlspecialchars($item['notes'] ?? '') ?></td></tr><?php endforeach; ?>
        </tbody></table></div><?php endif; ?>
    </div>
<?php }

function renderApprovalPanel($bookings) { ?>
    <div class="panel full" id="approvals">
        <div class="panel-head"><div><h2>Surgery Approval Center</h2><small>Approve, reject, or reschedule surgery requests.</small></div></div>
        <div class="table-scroll"><?php renderBookingsTable($bookings, true); ?></div>
        <div class="panel" style="margin-top:18px;">
            <div class="panel-head"><div><h2>Reschedule Request</h2><small>Choose booking id from the table.</small></div></div>
            <form method="post" class="form-grid">
                <input type="hidden" name="action" value="reschedule">
                <div class="input-group"><label>Booking ID</label><input class="form-control" name="booking_id" type="number" min="1"></div>
                <div class="input-group"><label>Date</label><input class="form-control" name="procedure_date" type="date"></div>
                <div class="input-group"><label>Start</label><input class="form-control" name="start_time" type="time"></div>
                <div class="input-group"><label>End</label><input class="form-control" name="end_time" type="time"></div>
                <button class="action-btn primary" type="submit">Reschedule</button>
            </form>
        </div>
    </div>
<?php }

function renderStaffPanel($staff) { ?>
    <div class="panel full">
        <div class="panel-head"><div><h2>Staff Scheduling</h2><small>Current clinical staff workload.</small></div><span class="badge"><?= count($staff) ?> staff</span></div>
        <?php if (empty($staff)): ?><div class="empty">No staff records yet.</div><?php else: ?>
        <div class="table-scroll"><table><thead><tr><th>Staff</th><th>Email</th><th>Specialization</th><th>Assigned Surgeries</th></tr></thead><tbody>
        <?php foreach ($staff as $person): ?><tr><td><div class="actor"><span class="avatar"><?= htmlspecialchars(strtoupper(substr($person['username'] ?? 'S', 0, 1))) ?></span><strong><?= htmlspecialchars($person['username'] ?? 'Staff') ?></strong></div></td><td><?= htmlspecialchars($person['email'] ?? '') ?></td><td><?= htmlspecialchars($person['specialization'] ?? 'Clinical staff') ?></td><td><?= (int) $person['assigned_surgeries'] ?></td></tr><?php endforeach; ?>
        </tbody></table></div><?php endif; ?>
    </div>
<?php }

function renderClinicalWorkspace($data, $rooms = [], $equipment = [], $bookings = []) {
    renderSurgeryResourceManager($data, $rooms, $equipment, $bookings);
    renderLabResultHub($data);
    renderReferralWorkflow($data);
    renderPrivacyAuditLogger($data);
}

function renderSurgeryResourceManager($data, $rooms = [], $equipment = [], $bookings = []) {
    $procedures = $data['procedures'] ?? [];
    ?>
    <section class="grid">
        <div class="module-heading" id="surgery-module">
            <h2>Surgery &amp; Procedure Resource Manager</h2>
            <p>Operating room resources, equipment inventory, surgery approvals, and medical procedures history.</p>
        </div>

        <div class="panel" id="rooms">
            <div class="panel-head"><div><h2>Operating Rooms</h2><small>Add rooms and edit availability.</small></div><span class="badge"><?= count($rooms) ?> rooms</span></div>
            <form method="post" class="form-grid" style="margin-bottom:16px;">
                <input type="hidden" name="action" value="add_room">
                <div class="input-group"><label>Name</label><input class="form-control" name="name" placeholder="Operating Room 1"></div>
                <div class="input-group"><label>Location</label><input class="form-control" name="location" placeholder="Surgery Floor"></div>
                <div class="input-group"><label>Capacity</label><input class="form-control" name="capacity" type="number" min="1" value="1"></div>
                <div class="input-group"><label>Status</label><select class="form-control" name="status"><option>available</option><option>maintenance</option><option>unavailable</option></select></div>
                <button class="action-btn primary" type="submit"><i class="fas fa-plus"></i> Add Room</button>
            </form>
            <?php if (empty($rooms)): ?><div class="empty">No operating rooms yet.</div><?php else: ?>
            <div class="table-scroll"><table><thead><tr><th>Room</th><th>Location</th><th>Capacity</th><th>Status</th><th>Action</th></tr></thead><tbody>
            <?php foreach ($rooms as $room): $modalId = 'editRoom' . (int) $room['id']; ?>
                <tr><td><?= htmlspecialchars($room['name'] ?? '') ?></td><td><?= htmlspecialchars($room['location'] ?? '') ?></td><td><?= (int) ($room['capacity'] ?? 1) ?></td><td><span class="badge <?= htmlspecialchars(strtolower($room['status'] ?? 'available')) ?>"><?= htmlspecialchars($room['status'] ?? 'available') ?></span></td><td><button class="action-btn" type="button" data-modal-target="<?= htmlspecialchars($modalId) ?>"><i class="fas fa-pen"></i> Edit</button></td></tr>
            <?php endforeach; ?>
            </tbody></table></div><?php endif; ?>
        </div>

        <div class="panel" id="equipment">
            <div class="panel-head"><div><h2>Equipment</h2><small>Add equipment and edit maintenance state.</small></div><span class="badge"><?= count($equipment) ?> items</span></div>
            <form method="post" class="form-grid" style="margin-bottom:16px;">
                <input type="hidden" name="action" value="add_equipment">
                <div class="input-group"><label>Name</label><input class="form-control" name="name" placeholder="Anesthesia Machine"></div>
                <div class="input-group"><label>Type</label><input class="form-control" name="type" placeholder="Anesthesia"></div>
                <div class="input-group"><label>Status</label><select class="form-control" name="status"><option>available</option><option>reserved</option><option>maintenance</option></select></div>
                <div class="input-group full"><label>Notes</label><textarea class="form-control" name="notes"></textarea></div>
                <button class="action-btn primary" type="submit"><i class="fas fa-plus"></i> Add Equipment</button>
            </form>
            <?php if (empty($equipment)): ?><div class="empty">No equipment yet.</div><?php else: ?>
            <div class="table-scroll"><table><thead><tr><th>Name</th><th>Type</th><th>Status</th><th>Notes</th><th>Action</th></tr></thead><tbody>
            <?php foreach ($equipment as $item): $modalId = 'editEquipment' . (int) $item['id']; ?>
                <tr><td><?= htmlspecialchars($item['name'] ?? '') ?></td><td><?= htmlspecialchars($item['type'] ?? '') ?></td><td><span class="badge <?= htmlspecialchars(strtolower($item['status'] ?? 'available')) ?>"><?= htmlspecialchars($item['status'] ?? 'available') ?></span></td><td><?= htmlspecialchars($item['notes'] ?? '') ?></td><td><button class="action-btn" type="button" data-modal-target="<?= htmlspecialchars($modalId) ?>"><i class="fas fa-pen"></i> Edit</button></td></tr>
            <?php endforeach; ?>
            </tbody></table></div><?php endif; ?>
        </div>

        <?php renderApprovalPanel($bookings); ?>

        <div class="panel full" id="procedures">
            <div class="panel-head"><div><h2>Medical Procedures History</h2><small>Procedure records from the clinical database.</small></div><span class="badge"><?= count($procedures) ?> records</span></div>
            <?php if (empty($procedures)): ?><div class="empty">No medical procedures yet.</div><?php else: ?>
            <div class="table-scroll"><table><thead><tr><th>Procedure</th><th>Pet</th><th>Vet</th><th>Date</th><th>Status</th><th>Notes</th><th>Action</th></tr></thead><tbody>
            <?php foreach ($procedures as $procedure): $modalId = 'editProcedure' . (int) $procedure['id']; ?>
                <tr>
                    <td><strong><?= htmlspecialchars($procedure['procedure_name'] ?? 'Procedure') ?></strong><br><small><?= htmlspecialchars($procedure['procedure_type'] ?? '-') ?></small></td>
                    <td><?= htmlspecialchars($procedure['pet_name'] ?? 'Unknown pet') ?></td>
                    <td><?= htmlspecialchars($procedure['vet_name'] ?? 'Unassigned') ?></td>
                    <td><?= htmlspecialchars($procedure['procedure_date'] ?? '') ?></td>
                    <td><span class="badge <?= htmlspecialchars(strtolower($procedure['status'] ?? 'scheduled')) ?>"><?= htmlspecialchars($procedure['status'] ?? 'scheduled') ?></span></td>
                    <td><?= htmlspecialchars($procedure['notes'] ?? '') ?></td>
                    <td><button class="action-btn" type="button" data-modal-target="<?= htmlspecialchars($modalId) ?>"><i class="fas fa-pen"></i> Edit</button></td>
                </tr>
            <?php endforeach; ?>
            </tbody></table></div><?php endif; ?>
        </div>

    </section>

    <?php foreach ($rooms as $room): $modalId = 'editRoom' . (int) $room['id']; ?>
        <div class="modal-backdrop" id="<?= htmlspecialchars($modalId) ?>"><div class="modal">
            <div class="modal-head"><div><h2>Edit Operating Room</h2><small><?= htmlspecialchars($room['name'] ?? 'Room') ?></small></div><button class="icon-btn" type="button" data-modal-close><i class="fas fa-xmark"></i></button></div>
            <form method="post" class="form-grid">
                <input type="hidden" name="action" value="update_room">
                <input type="hidden" name="room_id" value="<?= (int) $room['id'] ?>">
                <div class="input-group"><label>Name</label><input class="form-control" name="name" value="<?= htmlspecialchars($room['name'] ?? '') ?>"></div>
                <div class="input-group"><label>Location</label><input class="form-control" name="location" value="<?= htmlspecialchars($room['location'] ?? '') ?>"></div>
                <div class="input-group"><label>Capacity</label><input class="form-control" name="capacity" type="number" min="1" value="<?= (int) ($room['capacity'] ?? 1) ?>"></div>
                <div class="input-group"><label>Status</label><select class="form-control" name="status"><?php renderOptions(['available', 'maintenance', 'unavailable'], $room['status'] ?? 'available'); ?></select></div>
                <button class="action-btn primary" type="submit"><i class="fas fa-floppy-disk"></i> Save Changes</button>
            </form>
        </div></div>
    <?php endforeach; ?>

    <?php foreach ($equipment as $item): $modalId = 'editEquipment' . (int) $item['id']; ?>
        <div class="modal-backdrop" id="<?= htmlspecialchars($modalId) ?>"><div class="modal">
            <div class="modal-head"><div><h2>Edit Equipment</h2><small><?= htmlspecialchars($item['name'] ?? 'Equipment') ?></small></div><button class="icon-btn" type="button" data-modal-close><i class="fas fa-xmark"></i></button></div>
            <form method="post" class="form-grid">
                <input type="hidden" name="action" value="update_equipment">
                <input type="hidden" name="equipment_id" value="<?= (int) $item['id'] ?>">
                <div class="input-group"><label>Name</label><input class="form-control" name="name" value="<?= htmlspecialchars($item['name'] ?? '') ?>"></div>
                <div class="input-group"><label>Type</label><input class="form-control" name="type" value="<?= htmlspecialchars($item['type'] ?? '') ?>"></div>
                <div class="input-group"><label>Status</label><select class="form-control" name="status"><?php renderOptions(['available', 'reserved', 'maintenance'], $item['status'] ?? 'available'); ?></select></div>
                <div class="input-group full"><label>Notes</label><textarea class="form-control" name="notes"><?= htmlspecialchars($item['notes'] ?? '') ?></textarea></div>
                <button class="action-btn primary" type="submit"><i class="fas fa-floppy-disk"></i> Save Changes</button>
            </form>
        </div></div>
    <?php endforeach; ?>

    <?php foreach ($procedures as $procedure): $modalId = 'editProcedure' . (int) $procedure['id']; ?>
        <div class="modal-backdrop" id="<?= htmlspecialchars($modalId) ?>"><div class="modal">
            <div class="modal-head"><div><h2>Edit Procedure</h2><small><?= htmlspecialchars($procedure['pet_name'] ?? 'Unknown pet') ?></small></div><button class="icon-btn" type="button" data-modal-close><i class="fas fa-xmark"></i></button></div>
            <form method="post" class="form-grid">
                <input type="hidden" name="action" value="update_procedure">
                <input type="hidden" name="procedure_id" value="<?= (int) $procedure['id'] ?>">
                <div class="input-group"><label>Name</label><input class="form-control" name="procedure_name" value="<?= htmlspecialchars($procedure['procedure_name'] ?? '') ?>"></div>
                <div class="input-group"><label>Type</label><input class="form-control" name="procedure_type" value="<?= htmlspecialchars($procedure['procedure_type'] ?? '') ?>"></div>
                <div class="input-group"><label>Status</label><select class="form-control" name="status"><?php renderOptions(['scheduled', 'approved', 'completed', 'cancelled'], $procedure['status'] ?? 'scheduled'); ?></select></div>
                <div class="input-group"><label>Date</label><input class="form-control" type="date" name="procedure_date" value="<?= htmlspecialchars($procedure['procedure_date'] ?? '') ?>"></div>
                <div class="input-group full"><label>Notes</label><textarea class="form-control" name="notes"><?= htmlspecialchars($procedure['notes'] ?? '') ?></textarea></div>
                <button class="action-btn primary" type="submit"><i class="fas fa-floppy-disk"></i> Save Changes</button>
            </form>
        </div></div>
    <?php endforeach; ?>
<?php }

function renderLabResultHub($data) {
    $labReports = $data['labReports'] ?? [];
    ?>
    <section class="grid">
        <div class="module-heading" id="labs-module">
            <h2>Lab Result Interpretation Hub</h2>
            <p>Lab reports section with result summaries, interpretation notes, status, and editable report dates.</p>
        </div>

        <div class="panel full" id="labs">
            <div class="panel-head"><div><h2>Lab Reports Section</h2><small>Test results, interpretation, and status.</small></div><span class="badge"><?= count($labReports) ?> reports</span></div>
            <?php if (empty($labReports)): ?><div class="empty">No lab reports yet.</div><?php else: ?>
            <div class="table-scroll"><table><thead><tr><th>Test</th><th>Pet</th><th>Vet</th><th>Date</th><th>Status</th><th>Summary</th><th>Action</th></tr></thead><tbody>
            <?php foreach ($labReports as $report): $modalId = 'editLab' . (int) $report['id']; ?>
                <tr>
                    <td><strong><?= htmlspecialchars($report['test_name'] ?? 'Lab test') ?></strong></td>
                    <td><?= htmlspecialchars($report['pet_name'] ?? 'Unknown pet') ?></td>
                    <td><?= htmlspecialchars($report['vet_name'] ?? 'Unassigned') ?></td>
                    <td><?= htmlspecialchars($report['report_date'] ?? '') ?></td>
                    <td><span class="badge <?= htmlspecialchars(strtolower($report['status'] ?? 'pending')) ?>"><?= htmlspecialchars($report['status'] ?? 'pending') ?></span></td>
                    <td><?= htmlspecialchars($report['result_summary'] ?? '') ?></td>
                    <td><button class="action-btn" type="button" data-modal-target="<?= htmlspecialchars($modalId) ?>"><i class="fas fa-pen"></i> Edit</button></td>
                </tr>
            <?php endforeach; ?>
            </tbody></table></div><?php endif; ?>
        </div>
    </section>

    <?php foreach ($labReports as $report): $modalId = 'editLab' . (int) $report['id']; ?>
        <div class="modal-backdrop" id="<?= htmlspecialchars($modalId) ?>"><div class="modal">
            <div class="modal-head"><div><h2>Edit Lab Report</h2><small><?= htmlspecialchars($report['pet_name'] ?? 'Unknown pet') ?></small></div><button class="icon-btn" type="button" data-modal-close><i class="fas fa-xmark"></i></button></div>
            <form method="post" class="form-grid">
                <input type="hidden" name="action" value="update_lab_report">
                <input type="hidden" name="report_id" value="<?= (int) $report['id'] ?>">
                <div class="input-group"><label>Test Name</label><input class="form-control" name="test_name" value="<?= htmlspecialchars($report['test_name'] ?? '') ?>"></div>
                <div class="input-group"><label>Status</label><select class="form-control" name="status"><?php renderOptions(['pending', 'normal', 'critical', 'completed'], $report['status'] ?? 'pending'); ?></select></div>
                <div class="input-group"><label>Date</label><input class="form-control" type="date" name="report_date" value="<?= htmlspecialchars($report['report_date'] ?? '') ?>"></div>
                <div class="input-group full"><label>Summary</label><textarea class="form-control" name="result_summary"><?= htmlspecialchars($report['result_summary'] ?? '') ?></textarea></div>
                <div class="input-group full"><label>Interpretation</label><textarea class="form-control" name="interpretation"><?= htmlspecialchars($report['interpretation'] ?? '') ?></textarea></div>
                <button class="action-btn primary" type="submit"><i class="fas fa-floppy-disk"></i> Save Changes</button>
            </form>
        </div></div>
    <?php endforeach; ?>
<?php }

function renderReferralWorkflow($data) {
    $referrals = $data['referrals'] ?? [];
    ?>
    <section class="grid">
        <div class="module-heading" id="referrals-module">
            <h2>Veterinary Referrals Workflow</h2>
            <p>Referral requests for secure clinical handoff between veterinarians and specialty clinics.</p>
        </div>

        <div class="panel full" id="referrals">
            <div class="panel-head"><div><h2>Referral Requests</h2><small>Veterinary referrals workflow.</small></div><span class="badge"><?= count($referrals) ?> referrals</span></div>
            <?php if (empty($referrals)): ?><div class="empty">No referral requests yet.</div><?php else: ?>
            <div class="table-scroll"><table><thead><tr><th>Pet</th><th>Specialty</th><th>Sender</th><th>Receiver</th><th>Status</th><th>Reason</th><th>Action</th></tr></thead><tbody>
            <?php foreach ($referrals as $referral): $modalId = 'editReferral' . (int) $referral['id']; ?>
                <tr>
                    <td><?= htmlspecialchars($referral['pet_name'] ?? 'Unknown pet') ?></td>
                    <td><strong><?= htmlspecialchars($referral['specialty'] ?? 'Referral') ?></strong><br><small><?= htmlspecialchars($referral['priority'] ?? 'normal') ?></small></td>
                    <td><?= htmlspecialchars($referral['sender_name'] ?? 'Unassigned') ?></td>
                    <td><?= htmlspecialchars($referral['receiver_name'] ?? 'Unassigned') ?></td>
                    <td><span class="badge <?= htmlspecialchars(strtolower($referral['status'] ?? 'pending')) ?>"><?= htmlspecialchars($referral['status'] ?? 'pending') ?></span></td>
                    <td><?= htmlspecialchars($referral['reason'] ?? '') ?></td>
                    <td><button class="action-btn" type="button" data-modal-target="<?= htmlspecialchars($modalId) ?>"><i class="fas fa-pen"></i> Edit</button></td>
                </tr>
            <?php endforeach; ?>
            </tbody></table></div><?php endif; ?>
        </div>
    </section>

    <?php renderReferralModals($referrals); ?>
<?php }

function renderPrivacyAuditLogger($data) {
    $logs = $data['logs'] ?? [];
    $recentLogs = $data['recentLogs'] ?? array_slice($logs, 0, 6);
    $stats = isset($data['stats']) && is_array($data['stats']) ? $data['stats'] : ['total' => 0, 'today' => 0, 'users' => 0, 'latest' => null];
    ?>
    <section class="stats">
        <article class="stat-card"><div class="stat-icon bg-teal"><i class="fas fa-list-check"></i></div><div><span>Total Events</span><strong><?= (int) $stats['total'] ?></strong></div></article>
        <article class="stat-card"><div class="stat-icon bg-green"><i class="fas fa-calendar-day"></i></div><div><span>Today</span><strong><?= (int) $stats['today'] ?></strong></div></article>
        <article class="stat-card"><div class="stat-icon bg-olive"><i class="fas fa-users"></i></div><div><span>Actors</span><strong><?= (int) $stats['users'] ?></strong></div></article>
        <article class="stat-card"><div class="stat-icon bg-sky"><i class="fas fa-clock"></i></div><div><span>Latest</span><strong><?= !empty($stats['latest']) ? htmlspecialchars(date('H:i', strtotime($stats['latest']))) : '-' ?></strong></div></article>
    </section>

    <section class="work-grid">
        <div class="module-heading" id="audit-module">
            <h2>Data Privacy Audit Logger</h2>
            <p>Admin-only privacy audit trail for account activity, clinical records, and system changes pulled directly from the audit log database table.</p>
        </div>

        <div class="panel full" id="audit">
            <div class="panel-head"><div><h2>Audit Trail</h2><small>Latest 100 recorded privacy and system events.</small></div><span class="badge"><?= count($logs) ?> shown</span></div>
            <label class="search" style="max-width:none; margin-bottom:14px;"><i class="fas fa-search"></i><input id="auditSearch" type="search" placeholder="Search users, actions, details"></label>
            <div class="table-scroll">
                <?php if (empty($logs)): ?><div class="empty">No audit log records yet.</div><?php else: ?>
                <table><thead><tr><th>Actor</th><th>Action</th><th>Entity</th><th>Details</th><th>Time</th></tr></thead><tbody>
                <?php foreach ($logs as $log): $actionClass = strtolower($log['action'] ?? 'activity'); ?>
                    <tr class="audit-row">
                        <td><div class="actor"><span class="avatar"><?= htmlspecialchars(strtoupper(substr($log['actor_name'] ?? 'S', 0, 1))) ?></span><div><strong><?= htmlspecialchars($log['actor_name'] ?? 'System') ?></strong><br><small><?= htmlspecialchars($log['actor_email'] ?? '') ?></small></div></div></td>
                        <td><span class="badge <?= htmlspecialchars($actionClass) ?>"><?= htmlspecialchars($log['action'] ?? 'activity') ?></span></td>
                        <td><?= htmlspecialchars($log['entity_type'] ?? 'record') ?> #<?= htmlspecialchars((string) ($log['entity_id'] ?? $log['id'] ?? '-')) ?></td>
                        <td><?= htmlspecialchars($log['details'] ?? '') ?></td>
                        <td><?= htmlspecialchars(date('Y-m-d H:i', strtotime($log['created_at'] ?? 'now'))) ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody></table><?php endif; ?>
            </div>
        </div>

        <div class="panel">
            <div class="panel-head"><div><h2>Recent Activity</h2><small>Newest audit events.</small></div><span class="badge"><?= count($recentLogs) ?> items</span></div>
            <div class="feed">
                <?php if (empty($recentLogs)): ?><div class="empty">No recent activities.</div><?php else: ?>
                <?php foreach ($recentLogs as $log): ?>
                    <article class="feed-item">
                        <span class="avatar"><?= htmlspecialchars(strtoupper(substr($log['actor_name'] ?? 'S', 0, 1))) ?></span>
                        <div>
                            <strong><?= htmlspecialchars($log['actor_name'] ?? 'System') ?> <span class="muted"><?= htmlspecialchars(date('H:i', strtotime($log['created_at'] ?? 'now'))) ?></span></strong>
                            <p><?= htmlspecialchars($log['details'] ?? $log['action'] ?? 'Audit activity recorded.') ?></p>
                        </div>
                    </article>
                <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>
<?php }

function renderReferralWorkspace($data) {
    $referrals = $data['referrals'] ?? [];
    ?>
    <section class="grid">
        <div class="panel full">
            <div class="panel-head">
                <div>
                    <h2>سير عمل الإحالات البيطرية</h2>
                    <small>Veterinary Referrals Workflow</small>
                </div>
                <span class="badge"><?= count($referrals) ?> referrals</span>
            </div>
            <p style="margin:0 0 14px; color:var(--muted); line-height:1.8; font-weight:700; direction:rtl;">
                إدارة النقل الآمن للسجلات الطبية بين العيادات عند إحالة الحيوان.
            </p>
            <div class="empty" style="min-height:auto; place-items:start; text-align:right; direction:rtl; margin-bottom:16px;">
                <strong>مثال</strong>
                <span style="display:block; margin-top:8px; line-height:1.8;">
                    الدكتور العام بيحيل بسبوسة لأخصائي قلب. بضغطة يرسل: التاريخ الطبي كامل + الوصفات الحالية + نتائج المختبر + صور الأشعة — كل ده بشكل آمن ومشفر للعيادة التانية.
                </span>
            </div>
            <?php if (empty($referrals)): ?><div class="empty">No referrals recorded yet.</div><?php else: ?>
            <div class="table-scroll"><table><thead><tr><th>Pet</th><th>Specialty</th><th>Sender</th><th>Receiver</th><th>Status</th><th>Time</th><th>Reason</th><th>Action</th></tr></thead><tbody>
            <?php foreach ($referrals as $referral): $referralModalId = 'editReferral' . (int) $referral['id']; ?>
                <tr>
                    <td><?= htmlspecialchars($referral['pet_name'] ?? 'Unknown pet') ?></td>
                    <td><strong><?= htmlspecialchars($referral['specialty'] ?? 'Referral') ?></strong><br><small><?= htmlspecialchars($referral['priority'] ?? 'normal') ?></small></td>
                    <td><?= htmlspecialchars($referral['sender_name'] ?? 'Unassigned') ?></td>
                    <td><?= htmlspecialchars($referral['receiver_name'] ?? 'Unassigned') ?></td>
                    <td><span class="badge <?= htmlspecialchars(strtolower($referral['status'] ?? 'pending')) ?>"><?= htmlspecialchars($referral['status'] ?? 'pending') ?></span></td>
                    <td><?= htmlspecialchars(date('Y-m-d H:i', strtotime($referral['requested_at'] ?? 'now'))) ?></td>
                    <td><?= htmlspecialchars($referral['reason'] ?? '') ?></td>
                    <td><button class="action-btn" type="button" data-modal-target="<?= htmlspecialchars($referralModalId) ?>"><i class="fas fa-pen"></i> Edit</button></td>
                </tr>
            <?php endforeach; ?>
            </tbody></table></div><?php endif; ?>
        </div>
    </section>

    <?php renderReferralModals($referrals); ?>

<?php }

function renderReferralModals($referrals) {
    foreach ($referrals as $referral): $referralModalId = 'editReferral' . (int) $referral['id']; ?>
        <div class="modal-backdrop" id="<?= htmlspecialchars($referralModalId) ?>">
            <div class="modal">
                <div class="modal-head"><div><h2>Edit Referral</h2><small><?= htmlspecialchars($referral['pet_name'] ?? 'Unknown pet') ?> from <?= htmlspecialchars($referral['sender_name'] ?? 'Unassigned') ?> to <?= htmlspecialchars($referral['receiver_name'] ?? 'Unassigned') ?></small></div><button class="icon-btn" type="button" data-modal-close><i class="fas fa-xmark"></i></button></div>
                <form method="post" class="form-grid">
                    <input type="hidden" name="action" value="update_referral">
                    <input type="hidden" name="referral_id" value="<?= (int) $referral['id'] ?>">
                    <div class="input-group"><label>Specialty</label><input class="form-control" name="specialty" value="<?= htmlspecialchars($referral['specialty'] ?? '') ?>"></div>
                    <div class="input-group"><label>Priority</label><select class="form-control" name="priority"><?php renderOptions(['normal', 'urgent', 'critical'], $referral['priority'] ?? 'normal'); ?></select></div>
                    <div class="input-group"><label>Status</label><select class="form-control" name="status"><?php renderOptions(['pending', 'accepted', 'rejected', 'completed'], $referral['status'] ?? 'pending'); ?></select></div>
                    <div class="input-group full"><label>Reason</label><textarea class="form-control" name="reason"><?= htmlspecialchars($referral['reason'] ?? '') ?></textarea></div>
                    <div class="input-group full"><label>Notes</label><textarea class="form-control" name="notes"><?= htmlspecialchars($referral['notes'] ?? '') ?></textarea></div>
                    <button class="action-btn primary" type="submit"><i class="fas fa-floppy-disk"></i> Save Changes</button>
                </form>
            </div>
        </div>
    <?php endforeach;
}
?>
<?php

function renderReportBars($title, $rows, $labelKey = 'name') { ?>
    <div class="panel">
        <div class="panel-head"><div><h2><?= htmlspecialchars($title) ?></h2><small>Database analytics</small></div></div>
        <?php if (empty($rows)): ?><div class="empty">No analytics yet.</div><?php else: ?>
        <?php $max = max(array_map(fn($r) => (int) ($r['total'] ?? 0), $rows)) ?: 1; ?>
        <div class="bars">
            <?php foreach ($rows as $row): $total = (int) ($row['total'] ?? 0); $label = $row[$labelKey] ?? $row['name'] ?? 'Unknown'; ?>
                <div class="bar-row"><strong><?= htmlspecialchars((string) $label) ?></strong><div class="bar-track"><div class="bar-fill" style="width: <?= (int) round(($total / $max) * 100) ?>%;"></div></div><span class="badge"><?= $total ?></span></div>
            <?php endforeach; ?>
        </div><?php endif; ?>
    </div>
<?php }

function renderOptions($options, $selected) {
    foreach ($options as $option) {
        $isSelected = (string) $selected === (string) $option ? ' selected' : '';
        echo '<option value="' . htmlspecialchars($option) . '"' . $isSelected . '>' . htmlspecialchars($option) . '</option>';
    }
}
