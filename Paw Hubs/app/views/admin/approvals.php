<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Approvals | Paw Hubs</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root { --teal:#6BB5A8; --green:#9BC870; --olive:#CAD7A5; --mint:#C8E4D6; --sky:#94CDD3; --ink:#2f4f4f; --muted:#718096; --line:#d8ebe5; --soft:#f5faf8; --panel:#fff; --danger:#e53e3e; }
        * { box-sizing:border-box; } body { margin:0; min-height:100vh; padding:34px; font-family:'Outfit',sans-serif; color:var(--ink); background:linear-gradient(135deg,var(--mint),#fff 45%,var(--sky)); }
        .app-frame { max-width:1480px; min-height:calc(100vh - 68px); margin:0 auto; display:grid; grid-template-columns:270px 1fr; background:rgba(255,255,255,.92); border:1px solid var(--line); border-radius:28px; overflow:hidden; box-shadow:0 30px 80px rgba(47,79,79,.14); }
        .sidebar { background:#fff; border-right:1px solid var(--line); padding:28px 22px; display:flex; flex-direction:column; gap:28px; }
        .brand { display:flex; align-items:center; gap:12px; color:var(--teal); font-size:22px; font-weight:800; } .brand i,.stat-icon { display:grid; place-items:center; } .brand i { width:44px; height:44px; border-radius:14px; background:var(--mint); }
        .menu-label { color:var(--muted); font-size:12px; font-weight:700; margin:0 0 10px; } .menu { display:grid; gap:8px; } .menu a { min-height:44px; display:flex; align-items:center; gap:12px; padding:0 14px; border-radius:12px; color:var(--ink); text-decoration:none; font-weight:700; font-size:14px; } .menu a.active,.menu a:hover { background:var(--mint); color:#4f9186; } .menu a i { width:20px; text-align:center; color:var(--teal); } .sidebar-footer { margin-top:auto; }
        .content { padding:26px; background:#f8fbfa; } .topbar,.panel,.stat-card { background:var(--panel); border:1px solid var(--line); border-radius:18px; box-shadow:0 18px 38px rgba(107,181,168,.08); }
        .topbar { min-height:70px; display:flex; justify-content:space-between; align-items:center; gap:16px; padding:14px 18px; margin-bottom:22px; }
        .search { flex:1; max-width:560px; height:46px; display:flex; align-items:center; gap:12px; padding:0 16px; border:1px solid var(--line); border-radius:14px; background:var(--soft); color:var(--muted); } .search input { width:100%; border:0; outline:0; background:transparent; font:inherit; }
        .action-btn { min-height:44px; padding:0 16px; border:1px solid var(--line); border-radius:13px; background:#fff; color:var(--ink); font-weight:800; display:inline-flex; align-items:center; justify-content:center; gap:10px; text-decoration:none; cursor:pointer; } .action-btn.primary { background:var(--teal); color:#fff; border-color:transparent; }
        .page-head { display:flex; justify-content:space-between; gap:18px; align-items:flex-end; margin:4px 0 20px; } .page-head h1 { margin:0; font-size:32px; } .page-head p { margin:7px 0 0; color:var(--muted); max-width:760px; line-height:1.55; }
        .role-pill,.badge { border-radius:999px; padding:8px 12px; background:var(--mint); color:#4f9186; font-size:12px; font-weight:800; white-space:nowrap; text-transform:capitalize; }
        .stats { display:grid; grid-template-columns:repeat(4,minmax(140px,1fr)); gap:16px; margin-bottom:18px; } .stat-card { min-height:128px; padding:18px; display:flex; flex-direction:column; justify-content:space-between; } .stat-icon { width:42px; height:42px; border-radius:14px; font-size:18px; }
        .bg-teal { background:var(--mint); color:#4f9186; } .bg-green { background:var(--green); color:#fff; } .bg-olive { background:var(--olive); color:#4f6f35; } .bg-sky { background:var(--sky); color:#fff; } .stat-card span,.panel small { color:var(--muted); font-weight:700; } .stat-card span { font-size:13px; } .stat-card strong { display:block; margin-top:5px; font-size:28px; }
        .grid { display:grid; grid-template-columns:1fr; gap:18px; } .panel { padding:20px; min-width:0; } .panel-head { display:flex; align-items:center; justify-content:space-between; gap:14px; margin-bottom:16px; } .panel h2 { margin:0; font-size:20px; }
        .notice { border-radius:16px; padding:15px 17px; margin-bottom:16px; line-height:1.6; font-weight:700; } .notice.success { background:#e6fffa; color:#155e75; border:1px solid #b2f5ea; } .notice.error { background:#fff5f5; color:#742a2a; border:1px solid #fed7d7; }
        .table-scroll { overflow-x:auto; } table { width:100%; border-collapse:collapse; font-size:14px; } th,td { padding:13px 10px; border-bottom:1px solid var(--line); text-align:left; vertical-align:top; } th { color:var(--muted); font-size:12px; text-transform:uppercase; }
        .inline-actions { display:flex; flex-wrap:wrap; gap:8px; } .form-control { width:100%; border:1px solid var(--line); border-radius:14px; padding:10px 12px; background:#fff; font:inherit; color:var(--ink); }
        .badge.approved,.badge.completed { background:var(--green); color:#fff; } .badge.pending { background:var(--olive); color:#4f6f35; } .badge.rejected,.badge.critical { background:#fff5f5; color:var(--danger); }
        .empty { min-height:130px; display:grid; place-items:center; border:1px dashed var(--line); border-radius:14px; color:var(--muted); background:var(--soft); text-align:center; padding:16px; }
        @media (max-width:1150px) { body { padding:16px; } .app-frame { grid-template-columns:1fr; } .sidebar { display:none; } .stats { grid-template-columns:1fr; } }
    </style>
</head>
<body>
<?php
$workflowRequests = $workflowRequests ?? [];
$vetPermissions = $vetPermissions ?? [];
$pendingRequests = count(array_filter($workflowRequests, fn($row) => strtolower($row['request_status'] ?? '') === 'pending'));
$approvedRequests = count(array_filter($workflowRequests, fn($row) => strtolower($row['request_status'] ?? '') === 'approved'));
$rejectedRequests = count(array_filter($workflowRequests, fn($row) => strtolower($row['request_status'] ?? '') === 'rejected'));
?>
<div class="app-frame">
    <aside class="sidebar">
        <div class="brand"><i class="fas fa-user-tie"></i><span>Paw Admin</span></div>
        <div><p class="menu-label">Admin Dashboard</p><nav class="menu"><a href="index.php?url=admin/index"><i class="fas fa-gauge-high"></i> Main Dashboard</a><a href="index.php?url=admin/users"><i class="fas fa-users"></i> User Management</a><a href="index.php?url=admin/staff"><i class="fas fa-user-nurse"></i> Staff Scheduling</a><a href="index.php?url=admin/reports"><i class="fas fa-chart-line"></i> Reports</a></nav></div>
        <div><p class="menu-label">Clinical</p><nav class="menu"><a href="index.php?url=admin/surgery"><i class="fas fa-briefcase-medical"></i> Surgery Manager</a><a href="index.php?url=admin/labHub"><i class="fas fa-vial-circle-check"></i> Lab Hub</a><a href="index.php?url=admin/referrals"><i class="fas fa-share-nodes"></i> Referrals</a><a href="index.php?url=admin/privacyAudit"><i class="fas fa-shield-halved"></i> Privacy Audit</a><a class="active" href="index.php?url=admin/approvals"><i class="fas fa-user-check"></i> Vet Approvals</a></nav></div>
        <div class="sidebar-footer"><nav class="menu"><a href="index.php?url=home/index"><i class="fas fa-home"></i> Home</a><a href="index.php?url=auth/logout"><i class="fas fa-arrow-right-from-bracket"></i> Logout</a></nav></div>
    </aside>
    <main class="content">
        <div class="topbar"><label class="search"><i class="fas fa-search"></i><input type="search" placeholder="Search vet approvals and permissions"></label><a class="action-btn" href="index.php?url=admin/clinical"><i class="fas fa-stethoscope"></i> Clinical Workspace</a></div>
        <header class="page-head"><div><h1>Vet Approval Center</h1><p>Review clinical workflow requests coming from vets and control each vet's access mode per action type.</p></div><span class="role-pill">Admin only</span></header>
        <?php if (!empty($message)): ?><div class="notice success"><?= htmlspecialchars($message) ?></div><?php endif; ?>
        <?php if (!empty($errors)): ?><div class="notice error"><?= htmlspecialchars(implode(' ', $errors)) ?></div><?php endif; ?>
        <section class="stats">
            <article class="stat-card"><div class="stat-icon bg-teal"><i class="fas fa-list-check"></i></div><div><span>Total Requests</span><strong><?= count($workflowRequests) ?></strong></div></article>
            <article class="stat-card"><div class="stat-icon bg-olive"><i class="fas fa-hourglass-half"></i></div><div><span>Pending</span><strong><?= $pendingRequests ?></strong></div></article>
            <article class="stat-card"><div class="stat-icon bg-green"><i class="fas fa-circle-check"></i></div><div><span>Approved</span><strong><?= $approvedRequests ?></strong></div></article>
            <article class="stat-card"><div class="stat-icon bg-sky"><i class="fas fa-sliders"></i></div><div><span>Permission Rules</span><strong><?= count($vetPermissions) ?></strong></div></article>
        </section>
        <section class="grid">
            <div class="panel">
                <div class="panel-head"><div><h2>Clinical Workflow Requests</h2><small>Approve or reject vet-side actions</small></div><span class="badge"><?= $pendingRequests ?> pending</span></div>
                <?php if (empty($workflowRequests)): ?><div class="empty">No workflow requests yet.</div><?php else: ?><div class="table-scroll"><table><thead><tr><th>Action</th><th>Pet</th><th>Vet</th><th>Owner</th><th>Owner Status</th><th>Admin Status</th><th>Final</th><th>Action</th></tr></thead><tbody><?php foreach ($workflowRequests as $request): ?><tr><td><strong><?= htmlspecialchars($request['action_title'] ?? 'Workflow') ?></strong><br><small><?= htmlspecialchars($request['requester_name'] ?? 'Requester') ?></small></td><td><?= htmlspecialchars($request['pet_name'] ?? 'Unknown pet') ?></td><td><?= htmlspecialchars($request['vet_name'] ?? 'Unassigned') ?></td><td><?= htmlspecialchars($request['owner_name'] ?? 'Owner') ?></td><td><span class="badge <?= htmlspecialchars(strtolower($request['owner_status'] ?? 'not_needed')) ?>"><?= htmlspecialchars($request['owner_status'] ?? 'not_needed') ?></span></td><td><span class="badge <?= htmlspecialchars(strtolower($request['admin_status'] ?? 'not_needed')) ?>"><?= htmlspecialchars($request['admin_status'] ?? 'not_needed') ?></span></td><td><span class="badge <?= htmlspecialchars(strtolower($request['request_status'] ?? 'pending')) ?>"><?= htmlspecialchars($request['request_status'] ?? 'pending') ?></span></td><td><?php if (strtolower($request['request_status'] ?? '') === 'pending' && strtolower($request['admin_status'] ?? '') === 'pending'): ?><div class="inline-actions"><form method="post"><input type="hidden" name="action" value="review_clinical_request"><input type="hidden" name="request_id" value="<?= (int) $request['id'] ?>"><input type="hidden" name="decision" value="approve"><button class="action-btn primary" type="submit">Approve</button></form><form method="post"><input type="hidden" name="action" value="review_clinical_request"><input type="hidden" name="request_id" value="<?= (int) $request['id'] ?>"><input type="hidden" name="decision" value="reject"><button class="action-btn" type="submit">Reject</button></form></div><?php else: ?><span class="badge"><?= htmlspecialchars($request['request_status'] ?? 'closed') ?></span><?php endif; ?></td></tr><?php endforeach; ?></tbody></table></div><?php endif; ?>
            </div>
            <div class="panel">
                <div class="panel-head"><div><h2>Vet Action Permissions</h2><small>Both per-vet and per-action</small></div><span class="badge"><?= count($vetPermissions) ?> rules</span></div>
                <?php if (empty($vetPermissions)): ?><div class="empty">No vet permissions yet.</div><?php else: ?><div class="table-scroll"><table><thead><tr><th>Vet</th><th>Action</th><th>Mode</th><th>Update</th></tr></thead><tbody><?php foreach ($vetPermissions as $permission): ?><tr><td><strong><?= htmlspecialchars($permission['vet_name'] ?? 'Vet') ?></strong><br><small><?= htmlspecialchars($permission['specialization'] ?? 'General') ?></small></td><td><?= htmlspecialchars(ucwords(str_replace('_', ' ', $permission['action_key'] ?? 'action'))) ?></td><td><span class="badge"><?= htmlspecialchars(str_replace('_', ' ', $permission['access_mode'] ?? 'request_admin')) ?></span></td><td><form method="post" class="inline-actions"><input type="hidden" name="action" value="update_vet_permission"><input type="hidden" name="permission_id" value="<?= (int) $permission['id'] ?>"><select class="form-control" name="access_mode"><option value="request_user"<?= ($permission['access_mode'] ?? '') === 'request_user' ? ' selected' : '' ?>>request_user</option><option value="request_admin"<?= ($permission['access_mode'] ?? '') === 'request_admin' ? ' selected' : '' ?>>request_admin</option><option value="approve_user"<?= ($permission['access_mode'] ?? '') === 'approve_user' ? ' selected' : '' ?>>approve_user</option></select><button class="action-btn" type="submit">Save</button></form></td></tr><?php endforeach; ?></tbody></table></div><?php endif; ?>
            </div>
        </section>
    </main>
</div>
<?php require_once '../app/views/partials/theme_toggle.php'; ?>
</body>
</html>
