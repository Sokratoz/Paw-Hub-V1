<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Referral Security | Paw Hubs</title>
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
        .panel {
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
            max-width: 820px;
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

        .grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
        }

        .panel {
            padding: 20px;
            min-width: 0;
        }

        .panel.full { grid-column: 1 / -1; }
        .panel-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            margin-bottom: 16px;
        }

        .panel h2 { margin: 0; font-size: 20px; }
        .panel small,
        td small { color: var(--muted); font-weight: 700; }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 14px;
        }

        .input-group { display: grid; gap: 8px; }
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

        .table-scroll { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; font-size: 14px; }
        th, td { padding: 13px 10px; border-bottom: 1px solid var(--line); text-align: left; vertical-align: top; }
        th { color: var(--muted); font-size: 12px; text-transform: uppercase; }

        .notice { border-radius: 16px; padding: 15px 17px; margin-bottom: 16px; line-height: 1.6; font-weight: 700; }
        .notice.success { background: #e6fffa; color: #155e75; border: 1px solid #b2f5ea; }
        .notice.error { background: #fff5f5; color: #742a2a; border: 1px solid #fed7d7; }
        .empty { min-height: 130px; display: grid; place-items: center; border: 1px dashed var(--line); border-radius: 14px; color: var(--muted); background: var(--soft); text-align: center; padding: 16px; }
        .badge.active, .badge.approved, .badge.accepted { background: var(--green); color: #fff; }
        .badge.rejected, .badge.denied, .badge.failed, .badge.suspended, .badge.expired { background: #fff5f5; color: var(--danger); }
        .badge.pending, .badge.transfer, .badge.view { background: var(--olive); color: #4f6f35; }

        @media (max-width: 1150px) {
            body { padding: 16px; }
            .app-frame { grid-template-columns: 1fr; }
            .sidebar { display: none; }
            .grid { grid-template-columns: 1fr; }
            .panel.full { grid-column: auto; }
        }

        @media (max-width: 640px) {
            .content { padding: 16px; }
            .topbar,
            .page-head { align-items: stretch; flex-direction: column; }
            .form-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
<?php
$referrals = $referrals ?? [];
$accessControls = $accessControls ?? [];
$transferLogs = $transferLogs ?? [];
$securityAlerts = $securityAlerts ?? [];
?>
<div class="app-frame">
    <aside class="sidebar">
        <div class="brand"><i class="fas fa-share-nodes"></i><span>Referral Hub</span></div>
        <div>
            <p class="menu-label">Referral Security</p>
            <nav class="menu">
                <a class="active" href="index.php?url=referral/index"><i class="fas fa-share-nodes"></i> Referral Page</a>
                <a href="#access"><i class="fas fa-key"></i> Access Control</a>
                <a href="#transfers"><i class="fas fa-right-left"></i> Transfer Logs</a>
                <a href="#security"><i class="fas fa-triangle-exclamation"></i> Security Monitoring</a>
            </nav>
        </div>
        <div>
            <p class="menu-label">Admin</p>
            <nav class="menu">
                <a href="index.php?url=admin/index"><i class="fas fa-gauge-high"></i> Admin Dashboard</a>
                <a href="index.php?url=audit/index"><i class="fas fa-shield-halved"></i> Audit Logs</a>
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
            <label class="search"><i class="fas fa-search"></i><input type="search" placeholder="Search referrals, transfers, access rules"></label>
            <a class="action-btn" href="index.php?url=admin/index"><i class="fas fa-arrow-left"></i> Back to Admin</a>
        </div>

        <header class="page-head">
            <div>
                <h1>Referral Security Page</h1>
                <p>Referral management, access control, transfer logs, and security monitoring are now grouped here in one dedicated page, separate from Audit Logs.</p>
            </div>
            <span class="role-pill">Admin only</span>
        </header>

        <?php if (!empty($message)): ?><div class="notice success"><?= htmlspecialchars($message) ?></div><?php endif; ?>
        <?php if (!empty($errors)): ?><div class="notice error"><?= htmlspecialchars(implode(' ', $errors)) ?></div><?php endif; ?>

        <section class="grid">
            <div class="panel full" id="referrals">
                <div class="panel-head"><div><h2>Referral Management</h2><small>All referrals with sender, receiver, status, and reason.</small></div><span class="badge"><?= count($referrals) ?> referrals</span></div>
                <?php if (empty($referrals)): ?><div class="empty">No referrals recorded yet.</div><?php else: ?>
                <div class="table-scroll"><table><thead><tr><th>Pet</th><th>Specialty</th><th>Sender</th><th>Receiver</th><th>Status</th><th>Time</th><th>Reason</th></tr></thead><tbody>
                <?php foreach ($referrals as $referral): ?>
                    <tr>
                        <td><?= htmlspecialchars($referral['pet_name'] ?? 'Unknown pet') ?></td>
                        <td><strong><?= htmlspecialchars($referral['specialty'] ?? 'Referral') ?></strong><br><small><?= htmlspecialchars($referral['priority'] ?? 'normal') ?></small></td>
                        <td><?= htmlspecialchars($referral['sender_name'] ?? 'Unassigned') ?></td>
                        <td><?= htmlspecialchars($referral['receiver_name'] ?? 'Unassigned') ?></td>
                        <td><span class="badge <?= htmlspecialchars(strtolower($referral['status'] ?? 'pending')) ?>"><?= htmlspecialchars($referral['status'] ?? 'pending') ?></span></td>
                        <td><?= htmlspecialchars(date('Y-m-d H:i', strtotime($referral['requested_at'] ?? 'now'))) ?></td>
                        <td><?= htmlspecialchars($referral['reason'] ?? '') ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody></table></div><?php endif; ?>
            </div>

            <div class="panel" id="access">
                <div class="panel-head"><div><h2>Access Control</h2><small>Define file visibility and clinic permissions.</small></div></div>
                <form method="post" class="form-grid">
                    <input type="hidden" name="action" value="add_access_rule">
                    <div class="input-group"><label>Role</label><select class="form-control" name="subject_role"><option>admin</option><option>vet</option><option>service_provider</option><option>pet_owner</option></select></div>
                    <div class="input-group"><label>Resource</label><select class="form-control" name="resource_type"><option>medical_files</option><option>lab_reports</option><option>referrals</option><option>pet_profiles</option></select></div>
                    <div class="input-group"><label>Clinic Scope</label><input class="form-control" name="clinic_scope" placeholder="Cardiology Clinic"></div>
                    <div class="input-group"><label>Permission</label><select class="form-control" name="permission_level"><option>view</option><option>edit</option><option>transfer</option><option>full</option></select></div>
                    <div class="input-group"><label>Duration</label><input class="form-control" name="access_duration" placeholder="24 hours / 7 days"></div>
                    <div class="input-group"><label>Status</label><select class="form-control" name="status"><option>active</option><option>suspended</option><option>expired</option></select></div>
                    <button class="action-btn primary" type="submit"><i class="fas fa-key"></i> Save Rule</button>
                </form>
            </div>

            <div class="panel">
                <div class="panel-head"><div><h2>Current Permissions</h2><small>Stored access rules.</small></div><span class="badge"><?= count($accessControls) ?> rules</span></div>
                <?php if (empty($accessControls)): ?><div class="empty">No access rules yet.</div><?php else: ?>
                <div class="table-scroll"><table><thead><tr><th>Role</th><th>Resource</th><th>Scope</th><th>Permission</th><th>Duration</th><th>Status</th></tr></thead><tbody>
                <?php foreach ($accessControls as $rule): ?>
                    <tr><td><?= htmlspecialchars($rule['subject_role']) ?></td><td><?= htmlspecialchars($rule['resource_type']) ?></td><td><?= htmlspecialchars($rule['clinic_scope'] ?? 'All clinics') ?></td><td><?= htmlspecialchars($rule['permission_level']) ?></td><td><?= htmlspecialchars($rule['access_duration'] ?? '-') ?></td><td><span class="badge <?= htmlspecialchars(strtolower($rule['status'] ?? 'active')) ?>"><?= htmlspecialchars($rule['status'] ?? 'active') ?></span></td></tr>
                <?php endforeach; ?>
                </tbody></table></div><?php endif; ?>
            </div>

            <div class="panel full" id="transfers">
                <div class="panel-head"><div><h2>Transfer Logs</h2><small>Data movement related to referrals and files.</small></div><span class="badge"><?= count($transferLogs) ?> transfers</span></div>
                <?php if (empty($transferLogs)): ?><div class="empty">No transfer logs yet.</div><?php else: ?>
                <div class="table-scroll"><table><thead><tr><th>Sender</th><th>Receiver</th><th>File / Entity</th><th>Action</th><th>Time</th><th>Details</th></tr></thead><tbody>
                <?php foreach ($transferLogs as $log): ?>
                    <tr><td><?= htmlspecialchars($log['sender_name'] ?? 'System') ?></td><td><?= htmlspecialchars($log['entity_type'] ?? 'Receiver') ?></td><td><?= htmlspecialchars(($log['entity_type'] ?? 'file') . '#' . ($log['entity_id'] ?? $log['id'])) ?></td><td><span class="badge <?= htmlspecialchars(strtolower($log['action'] ?? 'transfer')) ?>"><?= htmlspecialchars($log['action'] ?? 'transfer') ?></span></td><td><?= htmlspecialchars(date('Y-m-d H:i', strtotime($log['created_at'] ?? 'now'))) ?></td><td><?= htmlspecialchars($log['details'] ?? '') ?></td></tr>
                <?php endforeach; ?>
                </tbody></table></div><?php endif; ?>
            </div>

            <div class="panel full" id="security">
                <div class="panel-head"><div><h2>Security Monitoring</h2><small>Unauthorized access, abnormal download, and permission alerts.</small></div><span class="badge"><?= count($securityAlerts) ?> alerts</span></div>
                <?php if (empty($securityAlerts)): ?><div class="empty">No security alerts found.</div><?php else: ?>
                <div class="table-scroll"><table><thead><tr><th>Actor</th><th>Alert</th><th>Entity</th><th>IP</th><th>Time</th><th>Details</th></tr></thead><tbody>
                <?php foreach ($securityAlerts as $alert): ?>
                    <tr><td><?= htmlspecialchars($alert['actor_name'] ?? 'System') ?></td><td><span class="badge <?= htmlspecialchars(strtolower($alert['action'] ?? 'alert')) ?>"><?= htmlspecialchars($alert['action'] ?? 'alert') ?></span></td><td><?= htmlspecialchars($alert['entity_type'] ?? 'system') ?> #<?= htmlspecialchars((string) ($alert['entity_id'] ?? $alert['id'] ?? '-')) ?></td><td><?= htmlspecialchars($alert['ip_address'] ?? '-') ?></td><td><?= htmlspecialchars(date('Y-m-d H:i', strtotime($alert['created_at'] ?? 'now'))) ?></td><td><?= htmlspecialchars($alert['details'] ?? '') ?></td></tr>
                <?php endforeach; ?>
                </tbody></table></div><?php endif; ?>
            </div>
        </section>
    </main>
</div>
<?php require_once '../app/views/partials/theme_toggle.php'; ?>
</body>
</html>
