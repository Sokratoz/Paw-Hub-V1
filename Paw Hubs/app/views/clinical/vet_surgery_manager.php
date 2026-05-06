<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surgery Manager | Paw Hubs</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root { --teal:#6BB5A8; --green:#9BC870; --olive:#CAD7A5; --mint:#C8E4D6; --sky:#94CDD3; --ink:#2f4f4f; --muted:#718096; --line:#d8ebe5; --soft:#f5faf8; --panel:#ffffff; --danger:#e53e3e; }
        * { box-sizing:border-box; }
        body { margin:0; min-height:100vh; padding:34px; font-family:'Outfit',sans-serif; color:var(--ink); background:linear-gradient(135deg,var(--mint),#ffffff 45%,var(--sky)); }
        .app-frame { max-width:1480px; min-height:calc(100vh - 68px); margin:0 auto; display:grid; grid-template-columns:270px 1fr; background:rgba(255,255,255,.92); border:1px solid var(--line); border-radius:28px; overflow:hidden; box-shadow:0 30px 80px rgba(47,79,79,.14); }
        .sidebar { background:#ffffff; border-right:1px solid var(--line); padding:28px 22px; display:flex; flex-direction:column; gap:28px; }
        .brand { display:flex; align-items:center; gap:12px; color:var(--teal); font-size:22px; font-weight:800; }
        .brand i,.stat-icon { display:grid; place-items:center; }
        .brand i { width:44px; height:44px; border-radius:14px; background:var(--mint); }
        .menu-label { color:var(--muted); font-size:12px; font-weight:700; margin:0 0 10px; }
        .menu { display:grid; gap:8px; }
        .menu a { min-height:44px; display:flex; align-items:center; gap:12px; padding:0 14px; border-radius:12px; color:var(--ink); text-decoration:none; font-weight:700; font-size:14px; }
        .menu a.active,.menu a:hover { background:var(--mint); color:#4f9186; }
        .menu a i { width:20px; text-align:center; color:var(--teal); }
        .sidebar-footer { margin-top:auto; }
        .content { padding:26px; background:#f8fbfa; }
        .topbar,.panel,.stat-card { background:var(--panel); border:1px solid var(--line); border-radius:18px; box-shadow:0 18px 38px rgba(107,181,168,.08); }
        .topbar { min-height:70px; display:flex; justify-content:space-between; align-items:center; gap:16px; padding:14px 18px; margin-bottom:22px; }
        .search { flex:1; max-width:560px; height:46px; display:flex; align-items:center; gap:12px; padding:0 16px; border:1px solid var(--line); border-radius:14px; background:var(--soft); color:var(--muted); }
        .search input { width:100%; border:0; outline:0; background:transparent; font:inherit; }
        .action-btn { min-height:44px; padding:0 16px; border:1px solid var(--line); border-radius:13px; background:#ffffff; color:var(--ink); font-weight:800; display:inline-flex; align-items:center; justify-content:center; gap:10px; text-decoration:none; cursor:pointer; }
        .action-btn.primary { background:var(--teal); color:#fff; border-color:transparent; }
        .page-head { display:flex; justify-content:space-between; gap:18px; align-items:flex-end; margin:4px 0 20px; }
        .page-head h1 { margin:0; font-size:32px; } .page-head p { margin:7px 0 0; color:var(--muted); max-width:760px; line-height:1.55; }
        .role-pill,.badge { border-radius:999px; padding:8px 12px; background:var(--mint); color:#4f9186; font-size:12px; font-weight:800; white-space:nowrap; text-transform:capitalize; }
        .stats,.two-col,.cards { display:grid; gap:18px; }
        .stats { grid-template-columns:repeat(3,minmax(140px,1fr)); margin-bottom:18px; }
        .two-col { grid-template-columns:repeat(2,minmax(0,1fr)); }
        .cards { grid-template-columns:repeat(2,minmax(0,1fr)); }
        .stat-card { min-height:128px; padding:18px; display:flex; flex-direction:column; justify-content:space-between; }
        .stat-icon { width:42px; height:42px; border-radius:14px; font-size:18px; }
        .bg-teal { background:var(--mint); color:#4f9186; } .bg-green { background:var(--green); color:#fff; } .bg-sky { background:var(--sky); color:#fff; }
        .stat-card span,.panel small,.meta { color:var(--muted); font-weight:700; } .stat-card span { font-size:13px; } .stat-card strong { display:block; margin-top:5px; font-size:28px; }
        .panel { padding:20px; min-width:0; }
        .panel-head { display:flex; align-items:center; justify-content:space-between; gap:14px; margin-bottom:16px; }
        .panel h2 { margin:0; font-size:20px; }
        .table-scroll { overflow-x:auto; } table { width:100%; border-collapse:collapse; font-size:14px; } th,td { padding:13px 10px; border-bottom:1px solid var(--line); text-align:left; vertical-align:top; } th { color:var(--muted); font-size:12px; text-transform:uppercase; }
        .notice { border-radius:16px; padding:15px 17px; margin-bottom:16px; line-height:1.6; font-weight:700; } .notice.success { background:#e6fffa; color:#155e75; border:1px solid #b2f5ea; } .notice.error { background:#fff5f5; color:#742a2a; border:1px solid #fed7d7; }
        .card { border:1px solid var(--line); border-radius:14px; padding:16px; background:#fff; }
        .card strong { display:block; margin-bottom:6px; }
        .form-grid { display:grid; grid-template-columns:repeat(2,minmax(0,1fr)); gap:14px; }
        .input-group { display:grid; gap:8px; } .input-group.full { grid-column:1 / -1; }
        label { color:var(--muted); font-size:13px; font-weight:700; } .form-control { width:100%; border:1px solid var(--line); border-radius:14px; padding:12px 14px; background:#fff; font:inherit; color:var(--ink); } textarea.form-control { min-height:96px; resize:vertical; }
        .badge.approved,.badge.completed { background:var(--green); color:#fff; } .badge.pending,.badge.scheduled { background:var(--olive); color:#4f6f35; } .badge.rejected { background:#fff5f5; color:var(--danger); }
        .empty { min-height:120px; display:grid; place-items:center; border:1px dashed var(--line); border-radius:14px; color:var(--muted); background:var(--soft); text-align:center; padding:16px; }
        @media (max-width:1150px) { body { padding:16px; } .app-frame { grid-template-columns:1fr; } .sidebar { display:none; } .stats,.two-col,.cards,.form-grid { grid-template-columns:1fr; } }
    </style>
</head>
<body>
<?php $workflowRequests = $workflowRequests ?? []; ?>
<div class="app-frame">
    <aside class="sidebar">
        <div class="brand"><i class="fas fa-stethoscope"></i><span>Paw Vet</span></div>
        <div>
            <p class="menu-label">Clinical</p>
            <nav class="menu">
                <a href="index.php?url=clinical/index"><i class="fas fa-chart-pie"></i> Dashboard</a>
                <a class="active" href="index.php?url=clinical/surgeryManager"><i class="fas fa-briefcase-medical"></i> Surgery Manager</a>
                <a href="index.php?url=clinical/labHub"><i class="fas fa-vial-circle-check"></i> Lab Hub</a>
                <a href="index.php?url=clinical/referralsWorkflow"><i class="fas fa-share-nodes"></i> Referrals Workflow</a>
            </nav>
        </div>
    </aside>
    <main class="content">
        <div class="topbar">
            <label class="search"><i class="fas fa-search"></i><input type="search" placeholder="Search procedure cases and approvals"></label>
            <a class="action-btn" href="index.php?url=clinical/index"><i class="fas fa-arrow-left"></i> Dashboard</a>
        </div>
        <header class="page-head">
            <div><h1>Surgery &amp; Procedure Resource Manager</h1><p>Full workspace for procedure cases, vet permissions, and sending surgery requests to admin.</p></div>
            <span class="role-pill">Vet access</span>
        </header>
        <?php if (!empty($message)): ?><div class="notice success"><?= htmlspecialchars($message) ?></div><?php endif; ?>
        <?php if (!empty($errors)): ?><div class="notice error"><?= htmlspecialchars(implode(' ', $errors)) ?></div><?php endif; ?>

        <section class="stats">
            <article class="stat-card"><div class="stat-icon bg-teal"><i class="fas fa-briefcase-medical"></i></div><div><span>Procedures</span><strong><?= (int) ($stats['procedures'] ?? 0) ?></strong></div></article>
            <article class="stat-card"><div class="stat-icon bg-sky"><i class="fas fa-user-shield"></i></div><div><span>Pending Admin</span><strong><?= (int) ($stats['pending_admin'] ?? 0) ?></strong></div></article>
            <article class="stat-card"><div class="stat-icon bg-green"><i class="fas fa-circle-check"></i></div><div><span>Approved</span><strong><?= (int) ($stats['approved'] ?? 0) ?></strong></div></article>
        </section>

        <div class="two-col">
            <div class="panel">
                <div class="panel-head"><div><h2>Procedure Cases</h2><small>Cases currently linked to this vet</small></div><span class="badge"><?= count($procedures) ?> cases</span></div>
                <?php if (empty($procedures)): ?><div class="empty">No procedure cases yet.</div><?php else: ?><div class="table-scroll"><table><thead><tr><th>Procedure</th><th>Pet</th><th>Date</th><th>Status</th><th>Owner</th></tr></thead><tbody><?php foreach ($procedures as $procedure): ?><tr><td><strong><?= htmlspecialchars($procedure['procedure_name'] ?? 'Procedure') ?></strong><br><small><?= htmlspecialchars($procedure['procedure_type'] ?? 'Clinical procedure') ?></small></td><td><?= htmlspecialchars($procedure['pet_name'] ?? 'Unknown pet') ?></td><td><?= htmlspecialchars($procedure['procedure_date'] ?? date('Y-m-d', strtotime($procedure['created_at'] ?? 'now'))) ?></td><td><span class="badge <?= htmlspecialchars(strtolower($procedure['status'] ?? 'scheduled')) ?>"><?= htmlspecialchars($procedure['status'] ?? 'scheduled') ?></span></td><td><?= htmlspecialchars($procedure['owner_name'] ?? 'Owner') ?></td></tr><?php endforeach; ?></tbody></table></div><?php endif; ?>
            </div>
            <div class="panel">
                <div class="panel-head"><div><h2>Permission Matrix</h2><small>Per-vet and per-action</small></div><span class="badge"><?= count($permissions) ?> rules</span></div>
                <div class="cards">
                    <?php foreach ($permissions as $permission): ?>
                        <article class="card">
                            <strong><?= htmlspecialchars(ucwords(str_replace('_', ' ', $permission['action_key'] ?? 'action'))) ?></strong>
                            <span class="badge"><?= htmlspecialchars(str_replace('_', ' ', $permission['access_mode'] ?? 'request_admin')) ?></span>
                            <p class="meta"><?= !empty($permission['notes']) ? htmlspecialchars($permission['notes']) : 'Configured by admin workflow policy.' ?></p>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <div class="panel" style="margin-top:18px;">
            <div class="panel-head"><div><h2>Send Surgery Request To Admin</h2><small>Choose the selected operation and forward it to the admin approval queue</small></div></div>
            <form method="post" class="form-grid">
                <input type="hidden" name="action" value="submit_clinical_workflow">
                <input type="hidden" name="action_key" value="surgery_booking">
                <div class="input-group"><label>Requested Procedure</label><select class="form-control" name="procedure_id"><option value="">Choose procedure case</option><?php foreach ($procedures as $procedure): ?><option value="<?= (int) $procedure['id'] ?>"><?= htmlspecialchars(($procedure['procedure_name'] ?? 'Procedure') . ' - ' . ($procedure['pet_name'] ?? 'Pet')) ?></option><?php endforeach; ?></select></div>
                <div class="input-group"><label>Pet</label><select class="form-control" name="pet_id"><option value="">Choose pet</option><?php foreach ($procedures as $procedure): ?><option value="<?= (int) $procedure['pet_id'] ?>"><?= htmlspecialchars(($procedure['pet_name'] ?? 'Pet') . ' - ' . ($procedure['owner_name'] ?? 'Owner')) ?></option><?php endforeach; ?></select></div>
                <div class="input-group full"><label>Admin Request Summary</label><input class="form-control" name="summary" placeholder="Example: Owner confirmed surgery and the case is ready for admin approval"></div>
                <div class="input-group full"><label>Clinical Notes</label><textarea class="form-control" name="notes" placeholder="Add urgency, prep notes, or equipment details for the admin"></textarea></div>
                <button class="action-btn primary" type="submit"><i class="fas fa-user-shield"></i> Send To Admin</button>
            </form>
        </div>
    </main>
</div>
<?php require_once '../app/views/partials/theme_toggle.php'; ?>
</body>
</html>
