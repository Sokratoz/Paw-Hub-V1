<?php
if (!function_exists('asset')) {
    function asset($path) {
        $base = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '')), '/');
        if ($base === '/' || $base === '.') {
            $base = '';
        }
        return $base . '/' . ltrim($path, '/');
    }
}

$role = $role ?? 'pet_owner';
$pets = $pets ?? [];
$doctors = $doctors ?? [];
$labReports = $labReports ?? [];
$referrals = $referrals ?? [];
$appointments = $appointments ?? [];
$stats = $stats ?? ['upcomingAppointments' => 0, 'pendingReferrals' => 0, 'availableLabReports' => 0];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointments & Medical Hub | Paw Hubs</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root {
            --teal: #58ab9c;
            --teal-deep: #2f7f74;
            --mint: #dff4ed;
            --glass: rgba(255, 255, 255, 0.72);
            --line: rgba(104, 160, 145, 0.18);
            --ink: #244640;
            --muted: #6b827d;
            --soft: #f5fbf8;
            --sky: #a8d8d9;
            --danger: #d45d5d;
            --warn: #d59a34;
            --success: #3d9b72;
            --shadow: 0 24px 60px rgba(46, 84, 74, 0.12);
        }

        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: 'Outfit', sans-serif;
            color: var(--ink);
            background:
                radial-gradient(circle at top left, rgba(168, 216, 217, 0.45), transparent 24%),
                linear-gradient(140deg, #eef8f4 0%, #f7fcfa 42%, #e9f6f0 100%);
        }

        .page-shell {
            max-width: 1460px;
            margin: 0 auto;
            padding: 0 28px 48px;
        }

        .dashboard {
            display: grid;
            gap: 22px;
        }

        .hero,
        .glass-card,
        .stat-card,
        .section-card,
        .modal-panel {
            background: var(--glass);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.72);
            box-shadow: var(--shadow);
        }

        .hero {
            margin-top: 26px;
            border-radius: 34px;
            overflow: hidden;
            padding: 34px;
            display: grid;
            grid-template-columns: minmax(0, 1.4fr) minmax(280px, 420px);
            gap: 24px;
            position: relative;
        }

        .hero::after {
            content: "";
            position: absolute;
            inset: auto -80px -120px auto;
            width: 320px;
            height: 320px;
            background: radial-gradient(circle, rgba(88, 171, 156, 0.18), rgba(88, 171, 156, 0));
            pointer-events: none;
        }

        .hero-copy strong {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 10px 16px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.78);
            color: var(--teal-deep);
            font-size: 13px;
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }

        .hero-copy h1 {
            margin: 18px 0 12px;
            font-size: clamp(32px, 5vw, 52px);
            line-height: 1.02;
            letter-spacing: -0.03em;
        }

        .hero-copy p {
            margin: 0;
            max-width: 760px;
            color: var(--muted);
            font-size: 18px;
            line-height: 1.7;
        }

        .hero-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 14px;
            margin-top: 28px;
        }

        .btn {
            min-height: 50px;
            padding: 0 20px;
            border: 0;
            border-radius: 16px;
            cursor: pointer;
            font: inherit;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            text-decoration: none;
            transition: transform 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
        }

        .btn:hover { transform: translateY(-1px); }
        .btn.primary { background: linear-gradient(135deg, var(--teal), var(--sky)); color: #fff; }
        .btn.secondary { background: rgba(255, 255, 255, 0.82); color: var(--ink); }
        .btn.ghost { background: rgba(223, 244, 237, 0.85); color: var(--teal-deep); }
        .btn.danger { background: rgba(212, 93, 93, 0.12); color: var(--danger); }

        .hero-side {
            border-radius: 28px;
            padding: 22px;
            background: linear-gradient(160deg, rgba(255,255,255,0.9), rgba(223,244,237,0.86));
            border: 1px solid var(--line);
            display: grid;
            gap: 14px;
            align-content: start;
        }

        .hero-side h2,
        .section-heading h2 {
            margin: 0;
            font-size: 20px;
        }

        .hero-side p,
        .section-heading p,
        .meta,
        .empty-state,
        .field label,
        .subtle {
            color: var(--muted);
        }

        .hero-side p,
        .section-heading p,
        .meta,
        .empty-state {
            line-height: 1.6;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 18px;
        }

        .stat-card {
            border-radius: 24px;
            padding: 22px;
            min-height: 148px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .stat-card:hover,
        .mini-card:hover,
        .list-card:hover,
        .table-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 26px 56px rgba(46, 84, 74, 0.16);
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 18px;
            display: grid;
            place-items: center;
            background: rgba(223, 244, 237, 0.9);
            color: var(--teal-deep);
            font-size: 20px;
        }

        .stat-card strong {
            font-size: 34px;
            line-height: 1;
        }

        .stat-card span {
            font-size: 14px;
            color: var(--muted);
            font-weight: 600;
        }

        .hub-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 22px;
        }

        .section-card {
            border-radius: 28px;
            padding: 24px;
            display: grid;
            gap: 20px;
            min-width: 0;
        }

        .section-heading,
        .section-tools,
        .toolbar,
        .card-top,
        .modal-head,
        .modal-actions,
        .item-actions {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .toolbar {
            flex-wrap: wrap;
        }

        .input,
        .select,
        .textarea {
            width: 100%;
            border-radius: 16px;
            border: 1px solid var(--line);
            background: rgba(255, 255, 255, 0.9);
            font: inherit;
            color: var(--ink);
            padding: 14px 16px;
            outline: 0;
        }

        .textarea {
            min-height: 110px;
            resize: vertical;
        }

        .toolbar .input,
        .toolbar .select {
            max-width: 220px;
        }

        .list-wrap {
            display: grid;
            gap: 16px;
        }

        .list-card,
        .table-card,
        .mini-card {
            border-radius: 22px;
            border: 1px solid var(--line);
            background: rgba(255, 255, 255, 0.84);
            padding: 18px;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .mini-grid {
            display: grid;
            gap: 12px;
        }

        .list-card h3,
        .table-card h3,
        .mini-card h3 {
            margin: 0 0 8px;
            font-size: 18px;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 32px;
            padding: 0 12px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;
            text-transform: capitalize;
            white-space: nowrap;
        }

        .badge.available,
        .badge.approved,
        .badge.confirmed,
        .badge.reviewed,
        .badge.completed {
            background: rgba(61, 155, 114, 0.14);
            color: var(--success);
        }

        .badge.pending,
        .badge.pending\ review,
        .badge.upcoming,
        .badge.rescheduled {
            background: rgba(213, 154, 52, 0.15);
            color: var(--warn);
        }

        .badge.rejected,
        .badge.cancelled,
        .badge.archived {
            background: rgba(212, 93, 93, 0.15);
            color: var(--danger);
        }

        .chip-row,
        .detail-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .chip {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            min-height: 36px;
            padding: 0 14px;
            border-radius: 999px;
            background: rgba(223, 244, 237, 0.86);
            color: var(--teal-deep);
            font-size: 13px;
            font-weight: 600;
        }

        .table-wrap {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 640px;
        }

        th, td {
            text-align: left;
            padding: 14px 12px;
            border-bottom: 1px solid rgba(104, 160, 145, 0.14);
            font-size: 14px;
            vertical-align: top;
        }

        th { color: var(--muted); font-size: 13px; font-weight: 700; }

        .file-link {
            color: var(--teal-deep);
            font-weight: 700;
            text-decoration: none;
        }

        .empty-state {
            border: 1px dashed var(--line);
            border-radius: 20px;
            padding: 24px;
            text-align: center;
            background: rgba(255, 255, 255, 0.45);
        }

        .modal {
            position: fixed;
            inset: 0;
            background: rgba(23, 46, 41, 0.44);
            display: none;
            align-items: center;
            justify-content: center;
            padding: 24px;
            z-index: 3000;
        }

        .modal.show { display: flex; }

        .modal-panel {
            width: min(760px, 100%);
            max-height: calc(100vh - 48px);
            overflow: auto;
            border-radius: 28px;
            padding: 24px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 16px;
        }

        .field {
            display: grid;
            gap: 8px;
        }

        .field.full { grid-column: 1 / -1; }
        .field label { font-size: 13px; font-weight: 700; }

        .toast-stack {
            position: fixed;
            right: 18px;
            bottom: 18px;
            display: grid;
            gap: 12px;
            z-index: 4000;
        }

        .toast {
            min-width: 260px;
            max-width: 360px;
            padding: 16px 18px;
            border-radius: 18px;
            color: #fff;
            box-shadow: 0 20px 42px rgba(26, 49, 44, 0.22);
        }

        .toast.success { background: linear-gradient(135deg, #3d9b72, #58ab9c); }
        .toast.error { background: linear-gradient(135deg, #d45d5d, #bf6a6a); }

        @media (max-width: 1180px) {
            .hero,
            .hub-grid {
                grid-template-columns: 1fr;
            }

            .stats-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 720px) {
            .page-shell { padding: 0 14px 34px; }
            .hero,
            .section-card,
            .modal-panel { padding: 18px; }
            .stats-grid,
            .form-grid { grid-template-columns: 1fr; }
            .toolbar .input,
            .toolbar .select { max-width: 100%; }
            .hero-actions,
            .toolbar,
            .modal-actions,
            .section-tools,
            .card-top,
            .item-actions { align-items: stretch; flex-direction: column; }
            .btn { width: 100%; }
        }
    </style>
</head>
<body>
<?php require_once '../app/views/partials/navbar.php'; ?>

<div class="page-shell">
    <main class="dashboard">
        <section class="hero">
            <div class="hero-copy">
                <strong><i class="fas fa-stethoscope"></i> Paw Hubs Healthcare Center</strong>
                <h1>Appointments & Medical Hub</h1>
                <p>Manage consultations, referrals, and lab documentation for every pet from one premium veterinary dashboard with live MySQL-backed records.</p>
                <div class="hero-actions">
                    <?php if ($role === 'pet_owner'): ?>
                        <button class="btn primary" type="button" data-open-modal="appointmentModal"><i class="fas fa-calendar-plus"></i> Book Consultation</button>
                        <button class="btn secondary" type="button" data-open-modal="reportModal"><i class="fas fa-file-arrow-up"></i> Upload Lab Report</button>
                        <a class="btn ghost" href="#referrals-section"><i class="fas fa-share-nodes"></i> Review Referrals</a>
                    <?php else: ?>
                        <button class="btn secondary" type="button" disabled><i class="fas fa-calendar-check"></i> View Assigned Appointments</button>
                    <?php endif; ?>
                </div>
            </div>
            <aside class="hero-side">
                <div class="section-heading">
                    <div>
                        <h2>Care Overview</h2>
                        <p>Today’s snapshot of your pets’ medical workflow.</p>
                    </div>
                </div>
                <div class="mini-grid">
                    <div class="mini-card">
                        <h3><?= count($pets) ?></h3>
                        <div class="meta">Registered pets linked to your account</div>
                    </div>
                    <div class="mini-card">
                        <h3><?= count($doctors) ?></h3>
                        <div class="meta">Veterinarians available for booking</div>
                    </div>
                    <div class="mini-card">
                        <h3><?= count(array_filter($appointments, fn($item) => strtolower((string) ($item['status'] ?? '')) === 'cancelled')) ?></h3>
                        <div class="meta">Bookings currently marked cancelled</div>
                    </div>
                </div>
            </aside>
        </section>

        <section class="stats-grid">
            <article class="stat-card">
                <div class="stat-icon"><i class="fas fa-calendar-check"></i></div>
                <div><strong><?= (int) $stats['upcomingAppointments'] ?></strong><span>Upcoming Appointments</span></div>
            </article>
            <article class="stat-card">
                <div class="stat-icon"><i class="fas fa-file-signature"></i></div>
                <div><strong><?= (int) $stats['pendingReferrals'] ?></strong><span>Pending Referrals</span></div>
            </article>
            <article class="stat-card">
                <div class="stat-icon"><i class="fas fa-vial-circle-check"></i></div>
                <div><strong><?= (int) $stats['availableLabReports'] ?></strong><span>Available Lab Reports</span></div>
            </article>
        </section>

        <section class="hub-grid">
            <?php if ($role === 'pet_owner'): ?>
            <section class="section-card">
                <div class="section-heading">
                    <div>
                        <h2>Lab Reports</h2>
                        <p>Upload PDFs or medical images, then search, review, and download every stored report.</p>
                    </div>
                    <button class="btn primary" type="button" data-open-modal="reportModal"><i class="fas fa-plus"></i> Add</button>
                </div>
                <div class="toolbar">
                    <input class="input" type="search" placeholder="Search reports" data-search-target="reports">
                    <select class="select" data-filter-target="reports" data-filter-key="status">
                        <option value="">All statuses</option>
                        <option value="available">Available</option>
                        <option value="pending review">Pending Review</option>
                        <option value="reviewed">Reviewed</option>
                        <option value="archived">Archived</option>
                    </select>
                </div>
                <div class="list-wrap" id="reportsList">
                    <?php if (empty($labReports)): ?>
                        <div class="empty-state">No lab reports yet. Upload the first file to start your pet’s digital medical archive.</div>
                    <?php else: ?>
                        <?php foreach ($labReports as $report): ?>
                            <?php
                            $reportPayload = htmlspecialchars(json_encode($report), ENT_QUOTES, 'UTF-8');
                            $reportStatus = strtolower((string) ($report['status'] ?? 'available'));
                            ?>
                            <article class="list-card searchable-card" data-group="reports" data-status="<?= htmlspecialchars($reportStatus) ?>" data-search="<?= htmlspecialchars(strtolower(($report['report_title'] ?? '') . ' ' . ($report['report_type'] ?? '') . ' ' . ($report['pet_name'] ?? '') . ' ' . ($report['doctor_name'] ?? '') . ' ' . ($report['notes'] ?? ''))) ?>">
                                <div class="card-top">
                                    <div>
                                        <h3><?= htmlspecialchars($report['report_title'] ?? 'Lab Report') ?></h3>
                                        <div class="meta"><?= htmlspecialchars(($report['pet_name'] ?? 'Pet') . ' • ' . ($report['report_type'] ?? 'General')) ?></div>
                                    </div>
                                    <span class="badge <?= htmlspecialchars($reportStatus) ?>"><?= htmlspecialchars($report['status'] ?? 'available') ?></span>
                                </div>
                                <div class="chip-row">
                                    <span class="chip"><i class="fas fa-user-doctor"></i><?= htmlspecialchars($report['doctor_name'] ?? 'Care Team') ?></span>
                                    <span class="chip"><i class="fas fa-clock"></i><?= htmlspecialchars(date('M j, Y', strtotime($report['created_at'] ?? 'now'))) ?></span>
                                </div>
                                <p class="meta"><?= nl2br(htmlspecialchars($report['notes'] ?? 'No notes added yet.')) ?></p>
                                <div class="item-actions">
                                    <a class="file-link" href="<?= htmlspecialchars(asset('uploads/reports/' . ($report['report_file'] ?? ''))) ?>" target="_blank"><i class="fas fa-download"></i> View / Download</a>
                                    <div class="chip-row">
                                        <button class="btn ghost js-edit-record" type="button" data-record-type="report" data-record='<?= $reportPayload ?>'>Edit</button>
                                        <button class="btn danger js-delete-record" type="button" data-delete-url="index.php?url=appointments/deleteLabReport" data-id="<?= (int) $report['id'] ?>">Delete</button>
                                    </div>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </section>

            <section class="section-card" id="referrals-section">
                <div class="section-heading">
                    <div>
                        <h2>Referral Requests</h2>
                        <p>View specialist referrals sent by vets or admins, then accept or reject them with owner approval.</p>
                    </div>
                    <span class="badge"><?= count($referrals) ?> referrals</span>
                </div>
                <div class="toolbar">
                    <input class="input" type="search" placeholder="Search referrals" data-search-target="referrals">
                    <select class="select" data-filter-target="referrals" data-filter-key="status">
                        <option value="">All statuses</option>
                        <option value="pending">Pending</option>
                        <option value="approved">Approved</option>
                        <option value="rejected">Rejected</option>
                    </select>
                </div>
                <div class="list-wrap" id="referralsList">
                    <?php if (empty($referrals)): ?>
                        <div class="empty-state">No referrals yet. Create one when your pet needs a specialist review or a second opinion.</div>
                    <?php else: ?>
                        <?php foreach ($referrals as $referral): ?>
                            <?php
                            $referralPayload = htmlspecialchars(json_encode($referral), ENT_QUOTES, 'UTF-8');
                            $referralStatus = strtolower((string) ($referral['owner_response_status'] ?? 'pending'));
                            ?>
                            <article class="list-card searchable-card" data-group="referrals" data-status="<?= htmlspecialchars($referralStatus) ?>" data-search="<?= htmlspecialchars(strtolower(($referral['referred_to'] ?? '') . ' ' . ($referral['reason'] ?? '') . ' ' . ($referral['pet_name'] ?? '') . ' ' . ($referral['notes'] ?? ''))) ?>">
                                <div class="card-top">
                                    <div>
                                        <h3><?= htmlspecialchars(($referral['referred_to_user'] ?? $referral['referred_to']) ?: 'Specialist referral') ?></h3>
                                        <div class="meta"><?= htmlspecialchars(($referral['pet_name'] ?? 'Pet') . ' • ' . ($referral['species'] ?? 'Pet')) ?></div>
                                    </div>
                                    <span class="badge <?= htmlspecialchars($referralStatus) ?>"><?= htmlspecialchars($referral['owner_response_status'] ?? 'pending') ?></span>
                                </div>
                                <div class="detail-grid">
                                    <span class="chip"><i class="fas fa-user-doctor"></i>From: <?= htmlspecialchars($referral['referred_by_name'] ?? 'Care Team') ?></span>
                                    <span class="chip"><i class="fas fa-circle-info"></i><?= htmlspecialchars($referral['reason'] ?? 'No reason') ?></span>
                                    <span class="chip"><i class="fas fa-calendar-day"></i><?= htmlspecialchars(!empty($referral['appointment_date']) ? date('M j, Y', strtotime($referral['appointment_date'])) : 'Not scheduled') ?></span>
                                </div>
                                <p class="meta"><?= nl2br(htmlspecialchars($referral['notes'] ?? 'No notes yet.')) ?></p>
                                <div class="item-actions">
                                    <button class="btn secondary js-view-referral" type="button" data-record='<?= $referralPayload ?>'><i class="fas fa-eye"></i> Details</button>
                                    <?php if ($referralStatus === 'pending'): ?>
                                        <div class="chip-row">
                                            <button class="btn primary js-respond-referral" type="button" data-id="<?= (int) $referral['id'] ?>" data-response="accepted">Accept</button>
                                            <button class="btn danger js-respond-referral" type="button" data-id="<?= (int) $referral['id'] ?>" data-response="rejected">Reject</button>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </section>
            <?php endif; ?>

            <section class="section-card">
                <div class="section-heading">
                    <div>
                        <h2><?= $role === 'pet_owner' ? 'Consultation Booking' : 'Appointment Schedule' ?></h2>
                        <p><?= $role === 'pet_owner' ? 'Book, reschedule, or cancel veterinary consultations using live doctor availability from the database.' : 'Browse appointment activity for your role and review bookings that involve your clinic.' ?></p>
                    </div>
                    <?php if ($role === 'pet_owner'): ?>
                        <button class="btn primary" type="button" data-open-modal="appointmentModal"><i class="fas fa-plus"></i> Book</button>
                    <?php endif; ?>
                </div>
                <div class="toolbar">
                    <input class="input" type="search" placeholder="Search appointments" data-search-target="appointments">
                    <select class="select" data-filter-target="appointments" data-filter-key="status">
                        <option value="">All statuses</option>
                        <option value="upcoming">Upcoming</option>
                        <option value="confirmed">Confirmed</option>
                        <option value="rescheduled">Rescheduled</option>
                        <option value="completed">Completed</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>
                <div class="table-wrap">
                    <?php if (empty($appointments)): ?>
                        <div class="empty-state">No consultations booked yet. Schedule your first appointment with a veterinarian.</div>
                    <?php else: ?>
                        <div class="table-card">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Pet</th>
                                        <th>Doctor</th>
                                        <?php if ($role !== 'pet_owner'): ?><th>Owner</th><?php endif; ?>
                                        <th>Visit</th>
                                        <th>Schedule</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="appointmentsList">
                                    <?php foreach ($appointments as $appointment): ?>
                                        <?php
                                        $appointmentPayload = htmlspecialchars(json_encode($appointment), ENT_QUOTES, 'UTF-8');
                                        $appointmentStatus = strtolower((string) ($appointment['status'] ?? 'upcoming'));
                                        ?>
                                        <tr class="searchable-card" data-group="appointments" data-status="<?= htmlspecialchars($appointmentStatus) ?>" data-search="<?= htmlspecialchars(strtolower(($appointment['pet_name'] ?? '') . ' ' . ($appointment['doctor_name'] ?? '') . ' ' . ($appointment['appointment_type'] ?? '') . ' ' . ($appointment['notes'] ?? ''))) ?>">
                                            <td>
                                                <strong><?= htmlspecialchars($appointment['pet_name'] ?? 'Pet') ?></strong><br>
                                                <span class="meta"><?= htmlspecialchars($appointment['species'] ?? 'Pet') ?></span>
                                            </td>
                                            <td>
                                                <strong><?= htmlspecialchars($appointment['doctor_name'] ?? 'Veterinarian') ?></strong><br>
                                                <span class="meta"><?= htmlspecialchars($appointment['specialization'] ?? 'General Veterinary Care') ?></span>
                                            </td>
                                            <td>
                                                <strong><?= htmlspecialchars($appointment['appointment_type'] ?? 'Consultation') ?></strong><br>
                                                <span class="meta"><?= htmlspecialchars($appointment['notes'] ?: 'No notes') ?></span>
                                            </td>
                                            <td>
                                                <strong><?= htmlspecialchars(date('M j, Y', strtotime($appointment['appointment_date'] ?? 'now'))) ?></strong><br>
                                                <span class="meta"><?= htmlspecialchars(date('g:i A', strtotime((string) ($appointment['appointment_time'] ?? '00:00:00')))) ?></span>
                                            </td>
                                            <?php if ($role !== 'pet_owner'): ?>
                                                <td>
                                                    <strong><?= htmlspecialchars($appointment['owner_name'] ?? 'Owner') ?></strong>
                                                </td>
                                            <?php endif; ?>
                                            <td><span class="badge <?= htmlspecialchars($appointmentStatus) ?>"><?= htmlspecialchars($appointment['status'] ?? 'upcoming') ?></span></td>
                                            <td>
                                                <?php if ($role === 'pet_owner'): ?>
                                                    <div class="chip-row">
                                                        <button class="btn ghost js-edit-record" type="button" data-record-type="appointment" data-record='<?= $appointmentPayload ?>'>Reschedule</button>
                                                        <button class="btn danger js-cancel-appointment" type="button" data-id="<?= (int) $appointment['id'] ?>">Cancel</button>
                                                    </div>
                                                <?php else: ?>
                                                    <span class="subtle">Read-only view</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </section>
        </section>
    </main>
</div>

<div class="modal" id="reportModal" aria-hidden="true">
    <div class="modal-panel">
        <div class="modal-head">
            <div>
                <h2 id="reportModalTitle">Upload Lab Report</h2>
                <p class="subtle">Files are stored in `uploads/reports/` and only the filename is saved in MySQL.</p>
            </div>
            <button class="btn secondary" type="button" data-close-modal="reportModal">Close</button>
        </div>
        <form class="ajax-form" action="index.php?url=appointments/createLabReport" method="post" enctype="multipart/form-data" data-modal="reportModal">
            <input type="hidden" name="id" id="report_id">
            <div class="form-grid">
                <div class="field">
                    <label>Pet</label>
                    <select class="select" name="pet_id" id="report_pet_id" required>
                        <option value="">Choose pet</option>
                        <?php foreach ($pets as $pet): ?>
                            <option value="<?= (int) $pet['id'] ?>"><?= htmlspecialchars($pet['name'] . ' • ' . $pet['species']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="field">
                    <label>Status</label>
                    <select class="select" name="status" id="report_status" required>
                        <option value="available">Available</option>
                        <option value="pending review">Pending Review</option>
                        <option value="reviewed">Reviewed</option>
                        <option value="archived">Archived</option>
                    </select>
                </div>
                <div class="field">
                    <label>Report Title</label>
                    <input class="input" type="text" name="report_title" id="report_title" required>
                </div>
                <div class="field">
                    <label>Report Type</label>
                    <input class="input" type="text" name="report_type" id="report_type" placeholder="Blood Test, X-Ray, Ultrasound" required>
                </div>
                <div class="field">
                    <label>Doctor Name</label>
                    <input class="input" type="text" name="doctor_name" id="report_doctor_name" placeholder="Submitting doctor or clinic">
                </div>
                <div class="field">
                    <label>Report File</label>
                    <input class="input" type="file" name="report_file" id="report_file" accept=".pdf,.jpg,.jpeg,.png,.webp">
                </div>
                <div class="field full">
                    <label>Notes</label>
                    <textarea class="textarea" name="notes" id="report_notes" placeholder="Add medical notes or result summary"></textarea>
                </div>
            </div>
            <div class="modal-actions">
                <span class="subtle">PDF and image files only.</span>
                <button class="btn primary" type="submit">Save Report</button>
            </div>
        </form>
    </div>
</div>

<div class="modal" id="appointmentModal" aria-hidden="true">
    <div class="modal-panel">
        <div class="modal-head">
            <div>
                <h2 id="appointmentModalTitle">Book Consultation</h2>
                <p class="subtle">Choose a real veterinarian from the database and schedule the visit.</p>
            </div>
            <button class="btn secondary" type="button" data-close-modal="appointmentModal">Close</button>
        </div>
        <form class="ajax-form" action="index.php?url=appointments/createAppointment" method="post" data-modal="appointmentModal">
            <input type="hidden" name="id" id="appointment_id">
            <div class="form-grid">
                <div class="field">
                    <label>Pet</label>
                    <select class="select" name="pet_id" id="appointment_pet_id" required>
                        <option value="">Choose pet</option>
                        <?php foreach ($pets as $pet): ?>
                            <option value="<?= (int) $pet['id'] ?>"><?= htmlspecialchars($pet['name'] . ' • ' . $pet['species']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="field">
                    <label>Doctor</label>
                    <select class="select" name="doctor_id" id="appointment_doctor_id" required>
                        <option value="">Choose doctor</option>
                        <?php foreach ($doctors as $doctor): ?>
                            <option value="<?= (int) $doctor['id'] ?>"><?= htmlspecialchars($doctor['username'] . ' • ' . $doctor['specialization']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="field">
                    <label>Appointment Type</label>
                    <select class="select" name="appointment_type" id="appointment_type" required>
                        <option value="">Choose type</option>
                        <option value="Online Consultation">Online Consultation</option>
                        <option value="Clinic Visit">Clinic Visit</option>
                        <option value="Vaccination">Vaccination</option>
                        <option value="Follow-up">Follow-up</option>
                        <option value="Emergency Visit">Emergency Visit</option>
                    </select>
                </div>
                <div class="field">
                    <label>Status</label>
                    <select class="select" name="status" id="appointment_status" required>
                        <option value="upcoming">Upcoming</option>
                        <option value="confirmed">Confirmed</option>
                        <option value="rescheduled">Rescheduled</option>
                        <option value="completed">Completed</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>
                <div class="field">
                    <label>Date</label>
                    <input class="input" type="date" name="appointment_date" id="appointment_date" required>
                </div>
                <div class="field">
                    <label>Time</label>
                    <input class="input" type="time" name="appointment_time" id="appointment_time" required>
                </div>
                <div class="field full">
                    <label>Notes</label>
                    <textarea class="textarea" name="notes" id="appointment_notes" placeholder="Symptoms, follow-up context, or visit notes"></textarea>
                </div>
            </div>
            <div class="modal-actions">
                <span class="subtle">Use edit to reschedule or cancel a booking later.</span>
                <button class="btn primary" type="submit">Save Appointment</button>
            </div>
        </form>
    </div>
</div>

<div class="modal" id="referralDetailsModal" aria-hidden="true">
    <div class="modal-panel">
        <div class="modal-head">
            <div>
                <h2>Referral Details</h2>
                <p class="subtle">Review the full request before editing it.</p>
            </div>
            <button class="btn secondary" type="button" data-close-modal="referralDetailsModal">Close</button>
        </div>
        <div class="mini-grid">
            <div class="mini-card"><h3 id="detailsReferralTo">-</h3><div class="meta">Destination</div></div>
            <div class="mini-card"><h3 id="detailsReferralPet">-</h3><div class="meta">Pet</div></div>
            <div class="mini-card"><h3 id="detailsReferralDate">-</h3><div class="meta">Appointment Date</div></div>
            <div class="mini-card"><h3 id="detailsReferralStatus">-</h3><div class="meta">Status</div></div>
            <div class="mini-card"><h3 id="detailsReferralReason">-</h3><div class="meta">Reason</div></div>
            <div class="mini-card"><h3 id="detailsReferralNotes">-</h3><div class="meta">Doctor Notes</div></div>
        </div>
    </div>
</div>

<div class="toast-stack" id="toastStack"></div>

<script>
const modalButtons = document.querySelectorAll('[data-open-modal]');
const closeButtons = document.querySelectorAll('[data-close-modal]');
const modals = document.querySelectorAll('.modal');
const toastStack = document.getElementById('toastStack');

const openModal = (id) => {
    const modal = document.getElementById(id);
    if (modal) {
        modal.classList.add('show');
        modal.setAttribute('aria-hidden', 'false');
    }
};

const closeModal = (id) => {
    const modal = document.getElementById(id);
    if (modal) {
        modal.classList.remove('show');
        modal.setAttribute('aria-hidden', 'true');
    }
};

modalButtons.forEach((button) => {
    button.addEventListener('click', () => {
        resetFormsIfNeeded(button.dataset.openModal);
        openModal(button.dataset.openModal);
    });
});

closeButtons.forEach((button) => {
    button.addEventListener('click', () => closeModal(button.dataset.closeModal));
});

modals.forEach((modal) => {
    modal.addEventListener('click', (event) => {
        if (event.target === modal) {
            closeModal(modal.id);
        }
    });
});

document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') {
        modals.forEach((modal) => closeModal(modal.id));
    }
});

function showToast(message, type = 'success') {
    const toast = document.createElement('div');
    toast.className = `toast ${type}`;
    toast.textContent = message;
    toastStack.appendChild(toast);
    window.setTimeout(() => toast.remove(), 3200);
}

function persistToast(message, type) {
    sessionStorage.setItem('paw_hubs_toast', JSON.stringify({ message, type }));
}

function restoreToast() {
    const raw = sessionStorage.getItem('paw_hubs_toast');
    if (!raw) return;
    try {
        const toast = JSON.parse(raw);
        showToast(toast.message, toast.type);
    } catch (error) {
    }
    sessionStorage.removeItem('paw_hubs_toast');
}

restoreToast();

document.querySelectorAll('.ajax-form').forEach((form) => {
    form.addEventListener('submit', async (event) => {
        event.preventDefault();
        const formData = new FormData(form);
        const response = await fetch(form.action, { method: 'POST', body: formData });
        const json = await response.json().catch(() => ({ success: false, message: 'Unexpected server response.' }));
        if (!json.success) {
            showToast(json.message || 'Could not save.', 'error');
            return;
        }
        persistToast(json.message || 'Saved successfully.', 'success');
        window.location.reload();
    });
});

document.querySelectorAll('.js-delete-record').forEach((button) => {
    button.addEventListener('click', async () => {
        if (!confirm('Delete this record?')) return;
        const formData = new FormData();
        formData.append('id', button.dataset.id);
        const response = await fetch(button.dataset.deleteUrl, { method: 'POST', body: formData });
        const json = await response.json().catch(() => ({ success: false, message: 'Unexpected server response.' }));
        if (!json.success) {
            showToast(json.message || 'Could not delete record.', 'error');
            return;
        }
        persistToast(json.message || 'Deleted successfully.', 'success');
        window.location.reload();
    });
});

document.querySelectorAll('.js-cancel-appointment').forEach((button) => {
    button.addEventListener('click', async () => {
        if (!confirm('Cancel this appointment?')) return;
        const formData = new FormData();
        formData.append('id', button.dataset.id);
        formData.append('pet_id', '');
        formData.append('doctor_id', '');
        formData.append('appointment_type', '');
        formData.append('appointment_date', '');
        formData.append('appointment_time', '');
        formData.append('notes', '');
        formData.append('status', 'cancelled');
        const row = button.closest('tr');
        const editButton = row ? row.querySelector('.js-edit-record') : null;
        if (editButton) {
            const record = JSON.parse(editButton.dataset.record);
            formData.set('pet_id', record.pet_id || '');
            formData.set('doctor_id', record.doctor_id || '');
            formData.set('appointment_type', record.appointment_type || '');
            formData.set('appointment_date', record.appointment_date || '');
            formData.set('appointment_time', (record.appointment_time || '').slice(0, 5));
            formData.set('notes', record.notes || '');
        }
        const response = await fetch('index.php?url=appointments/updateAppointment', { method: 'POST', body: formData });
        const json = await response.json().catch(() => ({ success: false, message: 'Unexpected server response.' }));
        if (!json.success) {
            showToast(json.message || 'Could not cancel appointment.', 'error');
            return;
        }
        persistToast(json.message || 'Appointment cancelled successfully.', 'success');
        window.location.reload();
    });
});

document.querySelectorAll('.js-edit-record').forEach((button) => {
    button.addEventListener('click', () => {
        const record = JSON.parse(button.dataset.record);
        if (button.dataset.recordType === 'report') {
            document.getElementById('reportModalTitle').textContent = 'Edit Lab Report';
            const form = document.querySelector('#reportModal form');
            form.action = 'index.php?url=appointments/updateLabReport';
            document.getElementById('report_id').value = record.id || '';
            document.getElementById('report_pet_id').value = record.pet_id || '';
            document.getElementById('report_status').value = record.status || 'available';
            document.getElementById('report_title').value = record.report_title || '';
            document.getElementById('report_type').value = record.report_type || '';
            document.getElementById('report_doctor_name').value = record.doctor_name || '';
            document.getElementById('report_notes').value = record.notes || '';
            openModal('reportModal');
            return;
        }
        document.getElementById('appointmentModalTitle').textContent = 'Reschedule Appointment';
        const form = document.querySelector('#appointmentModal form');
        form.action = 'index.php?url=appointments/updateAppointment';
        document.getElementById('appointment_id').value = record.id || '';
        document.getElementById('appointment_pet_id').value = record.pet_id || '';
        document.getElementById('appointment_doctor_id').value = record.doctor_id || '';
        document.getElementById('appointment_type').value = record.appointment_type || '';
        document.getElementById('appointment_status').value = record.status || 'upcoming';
        document.getElementById('appointment_date').value = record.appointment_date || '';
        document.getElementById('appointment_time').value = (record.appointment_time || '').slice(0, 5);
        document.getElementById('appointment_notes').value = record.notes || '';
        openModal('appointmentModal');
    });
});

document.querySelectorAll('.js-view-referral').forEach((button) => {
    button.addEventListener('click', () => {
        const record = JSON.parse(button.dataset.record);
        document.getElementById('detailsReferralTo').textContent = record.referred_to_user || record.referred_to || '-';
        document.getElementById('detailsReferralPet').textContent = record.pet_name || '-';
        document.getElementById('detailsReferralDate').textContent = record.appointment_date || 'Not scheduled';
        document.getElementById('detailsReferralStatus').textContent = record.owner_response_status || '-';
        document.getElementById('detailsReferralReason').textContent = record.reason || '-';
        document.getElementById('detailsReferralNotes').textContent = `From ${record.referred_by_name || 'Care Team'}: ${record.notes || 'No notes'}`;
        openModal('referralDetailsModal');
    });
});

function resetFormsIfNeeded(modalId) {
    if (modalId === 'reportModal') {
        document.getElementById('reportModalTitle').textContent = 'Upload Lab Report';
        const form = document.querySelector('#reportModal form');
        form.reset();
        form.action = 'index.php?url=appointments/createLabReport';
        document.getElementById('report_id').value = '';
    }
    if (modalId === 'appointmentModal') {
        document.getElementById('appointmentModalTitle').textContent = 'Book Consultation';
        const form = document.querySelector('#appointmentModal form');
        form.reset();
        form.action = 'index.php?url=appointments/createAppointment';
        document.getElementById('appointment_id').value = '';
        document.getElementById('appointment_status').value = 'upcoming';
    }
}

document.querySelectorAll('.js-respond-referral').forEach((button) => {
    button.addEventListener('click', async () => {
        const label = button.dataset.response === 'accepted' ? 'accept' : 'reject';
        if (!confirm(`Do you want to ${label} this referral?`)) return;
        const formData = new FormData();
        formData.append('id', button.dataset.id);
        formData.append('response', button.dataset.response);
        const response = await fetch('index.php?url=appointments/respondReferral', { method: 'POST', body: formData });
        const json = await response.json().catch(() => ({ success: false, message: 'Unexpected server response.' }));
        if (!json.success) {
            showToast(json.message || 'Could not update referral.', 'error');
            return;
        }
        persistToast(json.message || 'Referral updated successfully.', 'success');
        window.location.reload();
    });
});

document.querySelectorAll('[data-search-target]').forEach((input) => {
    input.addEventListener('input', () => applyFilters(input.dataset.searchTarget));
});

document.querySelectorAll('[data-filter-target]').forEach((select) => {
    select.addEventListener('change', () => applyFilters(select.dataset.filterTarget));
});

function applyFilters(group) {
    const search = (document.querySelector(`[data-search-target="${group}"]`)?.value || '').toLowerCase().trim();
    const status = (document.querySelector(`[data-filter-target="${group}"]`)?.value || '').toLowerCase().trim();
    document.querySelectorAll(`.searchable-card[data-group="${group}"]`).forEach((card) => {
        const haystack = card.dataset.search || '';
        const cardStatus = card.dataset.status || '';
        const matchesSearch = !search || haystack.includes(search);
        const matchesStatus = !status || cardStatus === status;
        card.style.display = matchesSearch && matchesStatus ? '' : 'none';
    });
}
</script>
<?php require_once '../app/views/partials/theme_toggle.php'; ?>
</body>
</html>
