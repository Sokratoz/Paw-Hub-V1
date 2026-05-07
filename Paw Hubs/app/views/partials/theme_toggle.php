<?php
$flashSuccess = $_SESSION['flash_success'] ?? null;
$flashError = $_SESSION['flash_error'] ?? null;
$flashInfo = $_SESSION['flash_info'] ?? null;
$flashWarning = $_SESSION['flash_warning'] ?? null;
unset($_SESSION['flash_success'], $_SESSION['flash_error'], $_SESSION['flash_info'], $_SESSION['flash_warning']);
?>
<button class="theme-toggle" id="themeToggle" type="button" aria-label="Toggle dark mode" aria-pressed="false">
    <span class="theme-toggle-track">
        <span class="theme-toggle-thumb">
            <i class="fas fa-sun theme-icon theme-icon-sun"></i>
            <i class="fas fa-moon theme-icon theme-icon-moon"></i>
        </span>
    </span>
</button>

<div class="global-toast-stack" id="globalToastStack" aria-live="polite" aria-atomic="true"></div>

<style>
:root {
    color-scheme: light;
    --dm-bg: #0F1A1A;
    --dm-bg-2: #162424;
    --dm-card: #1D2E2E;
    --dm-accent: #4FA89A;
    --dm-green: #7FB85D;
    --dm-blue: #4D96A1;
    --dm-border: #2C4545;
    --dm-text: #EAF6F3;
    --dm-text-2: #A9C3BD;
    --dm-danger: #D96B6B;
}

html.theme-ready body,
html.theme-ready body *,
html.theme-ready body *::before,
html.theme-ready body *::after {
    transition: background-color 220ms ease, color 220ms ease, border-color 220ms ease, box-shadow 220ms ease, opacity 220ms ease, transform 220ms ease;
}

body.dark-mode {
    color-scheme: dark;
    background: var(--dm-bg) !important;
    color: var(--dm-text) !important;
}

body.dark-mode,
body.dark-mode .content,
body.dark-mode .page-shell,
body.dark-mode .profile-shell,
body.dark-mode .footer-shell,
body.dark-mode .footer-bottom,
body.dark-mode .marketplace-section,
body.dark-mode .dashboard {
    background-color: var(--dm-bg) !important;
}

body.dark-mode .navbar,
body.dark-mode .nav-container,
body.dark-mode .dropdown,
body.dark-mode .notifications-dropdown,
body.dark-mode .app-frame,
body.dark-mode .sidebar,
body.dark-mode .topbar,
body.dark-mode .panel,
body.dark-mode .stat-card,
body.dark-mode .hero,
body.dark-mode .hero-card,
body.dark-mode .card,
body.dark-mode .profile-card,
body.dark-mode .identity-panel,
body.dark-mode .edit-panel,
body.dark-mode .history-card,
body.dark-mode .item,
body.dark-mode .report-card,
body.dark-mode .insight-card,
body.dark-mode .recommended,
body.dark-mode .pet-card,
body.dark-mode .features-band,
body.dark-mode .section-card,
body.dark-mode .list-card,
body.dark-mode .table-card,
body.dark-mode .mini-card,
body.dark-mode .glass-card,
body.dark-mode .hero-side,
body.dark-mode .modal-panel,
body.dark-mode .theme-toggle,
body.dark-mode .product,
body.dark-mode .market-card,
body.dark-mode .marketplace-card,
body.dark-mode .notification-item,
body.dark-mode .search,
body.dark-mode .quick-link,
body.dark-mode .feed-item,
body.dark-mode .stat-card,
body.dark-mode .empty-state {
    background: var(--dm-card) !important;
    color: var(--dm-text) !important;
    border-color: var(--dm-border) !important;
    box-shadow: 0 18px 40px rgba(0, 0, 0, 0.28) !important;
}

body.dark-mode input,
body.dark-mode select,
body.dark-mode textarea,
body.dark-mode .form-control,
body.dark-mode .input,
body.dark-mode .select,
body.dark-mode .textarea,
body.dark-mode .search,
body.dark-mode .icon-btn,
body.dark-mode .upload-field,
body.dark-mode .upload-box,
body.dark-mode .input-wrapper input {
    background: var(--dm-bg-2) !important;
    color: var(--dm-text) !important;
    border-color: var(--dm-border) !important;
}

body.dark-mode h1,
body.dark-mode h2,
body.dark-mode h3,
body.dark-mode h4,
body.dark-mode strong,
body.dark-mode .logo span,
body.dark-mode .brand,
body.dark-mode .nav-links a,
body.dark-mode .dropdown a,
body.dark-mode .notification-title,
body.dark-mode th,
body.dark-mode td strong {
    color: var(--dm-text) !important;
}

body.dark-mode p,
body.dark-mode span,
body.dark-mode small,
body.dark-mode td,
body.dark-mode .meta,
body.dark-mode .muted,
body.dark-mode .subtle,
body.dark-mode .notification-message,
body.dark-mode .notification-time,
body.dark-mode .field label,
body.dark-mode .pet-meta,
body.dark-mode .product-meta,
body.dark-mode .empty,
body.dark-mode .empty-state,
body.dark-mode .footer-bottom,
body.dark-mode .footer-bottom a {
    color: var(--dm-text-2) !important;
}

body.dark-mode a,
body.dark-mode .panel h2,
body.dark-mode .file-link,
body.dark-mode .marketplace-label {
    color: var(--dm-blue) !important;
}

body.dark-mode .nav-links a:hover,
body.dark-mode .nav-links a.active,
body.dark-mode .dropdown a:hover,
body.dark-mode .quick-link:hover,
body.dark-mode .chip,
body.dark-mode .role-pill,
body.dark-mode .badge,
body.dark-mode .stat-icon,
body.dark-mode .brand i,
body.dark-mode .product-cart,
body.dark-mode .market-wishlist,
body.dark-mode .theme-toggle-track {
    background: rgba(79, 168, 154, 0.18) !important;
    color: var(--dm-accent) !important;
}

body.dark-mode .btn.primary,
body.dark-mode .action-btn.primary,
body.dark-mode button[type="submit"],
body.dark-mode .save-btn,
body.dark-mode .market-add,
body.dark-mode .marketplace-cta {
    background: linear-gradient(135deg, var(--dm-accent), var(--dm-blue)) !important;
    color: #ffffff !important;
    border-color: transparent !important;
}

body.dark-mode .btn.danger,
body.dark-mode .badge.rejected,
body.dark-mode .badge.cancelled {
    color: var(--dm-danger) !important;
}

body.dark-mode .btn.secondary,
body.dark-mode .btn.ghost,
body.dark-mode .action-btn,
body.dark-mode .marketplace-view-all {
    background: var(--dm-bg-2) !important;
    color: var(--dm-text) !important;
    border-color: var(--dm-border) !important;
}

body.dark-mode table,
body.dark-mode th,
body.dark-mode td,
body.dark-mode .audit-table td {
    border-color: var(--dm-border) !important;
}

body.dark-mode .modal,
body.dark-mode .modal-backdrop,
body.dark-mode .history-modal,
body.dark-mode .rules-modal {
    background: rgba(2, 12, 12, 0.74) !important;
}

.theme-toggle {
    position: fixed;
    right: 20px;
    bottom: 20px;
    width: 74px;
    height: 42px;
    border: 0;
    padding: 0;
    background: transparent;
    cursor: pointer;
    z-index: 4000;
}

.theme-toggle-track {
    width: 100%;
    height: 100%;
    border-radius: 999px;
    background: linear-gradient(135deg, #dff4ed, #cfe8ef);
    box-shadow: 0 16px 30px rgba(79, 145, 134, 0.2);
    border: 1px solid rgba(79, 168, 154, 0.2);
    display: block;
    position: relative;
    overflow: hidden;
}

.theme-toggle-thumb {
    position: absolute;
    top: 4px;
    left: 4px;
    width: 34px;
    height: 34px;
    border-radius: 50%;
    background: #ffffff;
    display: grid;
    place-items: center;
    box-shadow: 0 12px 22px rgba(36, 70, 64, 0.18);
    transition: transform 260ms cubic-bezier(.2,.8,.2,1), background-color 220ms ease;
}

.theme-icon {
    position: absolute;
    font-size: 14px;
    transition: opacity 240ms ease, transform 260ms ease;
}

.theme-icon-moon { opacity: 0; transform: rotate(-45deg) scale(0.65); color: var(--dm-blue); }
.theme-icon-sun { opacity: 1; transform: rotate(0deg) scale(1); color: #f2b84b; }

body.dark-mode .theme-toggle-track {
    background: linear-gradient(135deg, var(--dm-bg-2), var(--dm-card)) !important;
    border-color: var(--dm-border) !important;
}

body.dark-mode .theme-toggle-thumb {
    transform: translateX(32px);
    background: #dceceb;
}

body.dark-mode .theme-icon-sun { opacity: 0; transform: rotate(45deg) scale(0.6); }
body.dark-mode .theme-icon-moon { opacity: 1; transform: rotate(0deg) scale(1); }

.global-toast-stack {
    position: fixed;
    right: 20px;
    bottom: 76px;
    display: grid;
    gap: 12px;
    z-index: 3999;
}

.global-toast {
    min-width: 260px;
    max-width: 360px;
    padding: 16px 18px;
    border-radius: 18px;
    color: #fff;
    box-shadow: 0 20px 40px rgba(23, 46, 41, 0.28);
    opacity: 0;
    transform: translateY(12px);
    animation: toastIn 260ms ease forwards;
}

.global-toast.success { background: linear-gradient(135deg, #4FA89A, #7FB85D); }
.global-toast.error { background: linear-gradient(135deg, #D96B6B, #b95858); }
.global-toast.info { background: linear-gradient(135deg, #4D96A1, #4FA89A); }
.global-toast.warning { background: linear-gradient(135deg, #c18d3e, #7FB85D); }

@keyframes toastIn {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@media (max-width: 680px) {
    .theme-toggle {
        right: 14px;
        bottom: 14px;
    }

    .global-toast-stack {
        left: 14px;
        right: 14px;
        bottom: 66px;
    }

    .global-toast {
        min-width: 0;
        max-width: none;
    }
}
</style>

<script>
(function () {
    const storageKey = 'pawhubs-theme';
    const root = document.documentElement;
    const body = document.body;

    function applyTheme(theme) {
        body.classList.toggle('dark-mode', theme === 'dark');
        const button = document.getElementById('themeToggle');
        if (button) {
            button.setAttribute('aria-pressed', theme === 'dark' ? 'true' : 'false');
        }
    }

    const savedTheme = localStorage.getItem(storageKey);
    if (savedTheme) {
        applyTheme(savedTheme);
    }

    document.addEventListener('DOMContentLoaded', function () {
        root.classList.add('theme-ready');
        const button = document.getElementById('themeToggle');
        applyTheme(localStorage.getItem(storageKey) || 'light');

        if (button) {
            button.addEventListener('click', function () {
                const nextTheme = body.classList.contains('dark-mode') ? 'light' : 'dark';
                localStorage.setItem(storageKey, nextTheme);
                applyTheme(nextTheme);
            });
        }

        window.PawHubsToast = function (message, type) {
            const stack = document.getElementById('globalToastStack');
            if (!stack || !message) return;
            const toast = document.createElement('div');
            toast.className = 'global-toast ' + (type || 'info');
            toast.textContent = message;
            stack.appendChild(toast);
            window.setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transform = 'translateY(10px)';
                window.setTimeout(() => toast.remove(), 220);
            }, 3400);
        };

        <?php if ($flashSuccess): ?>window.PawHubsToast(<?= json_encode($flashSuccess) ?>, 'success');<?php endif; ?>
        <?php if ($flashError): ?>window.PawHubsToast(<?= json_encode($flashError) ?>, 'error');<?php endif; ?>
        <?php if ($flashInfo): ?>window.PawHubsToast(<?= json_encode($flashInfo) ?>, 'info');<?php endif; ?>
        <?php if ($flashWarning): ?>window.PawHubsToast(<?= json_encode($flashWarning) ?>, 'warning');<?php endif; ?>
    });
})();
</script>
