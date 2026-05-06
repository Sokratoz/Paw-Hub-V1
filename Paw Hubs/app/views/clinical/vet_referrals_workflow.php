<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Referrals Workflow | Paw Hubs</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root { --teal:#6BB5A8; --green:#9BC870; --olive:#CAD7A5; --mint:#C8E4D6; --sky:#94CDD3; --ink:#2f4f4f; --muted:#718096; --line:#d8ebe5; --soft:#f5faf8; --panel:#ffffff; --danger:#e53e3e; }
        * { box-sizing:border-box; }
        body { margin:0; min-height:100vh; padding:34px; font-family:'Outfit',sans-serif; color:var(--ink); background:linear-gradient(135deg,var(--mint),#ffffff 45%,var(--sky)); }
        .app-frame { max-width:1480px; min-height:calc(100vh - 68px); margin:0 auto; display:grid; grid-template-columns:270px 1fr; background:rgba(255,255,255,.92); border:1px solid var(--line); border-radius:28px; overflow:hidden; box-shadow:0 30px 80px rgba(47,79,79,.14); }
        .sidebar { background:#ffffff; border-right:1px solid var(--line); padding:28px 22px; display:flex; flex-direction:column; gap:28px; }
        .brand { display:flex; align-items:center; gap:12px; color:var(--teal); font-size:22px; font-weight:800; }
        .brand i,.stat-icon,.avatar { display:grid; place-items:center; }
        .brand i { width:44px; height:44px; border-radius:14px; background:var(--mint); }
        .menu-label { color:var(--muted); font-size:12px; font-weight:700; margin:0 0 10px; }
        .menu { display:grid; gap:8px; }
        .menu a { min-height:44px; display:flex; align-items:center; gap:12px; padding:0 14px; border-radius:12px; color:var(--ink); text-decoration:none; font-weight:700; font-size:14px; }
        .menu a.active,.menu a:hover { background:var(--mint); color:#4f9186; }
        .menu a i { width:20px; text-align:center; color:var(--teal); }
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
        .stats,.two-col { display:grid; gap:18px; }
        .stats { grid-template-columns:repeat(3,minmax(140px,1fr)); margin-bottom:18px; }
        .two-col { grid-template-columns:repeat(2,minmax(0,1fr)); }
        .stat-card { min-height:128px; padding:18px; display:flex; flex-direction:column; justify-content:space-between; }
        .stat-icon { width:42px; height:42px; border-radius:14px; font-size:18px; }
        .bg-teal { background:var(--mint); color:#4f9186; } .bg-green { background:var(--green); color:#fff; } .bg-sky { background:var(--sky); color:#fff; }
        .stat-card span,.panel small { color:var(--muted); font-weight:700; } .stat-card span { font-size:13px; } .stat-card strong { display:block; margin-top:5px; font-size:28px; }
        .panel { padding:20px; min-width:0; }
        .panel-head { display:flex; align-items:center; justify-content:space-between; gap:14px; margin-bottom:16px; }
        .panel h2 { margin:0; font-size:20px; }
        .feed { display:grid; gap:12px; } .feed-item { display:grid; grid-template-columns:auto 1fr; gap:12px; align-items:start; border:1px solid var(--line); border-radius:14px; padding:13px; background:#fff; } .avatar { width:34px; height:34px; border-radius:12px; background:var(--mint); color:#4f9186; font-weight:900; }
        .form-grid { display:grid; grid-template-columns:repeat(2,minmax(0,1fr)); gap:14px; } .input-group { display:grid; gap:8px; } .input-group.full { grid-column:1 / -1; }
        label { color:var(--muted); font-size:13px; font-weight:700; } .form-control { width:100%; border:1px solid var(--line); border-radius:14px; padding:12px 14px; background:#fff; font:inherit; color:var(--ink); } textarea.form-control { min-height:96px; resize:vertical; }
        .table-scroll { overflow-x:auto; } table { width:100%; border-collapse:collapse; font-size:14px; } th,td { padding:13px 10px; border-bottom:1px solid var(--line); text-align:left; vertical-align:top; } th { color:var(--muted); font-size:12px; text-transform:uppercase; }
        .notice { border-radius:16px; padding:15px 17px; margin-bottom:16px; line-height:1.6; font-weight:700; } .notice.success { background:#e6fffa; color:#155e75; border:1px solid #b2f5ea; } .notice.error { background:#fff5f5; color:#742a2a; border:1px solid #fed7d7; }
        .empty { min-height:120px; display:grid; place-items:center; border:1px dashed var(--line); border-radius:14px; color:var(--muted); background:var(--soft); text-align:center; padding:16px; }
        @media (max-width:1150px) { body { padding:16px; } .app-frame { grid-template-columns:1fr; } .sidebar { display:none; } .stats,.two-col,.form-grid { grid-template-columns:1fr; } }
    </style>
</head>
<body>
<div class="app-frame">
    <aside class="sidebar">
        <div class="brand"><i class="fas fa-stethoscope"></i><span>Paw Vet</span></div>
        <div>
            <p class="menu-label">Clinical</p>
            <nav class="menu">
                <a href="index.php?url=clinical/index"><i class="fas fa-chart-pie"></i> Dashboard</a>
                <a href="index.php?url=clinical/surgeryManager"><i class="fas fa-briefcase-medical"></i> Surgery Manager</a>
                <a href="index.php?url=clinical/labHub"><i class="fas fa-vial-circle-check"></i> Lab Hub</a>
                <a class="active" href="index.php?url=clinical/referralsWorkflow"><i class="fas fa-share-nodes"></i> Referrals Workflow</a>
            </nav>
        </div>
    </aside>
    <main class="content">
        <div class="topbar">
            <label class="search"><i class="fas fa-search"></i><input type="search" placeholder="Search referrals and specialists"></label>
            <a class="action-btn" href="index.php?url=clinical/index"><i class="fas fa-arrow-left"></i> Dashboard</a>
        </div>
        <header class="page-head">
            <div><h1>Veterinary Referrals Workflow</h1><p>Full workspace for referral cases, specialist transfer, and doctor directory.</p></div>
            <span class="role-pill">Vet access</span>
        </header>
        <?php if (!empty($message)): ?><div class="notice success"><?= htmlspecialchars($message) ?></div><?php endif; ?>
        <?php if (!empty($errors)): ?><div class="notice error"><?= htmlspecialchars(implode(' ', $errors)) ?></div><?php endif; ?>
        <section class="stats">
            <article class="stat-card"><div class="stat-icon bg-teal"><i class="fas fa-share-nodes"></i></div><div><span>Referrals</span><strong><?= (int) ($stats['referrals'] ?? 0) ?></strong></div></article>
            <article class="stat-card"><div class="stat-icon bg-green"><i class="fas fa-user-doctor"></i></div><div><span>Specialists</span><strong><?= (int) ($stats['specialists'] ?? 0) ?></strong></div></article>
            <article class="stat-card"><div class="stat-icon bg-sky"><i class="fas fa-triangle-exclamation"></i></div><div><span>Urgent Cases</span><strong><?= (int) ($stats['urgent'] ?? 0) ?></strong></div></article>
        </section>
        <div class="two-col">
            <div class="panel">
                <div class="panel-head"><div><h2>Referral Cases</h2><small>Cases linked to this vet</small></div><span class="badge"><?= count($referrals) ?> referrals</span></div>
                <?php if (empty($referrals)): ?><div class="empty">No referrals yet.</div><?php else: ?><div class="feed"><?php foreach ($referrals as $referral): ?><article class="feed-item"><span class="avatar"><?= htmlspecialchars(strtoupper(substr($referral['specialty'] ?? 'R', 0, 1))) ?></span><div><strong><?= htmlspecialchars($referral['specialty'] ?? 'Referral') ?></strong><p><?= htmlspecialchars($referral['pet_name'] ?? 'Unknown pet') ?> - <?= htmlspecialchars($referral['status'] ?? 'pending') ?></p><p><?= htmlspecialchars($referral['reason'] ?? 'No reason provided') ?></p></div></article><?php endforeach; ?></div><?php endif; ?>
            </div>
            <div class="panel">
                <div class="panel-head"><div><h2>Transfer To Specialist</h2><small>Move case to another doctor</small></div></div>
                <form method="post" class="form-grid">
                    <input type="hidden" name="action" value="transfer_referral_case">
                    <div class="input-group"><label>Assigned Case</label><select class="form-control" name="pet_id"><option value="">Choose linked case</option><?php foreach ($transferCases as $case): ?><option value="<?= (int) $case['pet_id'] ?>"><?= htmlspecialchars(($case['pet_name'] ?? 'Pet') . ' - ' . ($case['source'] ?? 'Clinical case')) ?></option><?php endforeach; ?></select></div>
                    <div class="input-group"><label>Specialist Doctor</label><select class="form-control" name="to_vet_id"><option value="">Choose specialist</option><?php foreach ($specialists as $specialist): ?><option value="<?= (int) $specialist['id'] ?>"><?= htmlspecialchars(($specialist['username'] ?? 'Doctor') . ' - ' . ($specialist['specialization'] ?? 'Specialist')) ?></option><?php endforeach; ?></select></div>
                    <div class="input-group"><label>Specialty</label><input class="form-control" name="specialty" placeholder="Cardiology, imaging, surgery"></div>
                    <div class="input-group"><label>Priority</label><select class="form-control" name="priority"><option value="normal">normal</option><option value="urgent">urgent</option><option value="critical">critical</option></select></div>
                    <div class="input-group full"><label>Reason</label><textarea class="form-control" name="reason" placeholder="Why should this case be transferred?"></textarea></div>
                    <button class="action-btn primary" type="submit"><i class="fas fa-share-nodes"></i> Transfer Case</button>
                </form>
            </div>
        </div>
        <div class="panel" style="margin-top:18px;">
            <div class="panel-head"><div><h2>Specialist Doctors</h2><small>Visible ratings and case context</small></div><span class="badge"><?= count($specialists) ?> doctors</span></div>
            <?php if (empty($specialists)): ?><div class="empty">No specialist doctors available.</div><?php else: ?><div class="table-scroll"><table><thead><tr><th>Doctor</th><th>Specialization</th><th>Rating</th><th>Surgeries</th><th>Referrals</th><th>Email</th></tr></thead><tbody><?php foreach ($specialists as $specialist): ?><tr><td><strong><?= htmlspecialchars($specialist['username'] ?? 'Doctor') ?></strong><br><small><?= htmlspecialchars(($specialist['surgeries'] ?? 0) > 0 ? 'Active in surgeries' : 'Available for new cases') ?></small></td><td><?= htmlspecialchars($specialist['specialization'] ?? 'Specialist') ?></td><td><span class="badge"><?= htmlspecialchars((string) ($specialist['rating'] ?? '4.7')) ?></span></td><td><?= (int) ($specialist['surgeries'] ?? 0) ?></td><td><?= (int) ($specialist['referrals_count'] ?? 0) ?></td><td><?= htmlspecialchars($specialist['email'] ?? '') ?></td></tr><?php endforeach; ?></tbody></table></div><?php endif; ?>
        </div>
    </main>
</div>
<?php require_once '../app/views/partials/theme_toggle.php'; ?>
</body>
</html>
