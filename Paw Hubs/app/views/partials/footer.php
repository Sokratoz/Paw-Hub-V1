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
?>

<footer class="main-footer">
    <div class="footer-shell">
        <div class="footer-brand">
            <div class="footer-logo">
                <i class="fas fa-paw"></i>
                <div>
                    <strong>Paw Hubs</strong>
                    <span>Care • Love • Health</span>
                </div>
            </div>
            <p>Everything your dog or cat needs in one friendly place: health tracking, vet appointments, services, and trusted pet products.</p>
            <div class="social-links" aria-label="Social media links">
                <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                <a href="#" aria-label="X Twitter"><i class="fab fa-x-twitter"></i></a>
                <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                <a href="#" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                <a href="#" aria-label="TikTok"><i class="fab fa-tiktok"></i></a>
                <a href="#" aria-label="WhatsApp"><i class="fab fa-whatsapp"></i></a>
            </div>
        </div>

        <div class="footer-links-grid">
            <div>
                <h3>Explore</h3>
                <a href="index.php?url=home/index">Home</a>
                <a href="#">My Pets</a>
                <a href="#">Health</a>
                <a href="#">Appointments</a>
            </div>
            <div>
                <h3>Services</h3>
                <a href="#">Marketplace</a>
                <a href="#">Vet Care</a>
                <a href="index.php?url=clinical/index">Clinical Operations</a>
                <a href="#">Service Providers</a>
                <a href="#">Delivery</a>
            </div>
            <div>
                <h3>Account</h3>
                <a href="index.php?url=user/profile">My Profile</a>
                <a href="#">Settings</a>
                <a href="index.php?url=auth/login">Login</a>
                <a href="index.php?url=auth/register">Create Account</a>
            </div>
            <div>
                <h3>Support</h3>
                <a href="index.php?url=about/index">About Us</a>
                <a href="#">Contact Us</a>
                <a href="#">Privacy Policy</a>
                <a href="#">Terms & Conditions</a>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <span>© <?= date('Y') ?> Paw Hubs. All rights reserved.</span>
        <span class="footer-mini-links">
            <a href="#">Animal Welfare</a>
            <a href="#">Safety Rules</a>
            <a href="#">Help Center</a>
        </span>
    </div>
</footer>

<style>
.main-footer {
    margin-top: 34px;
    background:
        radial-gradient(circle at 12% 18%, rgba(148, 205, 211, 0.22), transparent 28%),
        linear-gradient(135deg, #ffffff 0%, #f5faf8 48%, #C8E4D6 100%);
    border-top: 1px solid #d8ebe5;
    color: #2f4f4f;
}

.footer-shell {
    max-width: 1440px;
    margin: 0 auto;
    padding: 42px 34px 28px;
    display: grid;
    grid-template-columns: minmax(280px, 1.05fr) 2fr;
    gap: 42px;
}

.footer-logo {
    display: flex;
    align-items: center;
    gap: 14px;
    color: #6BB5A8;
}

.footer-logo i {
    width: 54px;
    height: 54px;
    border-radius: 16px;
    display: grid;
    place-items: center;
    background: #C8E4D6;
    font-size: 28px;
}

.footer-logo strong {
    display: block;
    font-size: 26px;
    line-height: 1;
}

.footer-logo span,
.footer-brand p,
.footer-bottom,
.footer-bottom a {
    color: #718096;
}

.footer-logo span {
    font-size: 12px;
    font-weight: 700;
}

.footer-brand p {
    max-width: 410px;
    margin: 18px 0 22px;
    line-height: 1.65;
}

.social-links {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

.social-links a {
    width: 40px;
    height: 40px;
    border-radius: 12px;
    display: grid;
    place-items: center;
    color: #4f9186;
    background: #ffffff;
    border: 1px solid #d8ebe5;
    text-decoration: none;
    box-shadow: 0 10px 22px rgba(107, 181, 168, 0.10);
}

.social-links a:hover {
    background: #6BB5A8;
    color: #ffffff;
    transform: translateY(-2px);
}

.footer-links-grid {
    display: grid;
    grid-template-columns: repeat(4, minmax(130px, 1fr));
    gap: 24px;
}

.footer-links-grid h3 {
    margin: 0 0 14px;
    color: #4f9186;
    font-size: 17px;
}

.footer-links-grid a,
.footer-mini-links a {
    display: block;
    color: #2f4f4f;
    text-decoration: none;
    margin-bottom: 10px;
    font-weight: 600;
    font-size: 14px;
}

.footer-links-grid a:hover,
.footer-mini-links a:hover {
    color: #6BB5A8;
}

.footer-bottom {
    max-width: 1440px;
    margin: 0 auto;
    padding: 18px 34px 24px;
    border-top: 1px solid #d8ebe5;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 18px;
    flex-wrap: wrap;
    font-size: 14px;
}

.footer-mini-links {
    display: flex;
    gap: 22px;
    flex-wrap: wrap;
}

.footer-mini-links a {
    margin: 0;
    color: #718096;
}

@media (max-width: 900px) {
    .footer-shell {
        grid-template-columns: 1fr;
    }

    .footer-links-grid {
        grid-template-columns: repeat(2, minmax(130px, 1fr));
    }
}

@media (max-width: 560px) {
    .footer-shell,
    .footer-bottom {
        padding-left: 16px;
        padding-right: 16px;
    }

    .footer-links-grid {
        grid-template-columns: 1fr;
    }
}
</style>
