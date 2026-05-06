<button class="theme-toggle" id="themeToggle" type="button" aria-label="Toggle dark mode">
    <i class="fas fa-moon"></i>
</button>

<style>
.theme-toggle {
    position: fixed;
    right: 22px;
    bottom: 22px;
    width: 52px;
    height: 52px;
    border: 1px solid #d8ebe5;
    border-radius: 50%;
    display: grid;
    place-items: center;
    background: #ffffff;
    color: #4f9186;
    font-size: 18px;
    cursor: pointer;
    z-index: 4000;
    box-shadow: 0 16px 34px rgba(107, 181, 168, 0.22);
}

.theme-toggle:hover {
    transform: translateY(-2px);
}

body.dark-mode {
    background: #162323 !important;
    color: #dfeeea !important;
}

body.dark-mode .theme-toggle {
    background: #263838;
    color: #CAD7A5;
    border-color: rgba(200, 228, 214, 0.18);
    box-shadow: 0 16px 36px rgba(0, 0, 0, 0.35);
}

body.dark-mode .theme-toggle i::before {
    content: "\f185";
}

body.dark-mode .navbar,
body.dark-mode .nav-container,
body.dark-mode .login-container,
body.dark-mode .register-container,
body.dark-mode .panel,
body.dark-mode .module-heading,
body.dark-mode .stat-card,
body.dark-mode .profile-card,
body.dark-mode .identity-panel,
body.dark-mode .edit-panel,
body.dark-mode .history-card,
body.dark-mode .dropdown,
body.dark-mode .main-footer,
body.dark-mode .app-frame,
body.dark-mode .sidebar,
body.dark-mode .topbar,
body.dark-mode .item,
body.dark-mode .history-modal,
body.dark-mode .rules-modal,
body.dark-mode .card,
body.dark-mode .shortcut,
body.dark-mode .report-card,
body.dark-mode .insight-card,
body.dark-mode .recommended,
body.dark-mode .pet-card,
body.dark-mode .features-band {
    background: #223232 !important;
    color: #dfeeea !important;
    border-color: rgba(200, 228, 214, 0.16) !important;
    box-shadow: 0 18px 45px rgba(0, 0, 0, 0.22) !important;
}

body.dark-mode .content,
body.dark-mode .profile-shell,
body.dark-mode .page-shell,
body.dark-mode .hero,
body.dark-mode .footer-shell,
body.dark-mode .footer-bottom {
    background: transparent !important;
}

body.dark-mode .hero {
    background:
        radial-gradient(circle at 80% 22%, rgba(148, 205, 211, 0.18), transparent 28%),
        linear-gradient(105deg, #223232 0%, #223232 45%, #2d4441 100%) !important;
}

body.dark-mode h1,
body.dark-mode h2,
body.dark-mode h3,
body.dark-mode strong,
body.dark-mode .logo span,
body.dark-mode .brand,
body.dark-mode .footer-logo strong,
body.dark-mode .nav-links a,
body.dark-mode .dropdown a,
body.dark-mode .field label,
body.dark-mode .table-item,
body.dark-mode .audit-table td {
    color: #eaf7f3 !important;
}

body.dark-mode p,
body.dark-mode span,
body.dark-mode small,
body.dark-mode .muted,
body.dark-mode .pet-meta,
body.dark-mode .product-meta,
body.dark-mode .mini-info span,
body.dark-mode .detail-item span,
body.dark-mode .footer-brand p,
body.dark-mode .footer-bottom,
body.dark-mode .footer-bottom a {
    color: #a9c3bd !important;
}

body.dark-mode a,
body.dark-mode .panel h2,
body.dark-mode .footer-links-grid h3,
body.dark-mode .footer-links-grid a:hover,
body.dark-mode .footer-mini-links a:hover {
    color: #94CDD3 !important;
}

body.dark-mode input,
body.dark-mode select,
body.dark-mode textarea,
body.dark-mode .search,
body.dark-mode .input-wrapper input,
body.dark-mode .field input,
body.dark-mode .upload-field,
body.dark-mode .upload-box,
body.dark-mode .product-image,
body.dark-mode .pet-avatar,
body.dark-mode .empty,
body.dark-mode .detail-item,
body.dark-mode .form-control,
body.dark-mode .icon-btn {
    background: #182727 !important;
    color: #eaf7f3 !important;
    border-color: rgba(200, 228, 214, 0.16) !important;
}

body.dark-mode th,
body.dark-mode td,
body.dark-mode .report-card p,
body.dark-mode .shortcut span,
body.dark-mode .module-heading p,
body.dark-mode .meta {
    color: #a9c3bd !important;
    border-color: rgba(200, 228, 214, 0.12) !important;
}

body.dark-mode .nav-links a:hover,
body.dark-mode .nav-links a.active,
body.dark-mode .dropdown a:hover,
body.dark-mode .pet-action,
body.dark-mode .badge,
body.dark-mode .stat-icon,
body.dark-mode .history-icon,
body.dark-mode .feature-icon,
body.dark-mode .footer-logo i {
    background: rgba(107, 181, 168, 0.22) !important;
    color: #CAD7A5 !important;
}

body.dark-mode .btn.primary,
body.dark-mode button[type="submit"],
body.dark-mode .save-btn,
body.dark-mode .action-btn.primary,
body.dark-mode .product-cart,
body.dark-mode .social-links a:hover {
    background: linear-gradient(135deg, #6BB5A8, #94CDD3) !important;
    color: #ffffff !important;
}

body.dark-mode .modal-backdrop {
    background: rgba(0, 0, 0, 0.62) !important;
}

@media (max-width: 600px) {
    .theme-toggle {
        right: 16px;
        bottom: 16px;
    }
}
</style>

<script>
(function () {
    const storageKey = 'pawhubs-theme';

    function applyTheme(theme) {
        document.body.classList.toggle('dark-mode', theme === 'dark');
    }

    applyTheme(localStorage.getItem(storageKey));

    document.addEventListener('DOMContentLoaded', function () {
        const button = document.getElementById('themeToggle');
        applyTheme(localStorage.getItem(storageKey));

        if (!button) return;
        button.addEventListener('click', function () {
            const nextTheme = document.body.classList.contains('dark-mode') ? 'light' : 'dark';
            localStorage.setItem(storageKey, nextTheme);
            applyTheme(nextTheme);
        });
    });
})();
</script>
