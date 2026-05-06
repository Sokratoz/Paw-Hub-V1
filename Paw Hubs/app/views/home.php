<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home | Paw Hubs</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root {
            --teal: #6BB5A8;
            --teal-dark: #4f9186;
            --green: #9BC870;
            --olive: #CAD7A5;
            --mint: #C8E4D6;
            --sky: #94CDD3;
            --ink: #2f4f4f;
            --muted: #718096;
            --line: #d8ebe5;
            --panel: #ffffff;
            --soft: #f5faf8;
        }

        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: 'Outfit', sans-serif;
            background: #f5faf8;
            color: var(--ink);
        }

        .page-shell {
            max-width: 1440px;
            margin: 0 auto;
            padding: 0 34px 22px;
        }

        .hero {
            min-height: 360px;
            border-radius: 28px;
            margin-top: 26px;
            overflow: hidden;
            position: relative;
            display: grid;
            grid-template-columns: 1.1fr 0.9fr;
            gap: 24px;
            background: linear-gradient(135deg, #f8fefa 0%, #eef7f1 100%);
            box-shadow: 0 26px 70px rgba(76, 141, 121, 0.12);
        }

        .hero-copy {
            padding: 54px 56px;
            position: relative;
            z-index: 2;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .hero h1 {
            margin: 0 0 14px;
            font-size: 44px;
            line-height: 1.05;
            color: #20524c;
            letter-spacing: -0.02em;
            max-width: 520px;
        }

        .hero p {
            color: #546d64;
            font-size: 18px;
            line-height: 1.6;
            max-width: 520px;
            margin: 0;
        }

        .hero-actions {
            display: flex;
            gap: 18px;
            margin-top: 32px;
            flex-wrap: wrap;
        }

        .btn {
            min-height: 54px;
            padding: 0 26px;
            border: 1px solid transparent;
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            color: var(--teal-dark);
            background: #ffffff;
            text-decoration: none;
            font-weight: 700;
            box-shadow: 0 14px 30px rgba(79, 145, 134, 0.08);
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }

        .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 18px 36px rgba(79, 145, 134, 0.12);
        }

        .btn.primary {
            background: linear-gradient(135deg, var(--teal), var(--sky));
            color: #fff;
            border-color: transparent;
            box-shadow: 0 16px 34px rgba(19, 92, 82, 0.18);
        }

        .hero-art {
            position: relative;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            padding: 32px;
            min-height: 360px;
        }

        .hero-art img {
            width: min(560px, 100%);
            height: auto;
            object-fit: contain;
            position: relative;
            z-index: 1;
        }

        .stats-grid {
            margin-top: 28px;
            display: grid;
            grid-template-columns: repeat(5, minmax(160px, 1fr));
            gap: 22px;
        }

        .stat-card,
        .panel,
        .features-band {
            background: var(--panel);
            border: 1px solid var(--line);
            border-radius: 14px;
            box-shadow: 0 14px 35px rgba(107, 181, 168, 0.08);
        }

        .stat-card {
            min-height: 114px;
            padding: 20px 18px;
            display: flex;
            align-items: center;
            gap: 18px;
        }

        .stat-icon,
        .feature-icon,
        .product-cart {
            width: 72px;
            height: 72px;
            border-radius: 13px;
            display: grid;
            place-items: center;
            flex: 0 0 auto;
            font-size: 29px;
        }

        .tone-teal { background: var(--mint); color: var(--teal-dark); }
        .tone-green { background: var(--green); color: #ffffff; }
        .tone-blue { background: var(--sky); color: #ffffff; }
        .tone-olive { background: var(--olive); color: #4f6f35; }

        .stat-card span,
        .product-meta,
        .pet-meta,
        .feature p {
            color: var(--muted);
        }

        .stat-card span {
            display: block;
            font-size: 14px;
            margin-bottom: 8px;
        }

        .stat-card strong {
            display: block;
            color: var(--ink);
            font-size: 24px;
            line-height: 1.1;
        }

        .stat-card small {
            color: var(--muted);
            font-size: 14px;
        }

        .content-grid {
            display: grid;
            grid-template-columns: 1.45fr 0.95fr;
            gap: 24px;
            margin-top: 24px;
        }

        .panel {
            padding: 24px;
        }

        .panel-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 22px;
            gap: 16px;
        }

        .panel h2 {
            margin: 0;
            color: var(--teal);
            font-size: 24px;
            line-height: 1.2;
        }

        .panel-header a {
            color: var(--teal);
            text-decoration: none;
            font-weight: 700;
            font-size: 14px;
        }

        .pets-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(210px, 1fr));
            gap: 22px;
        }

        .pet-card {
            min-height: 290px;
            border: 1px solid var(--line);
            border-radius: 12px;
            padding: 26px 18px 18px;
            text-align: center;
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .pet-badge {
            position: absolute;
            right: 18px;
            top: 18px;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: grid;
            place-items: center;
            color: #fff;
            background: var(--teal);
        }

        .pet-avatar,
        .add-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            display: grid;
            place-items: center;
            margin-bottom: 18px;
        }

        .pet-avatar {
            background: var(--mint);
            overflow: hidden;
        }

        .pet-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .pet-card h3 {
            margin: 0 0 6px;
            color: var(--teal);
            font-size: 22px;
        }

        .pet-meta {
            margin: 0 0 3px;
            font-size: 14px;
        }

        .pet-action {
            width: 100%;
            min-height: 42px;
            margin-top: auto;
            border: 0;
            border-radius: 8px;
            background: var(--mint);
            color: var(--teal-dark);
            font-weight: 700;
            text-decoration: none;
            display: grid;
            place-items: center;
        }

        .add-card {
            border-style: dashed;
            justify-content: center;
        }

        .add-avatar {
            background: var(--mint);
            border: 1px dashed var(--teal);
            color: var(--teal);
            font-size: 38px;
        }

        .products {
            display: grid;
            gap: 18px;
        }

        .product {
            display: grid;
            grid-template-columns: 88px 1fr 52px;
            gap: 18px;
            align-items: center;
            padding-bottom: 18px;
            border-bottom: 1px solid var(--line);
        }

        .product:last-child {
            border-bottom: 0;
            padding-bottom: 0;
        }

        .product-image {
            width: 84px;
            height: 84px;
            border-radius: 8px;
            background: var(--soft);
            display: grid;
            place-items: center;
            overflow: hidden;
        }

        .product-image img {
            width: 80%;
            height: 80%;
            object-fit: contain;
        }

        .product h3 {
            margin: 0 0 6px;
            font-size: 18px;
        }

        .product-meta,
        .product-price {
            margin: 0;
            font-size: 15px;
        }

        .product-price {
            color: var(--ink);
            font-weight: 700;
            margin-top: 8px;
        }

        .product-cart {
            width: 48px;
            height: 48px;
            color: #fff;
            border: 0;
            border-radius: 8px;
            font-size: 18px;
        }

        .features-band {
            margin-top: 24px;
            padding: 30px 24px;
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 20px;
        }

        .feature {
            display: grid;
            grid-template-columns: 72px 1fr;
            align-items: center;
            gap: 14px;
        }

        .feature h3 {
            margin: 0 0 6px;
            color: var(--teal-dark);
            font-size: 17px;
        }

        .feature p {
            margin: 0;
            font-size: 14px;
            line-height: 1.45;
        }

        @media (max-width: 1100px) {
            .stats-grid,
            .features-band {
                grid-template-columns: repeat(2, 1fr);
            }

            .content-grid,
            .hero {
                grid-template-columns: 1fr;
            }

            .hero-art {
                min-height: 230px;
            }
        }

        @media (max-width: 680px) {
            .page-shell {
                padding: 0 16px 18px;
            }

            .hero-copy {
                padding: 34px 24px;
            }

            .hero h1 {
                font-size: 30px;
            }

            .hero p {
                font-size: 17px;
            }

            .stats-grid,
            .features-band,
            .pets-grid {
                grid-template-columns: 1fr;
            }

            .product {
                grid-template-columns: 70px 1fr 44px;
                gap: 12px;
            }

            .product-image {
                width: 68px;
                height: 68px;
            }

            .feature {
                grid-template-columns: 60px 1fr;
            }
        }
    </style>
</head>
<body>

<?php require_once '../app/views/partials/navbar.php'; ?>

<?php
$username = isset($username) ? $username : ($_SESSION['username'] ?? 'Guest');
$pets = isset($pets) && is_array($pets) ? $pets : [];
$stats = isset($stats) && is_array($stats) ? $stats : [
    'appointment_date' => 'No upcoming',
    'appointment_type' => 'Book your first visit',
    'vaccines_due' => 0,
    'health_records' => 0,
    'wellness_score' => 0,
    'loyalty_points' => 0
];
$recommendedProducts = isset($recommendedProducts) && is_array($recommendedProducts) ? $recommendedProducts : [];

$firstName = explode(' ', trim($username))[0] ?: 'Guest';
$displayPets = array_slice($pets, 0, 2);
?>

<main class="page-shell">
    <section class="hero">
        <div class="hero-copy">
            <h1>Welcome back, <?= htmlspecialchars($firstName) ?>! 👋</h1>
            <p>Track your pet's health, book appointments, and find the best products for them.</p>
            <div class="hero-actions">
                <a href="index.php?url=appointments/index" class="btn primary"><i class="far fa-calendar-plus"></i> Book Appointment</a>
                <a href="#my-pets" class="btn"><i class="fas fa-paw"></i> View My Pets</a>
            </div>
        </div>
        <div class="hero-art">
            <img src="images/hero-dog-cat.png" alt="Dog and cat together">
        </div>
    </section>

    <section class="stats-grid" aria-label="Dashboard summary">
        <article class="stat-card">
            <div class="stat-icon tone-teal"><i class="far fa-calendar-alt"></i></div>
            <div>
                <span>Upcoming Appointment</span>
                <strong><?= htmlspecialchars($stats['appointment_date'] ?? 'No upcoming') ?></strong>
                <small><?= htmlspecialchars($stats['appointment_type'] ?? 'Book your first visit') ?></small>
            </div>
        </article>
        <article class="stat-card">
            <div class="stat-icon tone-green"><i class="fas fa-shield-heart"></i></div>
            <div>
                <span>Vaccines Due</span>
                <strong><?= (int) ($stats['vaccines_due'] ?? 0) ?></strong>
                <small>View Details</small>
            </div>
        </article>
        <article class="stat-card">
            <div class="stat-icon tone-olive"><i class="fas fa-notes-medical"></i></div>
            <div>
                <span>Health Records</span>
                <strong><?= (int) ($stats['health_records'] ?? 0) ?></strong>
                <small>View All</small>
            </div>
        </article>
        <article class="stat-card">
            <div class="stat-icon tone-teal"><i class="fas fa-heart-pulse"></i></div>
            <div>
                <span>Wellness Score</span>
                <strong><?= (int) ($stats['wellness_score'] ?? 0) ?>%</strong>
                <small><?= ((int) ($stats['wellness_score'] ?? 0)) > 0 ? 'Excellent' : 'No data yet' ?></small>
            </div>
        </article>
        <article class="stat-card">
            <div class="stat-icon tone-blue"><i class="fas fa-bag-shopping"></i></div>
            <div>
                <span>Loyalty Points</span>
                <strong><?= (int) ($stats['loyalty_points'] ?? 0) ?></strong>
                <small>View Rewards</small>
            </div>
        </article>
    </section>

    <section class="content-grid">
        <div class="panel" id="my-pets">
            <div class="panel-header">
                <h2>My Pets</h2>
            </div>
            <div class="pets-grid">
                <?php foreach ($displayPets as $index => $pet): ?>
                    <?php
                    $isCat = stripos($pet['species'], 'cat') !== false;
                    $avatar = $isCat ? 'guest.png' : 'Welcome.png';
                    ?>
                    <article class="pet-card">
                        <div class="pet-badge <?= $index % 2 ? 'tone-green' : '' ?>"><i class="fas fa-paw"></i></div>
                        <div class="pet-avatar">
                            <img src="images/<?= htmlspecialchars($avatar) ?>" alt="<?= htmlspecialchars($pet['name']) ?>">
                        </div>
                        <h3><?= htmlspecialchars($pet['name']) ?></h3>
                        <p class="pet-meta"><?= htmlspecialchars($pet['species']) ?></p>
                        <p class="pet-meta"><?= (int) $pet['age'] ?> Years</p>
                        <a href="#" class="pet-action">View Profile</a>
                    </article>
                <?php endforeach; ?>

                <article class="pet-card add-card">
                    <div class="add-avatar"><i class="fas fa-plus"></i></div>
                    <h3>Add New Pet</h3>
                    <p class="pet-meta">Add your pet to get started</p>
                </article>
            </div>
        </div>

        <div class="panel">
            <div class="panel-header">
                <h2>Recommended For You</h2>
                <a href="#">View All</a>
            </div>
            <div class="products">
                <?php foreach ($recommendedProducts as $product): ?>
                    <article class="product">
                        <div class="product-image">
                            <img src="images/<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
                        </div>
                        <div>
                            <h3><?= htmlspecialchars($product['name']) ?></h3>
                            <p class="product-meta"><?= htmlspecialchars($product['meta']) ?></p>
                            <p class="product-price"><?= htmlspecialchars($product['price']) ?></p>
                        </div>
                        <button class="product-cart tone-<?= htmlspecialchars($product['tone']) ?>" type="button" aria-label="Add <?= htmlspecialchars($product['name']) ?> to cart">
                            <i class="fas fa-cart-shopping"></i>
                        </button>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="features-band">
        <div class="feature">
            <div class="feature-icon tone-teal"><i class="fas fa-user-doctor"></i></div>
            <div><h3>Expert Vet Care</h3><p>Professional vets you can trust</p></div>
        </div>
        <div class="feature">
            <div class="feature-icon tone-green"><i class="fas fa-heart"></i></div>
            <div><h3>Health Tracking</h3><p>Keep track of vaccines, medications & more</p></div>
        </div>
        <div class="feature">
            <div class="feature-icon tone-olive"><i class="fas fa-bag-shopping"></i></div>
            <div><h3>Quality Products</h3><p>Curated products for your pet's well-being</p></div>
        </div>
        <div class="feature">
            <div class="feature-icon tone-teal"><i class="fas fa-truck-fast"></i></div>
            <div><h3>Fast Delivery</h3><p>Quick & reliable delivery to your doorstep</p></div>
        </div>
        <div class="feature">
            <div class="feature-icon tone-blue"><i class="fas fa-headset"></i></div>
            <div><h3>24/7 Support</h3><p>We're here for you anytime</p></div>
        </div>
    </section>

</main>

<?php require_once '../app/views/partials/footer.php'; ?>
<?php require_once '../app/views/partials/theme_toggle.php'; ?>

</body>
</html>
