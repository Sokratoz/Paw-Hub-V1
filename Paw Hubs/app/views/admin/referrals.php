<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Veterinary Referrals Workflow | Paw Hubs</title>
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
            grid-template-columns: repeat(4, minmax(140px, 1fr));
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

        .work-grid { display: grid; grid-template-columns: 1.35fr 0.85fr; gap: 18px; }
        .panel { padding: 20px; min-width: 0; }
        .panel.full { grid-column: 1 / -1; }
        .module-heading {
            grid-column: 1 / -1;
            padding: 18px 20px;
            border: 1px solid var(--line);
            border-radius: 18px;
            background: #ffffff;
            box-shadow: 0 18px 38px rgba(107, 181, 168, 0.08);
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

        .notice { border-radius: 16px; padding: 15px 17px; margin-bottom: 16px; line-height: 1.6; font-weight: 700; }
        .notice.success { background: #e6fffa; color: #155e75; border: 1px solid #b2f5ea; }
        .notice.error { background: #fff5f5; color: #742a2a; border: 1px solid #fed7d7; }
        .empty { min-height: 130px; display: grid; place-items: center; border: 1px dashed var(--line); border-radius: 14px; color: var(--muted); background: var(--soft); text-align: center; padding: 16px; }

        .table-scroll { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; font-size: 14px; }
        th, td { padding: 13px 10px; border-bottom: 1px solid var(--line); text-align: left; vertical-align: top; }
        th { color: var(--muted); font-size: 12px; text-transform: uppercase; }

        .shortcut-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 14px; }
        .shortcut {
            min-height: 104px;
            border: 1px solid var(--line);
            border-radius: 14px;
            padding: 16px;
            display: flex;
            align-items: flex-start;
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
        .shortcut span { color: var(--muted); font-size: 13px; font-weight: 700; line-height: 1.6; }

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
        .avatar {
            width: 34px;
            height: 34px;
            border-radius: 12px;
            background: var(--mint);
            color: #4f9186;
            font-weight: 900;
        }
        .muted { color: var(--muted); font-weight: 700; }

        .badge.approved, .badge.available, .badge.completed, .badge.accepted { background: var(--green); color: #fff; }
        .badge.rejected, .badge.unavailable, .badge.maintenance, .badge.critical { background: #fff5f5; color: var(--danger); }
        .badge.scheduled, .badge.pending, .badge.reserved { background: var(--olive); color: #4f6f35; }

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

        @media (max-width: 1150px) {
            body { padding: 16px; }
            .app-frame { grid-template-columns: 1fr; }
            .sidebar { display: none; }
            .stats, .work-grid, .shortcut-grid { grid-template-columns: 1fr; }
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
$referrals = $referralData['referrals'] ?? [];
$totalReferrals = count($referrals);
$pendingCount = count(array_filter($referrals, fn($referral) => strtolower($referral['status'] ?? '') === 'pending'));
$acceptedCount = count(array_filter($referrals, fn($referral) => strtolower($referral['status'] ?? '') === 'accepted'));
$criticalCount = count(array_filter($referrals, fn($referral) => strtolower($referral['priority'] ?? '') === 'critical'));
$priorityFeed = array_values(array_filter($referrals, fn($referral) => in_array(strtolower($referral['priority'] ?? ''), ['urgent', 'critical'], true)));
?>
<div class="app-frame">
    <aside class="sidebar">
        <div class="brand"><i class="fas fa-user-tie"></i><span>Paw Admin</span></div>
        <div>
            <p class="menu-label">Admin Dashboard</p>
            <nav class="menu">
                <a href="index.php?url=admin/index"><i class="fas fa-gauge-high"></i> Main Dashboard</a>
                <a href="index.php?url=admin/users"><i class="fas fa-users"></i> User Management</a>
                <a href="index.php?url=admin/staff"><i class="fas fa-user-nurse"></i> Staff Scheduling</a>
                <a href="index.php?url=admin/reports"><i class="fas fa-chart-line"></i> Reports</a>
            </nav>
        </div>
        <div>
            <p class="menu-label">Clinical</p>
            <nav class="menu">
                <a href="index.php?url=admin/surgery"><i class="fas fa-briefcase-medical"></i> Surgery Manager</a>
                <a href="index.php?url=admin/labHub"><i class="fas fa-vial-circle-check"></i> Lab Hub</a>
                <a class="active" href="index.php?url=admin/referrals"><i class="fas fa-share-nodes"></i> Referrals</a>
                <a href="index.php?url=admin/privacyAudit"><i class="fas fa-shield-halved"></i> Privacy Audit</a>
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
            <label class="search"><i class="fas fa-search"></i><input type="search" placeholder="Search referrals, clinics, specialties"></label>
            <a class="action-btn" href="index.php?url=admin/clinical"><i class="fas fa-stethoscope"></i> Clinical Workspace</a>
        </div>

        <header class="page-head">
            <div>
                <h1>Veterinary Referrals Workflow</h1>
                <p>Manage secure referral handoffs, review priority cases, and keep specialty transfers organized in one admin workspace.</p>
            </div>
            <span class="role-pill">Admin only</span>
        </header>

        <?php if (!empty($message)): ?><div class="notice success"><?= htmlspecialchars($message) ?></div><?php endif; ?>
        <?php if (!empty($errors)): ?><div class="notice error"><?= htmlspecialchars(implode(' ', $errors)) ?></div><?php endif; ?>

        <section class="stats">
            <article class="stat-card"><div class="stat-icon bg-teal"><i class="fas fa-share-nodes"></i></div><div><span>Total Referrals</span><strong><?= $totalReferrals ?></strong></div></article>
            <article class="stat-card"><div class="stat-icon bg-olive"><i class="fas fa-hourglass-half"></i></div><div><span>Pending</span><strong><?= $pendingCount ?></strong></div></article>
            <article class="stat-card"><div class="stat-icon bg-green"><i class="fas fa-circle-check"></i></div><div><span>Accepted</span><strong><?= $acceptedCount ?></strong></div></article>
            <article class="stat-card"><div class="stat-icon bg-sky"><i class="fas fa-triangle-exclamation"></i></div><div><span>Critical Priority</span><strong><?= $criticalCount ?></strong></div></article>
        </section>

        <section class="work-grid">
            <div class="module-heading">
                <h2>Veterinary Referrals Workflow</h2>
                <p>Secure medical handoff between clinics with specialty routing, priority tracking, and clear status updates for every case.</p>
            </div>

            <div class="panel full">
                <div class="panel-head">
                    <div>
                        <h2>Referral Transfer Overview</h2>
                        <small>Referral transfer overview</small>
                    </div>
                    <span class="badge"><?= $totalReferrals ?> referrals</span>
                </div>

                <div class="shortcut-grid" style="margin-bottom:18px;">
                    <div class="shortcut">
                        <i class="fas fa-lock"></i>
                        <div>
                            <strong>Secure clinical transfer</strong>
                            <span>Move medical records between clinics with clear ownership, tracked routing, and safer status visibility.</span>
                        </div>
                    </div>
                    <div class="shortcut">
                        <i class="fas fa-stethoscope"></i>
                        <div>
                            <strong>Example workflow</strong>
                            <span>A general vet sends the pet history, prescriptions, lab results, and imaging to a specialist clinic in one organized handoff.</span>
                        </div>
                    </div>
                </div>

                <?php if (empty($referrals)): ?>
                    <div class="empty">No referrals recorded yet.</div>
                <?php else: ?>
                    <div class="table-scroll">
                        <table>
                            <thead>
                                <tr><th>Pet</th><th>Specialty</th><th>Sender</th><th>Receiver</th><th>Status</th><th>Time</th><th>Reason</th><th>Action</th></tr>
                            </thead>
                            <tbody>
                            <?php foreach ($referrals as $referral): $referralModalId = 'editReferral' . (int) $referral['id']; ?>
                                <tr>
                                    <td><strong><?= htmlspecialchars($referral['pet_name'] ?? 'Unknown pet') ?></strong></td>
                                    <td><?= htmlspecialchars($referral['specialty'] ?? 'Referral') ?><br><small><?= htmlspecialchars(ucfirst($referral['priority'] ?? 'normal')) ?> priority</small></td>
                                    <td><?= htmlspecialchars($referral['sender_name'] ?? 'Unassigned') ?></td>
                                    <td><?= htmlspecialchars($referral['receiver_name'] ?? 'Unassigned') ?></td>
                                    <td><span class="badge <?= htmlspecialchars(strtolower($referral['status'] ?? 'pending')) ?>"><?= htmlspecialchars($referral['status'] ?? 'pending') ?></span></td>
                                    <td><?= htmlspecialchars(date('Y-m-d H:i', strtotime($referral['requested_at'] ?? 'now'))) ?></td>
                                    <td><?= htmlspecialchars($referral['reason'] ?? 'No reason provided') ?></td>
                                    <td><button class="action-btn" type="button" data-modal-target="<?= htmlspecialchars($referralModalId) ?>"><i class="fas fa-pen"></i> Edit</button></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>

            <div class="panel">
                <div class="panel-head">
                    <div>
                        <h2>Priority Queue</h2>
                        <small>Urgent and critical handoffs</small>
                    </div>
                    <span class="badge"><?= count($priorityFeed) ?> flagged</span>
                </div>
                <div class="feed">
                    <?php if (empty($priorityFeed)): ?>
                        <div class="empty">No urgent referrals in queue.</div>
                    <?php else: ?>
                        <?php foreach (array_slice($priorityFeed, 0, 6) as $referral): ?>
                            <article class="feed-item">
                                <span class="avatar"><?= htmlspecialchars(strtoupper(substr($referral['pet_name'] ?? 'P', 0, 1))) ?></span>
                                <div>
                                    <strong><?= htmlspecialchars($referral['pet_name'] ?? 'Unknown pet') ?> <span class="muted"><?= htmlspecialchars(ucfirst($referral['priority'] ?? 'priority')) ?></span></strong>
                                    <p><?= htmlspecialchars(($referral['sender_name'] ?? 'Sender') . ' to ' . ($referral['receiver_name'] ?? 'Receiver')) ?></p>
                                    <p><?= htmlspecialchars($referral['reason'] ?? 'No reason provided') ?></p>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    </main>
</div>

<?php foreach ($referrals as $referral): $referralModalId = 'editReferral' . (int) $referral['id']; ?>
    <div class="modal-backdrop" id="<?= htmlspecialchars($referralModalId) ?>">
        <div class="modal">
            <div class="modal-head">
                <div>
                    <h2>Edit Referral</h2>
                    <small><?= htmlspecialchars($referral['pet_name'] ?? 'Unknown pet') ?> from <?= htmlspecialchars($referral['sender_name'] ?? 'Unassigned') ?> to <?= htmlspecialchars($referral['receiver_name'] ?? 'Unassigned') ?></small>
                </div>
                <button class="icon-btn" type="button" data-modal-close><i class="fas fa-xmark"></i></button>
            </div>
            <form method="post" class="form-grid">
                <input type="hidden" name="action" value="update_referral">
                <input type="hidden" name="referral_id" value="<?= (int) $referral['id'] ?>">
                <div class="input-group"><label>Specialty</label><input class="form-control" name="specialty" value="<?= htmlspecialchars($referral['specialty'] ?? '') ?>"></div>
                <div class="input-group"><label>Priority</label><select class="form-control" name="priority"><option value="normal"<?= ($referral['priority'] ?? '') === 'normal' ? ' selected' : '' ?>>normal</option><option value="urgent"<?= ($referral['priority'] ?? '') === 'urgent' ? ' selected' : '' ?>>urgent</option><option value="critical"<?= ($referral['priority'] ?? '') === 'critical' ? ' selected' : '' ?>>critical</option></select></div>
                <div class="input-group"><label>Status</label><select class="form-control" name="status"><option value="pending"<?= ($referral['status'] ?? '') === 'pending' ? ' selected' : '' ?>>pending</option><option value="accepted"<?= ($referral['status'] ?? '') === 'accepted' ? ' selected' : '' ?>>accepted</option><option value="rejected"<?= ($referral['status'] ?? '') === 'rejected' ? ' selected' : '' ?>>rejected</option><option value="completed"<?= ($referral['status'] ?? '') === 'completed' ? ' selected' : '' ?>>completed</option></select></div>
                <div class="input-group full"><label>Reason</label><textarea class="form-control" name="reason"><?= htmlspecialchars($referral['reason'] ?? '') ?></textarea></div>
                <div class="input-group full"><label>Notes</label><textarea class="form-control" name="notes"><?= htmlspecialchars($referral['notes'] ?? '') ?></textarea></div>
                <button class="action-btn primary" type="submit"><i class="fas fa-floppy-disk"></i> Save Changes</button>
            </form>
        </div>
    </div>
<?php endforeach; ?>

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
</script>
</body>
</html>
