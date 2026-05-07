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

        .content-grid.single-panel {
            grid-template-columns: 1fr;
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

        /* Marketplace section */
        .marketplace-section {
            margin-top: 24px;
            padding: 34px;
            border-radius: 32px;
            background:
                radial-gradient(circle at top left, rgba(225, 247, 242, 0.9), transparent 24%),
                linear-gradient(180deg, #fbfdfd 0%, #f4f8f8 100%);
            position: relative;
            overflow: hidden;
        }

        .marketplace-section::before,
        .marketplace-section::after {
            content: "";
            position: absolute;
            border-radius: 50%;
            pointer-events: none;
            z-index: 0;
        }

        .marketplace-section::before {
            width: 220px;
            height: 220px;
            right: -90px;
            top: 80px;
            background: radial-gradient(circle, rgba(255, 231, 220, 0.8) 0%, rgba(255, 231, 220, 0) 72%);
        }

        .marketplace-section::after {
            width: 170px;
            height: 170px;
            left: -50px;
            bottom: 40px;
            background: radial-gradient(circle, rgba(220, 242, 241, 0.9) 0%, rgba(220, 242, 241, 0) 72%);
        }

        .marketplace-hero,
        .marketplace-products {
            position: relative;
            z-index: 1;
        }

        .marketplace-hero {
            display: grid;
            grid-template-columns: minmax(0, 1fr) minmax(320px, 520px);
            gap: 28px;
            align-items: stretch;
        }

        .marketplace-copy {
            padding: 10px 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .marketplace-label {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            color: #17B3A3;
            font-size: 14px;
            font-weight: 700;
            letter-spacing: 0.16em;
            text-transform: uppercase;
            margin-bottom: 18px;
        }

        .marketplace-copy h2 {
            margin: 0 0 18px;
            font-size: clamp(34px, 4vw, 58px);
            line-height: 1.04;
            color: #18324d;
            letter-spacing: -0.04em;
            max-width: 620px;
        }

        .marketplace-copy > p {
            margin: 0;
            max-width: 610px;
            color: #61758a;
            font-size: 19px;
            line-height: 1.7;
        }

        .marketplace-features {
            margin-top: 28px;
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px 16px;
        }

        .marketplace-feature {
            display: grid;
            grid-template-columns: 56px 1fr;
            gap: 14px;
            align-items: start;
        }

        .marketplace-feature-icon {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            display: grid;
            place-items: center;
            font-size: 22px;
        }

        .marketplace-feature h3 {
            margin: 0 0 4px;
            color: #1d3348;
            font-size: 17px;
        }

        .marketplace-feature p {
            margin: 0;
            color: #6b7a8c;
            font-size: 14px;
            line-height: 1.55;
        }

        .marketplace-cta {
            margin-top: 28px;
            min-height: 56px;
            padding: 0 28px;
            border-radius: 999px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            text-decoration: none;
            font-weight: 700;
            color: #fff;
            background: linear-gradient(135deg, #17B3A3 0%, #12998b 100%);
            box-shadow: 0 18px 36px rgba(23, 179, 163, 0.2);
            transition: transform 0.24s ease, box-shadow 0.24s ease;
        }

        .marketplace-cta:hover {
            transform: scale(1.03) translateY(-1px);
            box-shadow: 0 22px 44px rgba(23, 179, 163, 0.26);
        }

        .marketplace-card {
            position: relative;
            overflow: hidden;
            border-radius: 40px;
            height: 100%;
            box-shadow: 0 26px 60px rgba(23, 50, 77, 0.12);
            background: linear-gradient(160deg, #f3ece3 0%, #fdf8f3 100%);
        }

        .marketplace-image-wrapper {
            position: relative;
            width: 100%;
            height: 100%;
            min-height: 650px;
            overflow: hidden;
            border-radius: 40px;
        }

        .marketplace-image-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            display: block;
        }

        .marketplace-float {
            position: absolute;
            top: 24px;
            right: 24px;
            min-width: 190px;
            padding: 16px 18px;
            border-radius: 22px;
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(10px);
            box-shadow: 0 18px 36px rgba(28, 54, 74, 0.12);
            display: flex;
            gap: 12px;
            align-items: center;
        }

        .marketplace-float i {
            width: 46px;
            height: 46px;
            border-radius: 50%;
            display: grid;
            place-items: center;
            background: #fff1ea;
            color: #ff8a58;
            font-size: 18px;
        }

        .marketplace-float strong {
            display: block;
            color: #1e3247;
            font-size: 17px;
            line-height: 1.3;
        }

        .marketplace-products {
            margin-top: 34px;
        }

        .marketplace-products-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 20px;
        }

        .marketplace-products-head h3 {
            margin: 0;
            color: #1c3348;
            font-size: clamp(24px, 3vw, 34px);
            letter-spacing: -0.02em;
        }

        .marketplace-view-all {
            min-height: 46px;
            padding: 0 18px;
            border-radius: 999px;
            border: 1px solid #d7ece7;
            color: #179f92;
            text-decoration: none;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.86);
        }

        .marketplace-grid {
            display: grid;
            grid-template-columns: repeat(5, minmax(0, 1fr));
            gap: 18px;
        }

        .market-card {
            background: #ffffff;
            border-radius: 28px;
            padding: 16px;
            box-shadow: 0 18px 36px rgba(28, 54, 74, 0.08);
            transition: transform 0.24s ease, box-shadow 0.24s ease;
            min-width: 0;
        }

        .market-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 24px 42px rgba(28, 54, 74, 0.12);
        }

        .product-image-wrapper {
            position: relative;
            width: 100%;
            height: 240px;
            overflow: hidden;
            border-radius: 24px;
            background: #f4f7f6;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .product-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: 0.4s ease;
            display: block;
        }

        .market-card:hover .product-image {
            transform: scale(1.05);
        }

        .market-wishlist {
            position: absolute;
            top: 12px;
            right: 12px;
            width: 38px;
            height: 38px;
            border: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.94);
            color: #ff8b67;
            display: grid;
            place-items: center;
            box-shadow: 0 10px 24px rgba(33, 51, 68, 0.1);
        }

        .market-card-body {
            padding-top: 16px;
        }

        .market-image-debug {
            margin: 10px 0 0;
            color: #8a98a8;
            font-size: 12px;
            line-height: 1.4;
            word-break: break-all;
        }

        .market-card-body h4 {
            margin: 0 0 6px;
            color: #1e3247;
            font-size: 18px;
        }

        .market-card-body p {
            margin: 0 0 12px;
            color: #708091;
            font-size: 14px;
            line-height: 1.55;
            min-height: 44px;
        }

        .market-rating {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #f2a93b;
            font-size: 14px;
            font-weight: 700;
        }

        .market-rating span {
            color: #6d7d8d;
        }

        .market-card-footer {
            margin-top: 14px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
        }

        .market-price {
            color: #1f3348;
            font-size: 20px;
            font-weight: 700;
        }

        .market-add {
            width: 46px;
            height: 46px;
            border-radius: 16px;
            border: 0;
            background: linear-gradient(135deg, #17B3A3 0%, #0f9789 100%);
            color: #fff;
            display: grid;
            place-items: center;
            box-shadow: 0 14px 28px rgba(23, 179, 163, 0.22);
        }

        .features-band {
            margin-top: 24px;
            padding: 30px 24px;
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 20px;
        }

        /* Services section */
        .services-showcase {
            margin-top: 28px;
            padding: 56px 34px 34px;
            position: relative;
            overflow: hidden;
            background: #ffffff;
            border-radius: 34px;
        }

        .services-showcase::before,
        .services-showcase::after,
        .services-orb,
        .services-heart {
            position: absolute;
            pointer-events: none;
            z-index: 0;
        }

        .services-showcase::before {
            content: "";
            width: 220px;
            height: 220px;
            top: -92px;
            left: -84px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(232, 242, 236, 0.9) 0%, rgba(232, 242, 236, 0) 72%);
        }

        .services-showcase::after {
            content: "";
            width: 180px;
            height: 180px;
            right: -64px;
            top: 112px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(232, 246, 247, 0.9) 0%, rgba(232, 246, 247, 0) 72%);
        }

        .services-orb {
            width: 120px;
            height: 120px;
            left: -20px;
            top: 40px;
            border-radius: 50%;
            border: 1px solid rgba(234, 226, 214, 0.7);
            opacity: 0.7;
        }

        .services-heart {
            color: rgba(255, 163, 145, 0.7);
            font-size: 30px;
            top: 150px;
            left: 220px;
            transform: rotate(-14deg);
        }

        .services-heart.right {
            color: rgba(172, 224, 223, 0.75);
            top: 184px;
            left: auto;
            right: 84px;
            transform: rotate(18deg);
        }

        .services-header {
            max-width: 780px;
            margin: 0 auto 36px;
            text-align: center;
            position: relative;
            z-index: 1;
        }

        .services-badge {
            width: 56px;
            height: 56px;
            margin: 0 auto 8px;
            border-radius: 50%;
            display: grid;
            place-items: center;
            background: linear-gradient(180deg, #f0fbf8 0%, #e5f6f2 100%);
            color: #169aa2;
            font-size: 24px;
            box-shadow: 0 12px 26px rgba(22, 154, 162, 0.12);
        }

        .services-eyebrow {
            display: block;
            color: #169aa2;
            font-size: 14px;
            font-weight: 700;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            margin-bottom: 14px;
        }

        .services-header h2 {
            margin: 0 0 14px;
            font-size: clamp(34px, 4vw, 62px);
            line-height: 1.06;
            color: #18324d;
            letter-spacing: -0.04em;
        }

        .services-header p {
            margin: 0 auto;
            max-width: 700px;
            color: #62748a;
            font-size: 20px;
            line-height: 1.6;
        }

        .services-layout {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 26px;
            position: relative;
            z-index: 1;
            align-items: stretch;
        }

        /* Large service card */
        .service-card {
            position: relative;
            overflow: hidden;
            min-height: 540px;
            padding: 24px;
            border-radius: 32px;
            box-shadow: 0 22px 60px rgba(31, 65, 91, 0.08);
            display: flex;
            justify-content: space-between;
            align-items: stretch;
            transition: transform 0.28s ease, box-shadow 0.28s ease;
        }

        .service-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 28px 72px rgba(31, 65, 91, 0.12);
        }

        .provider-card {
            background: #EEF8F6;
        }

        .vet-card {
            background: #FFF5EE;
        }

        .service-card-inner {
            position: relative;
            z-index: 2;
            width: 100%;
            display: flex;
            align-items: stretch;
            justify-content: space-between;
            gap: 24px;
            min-width: 0;
        }

        .service-copy {
            width: 42%;
            min-width: 0;
            padding: 14px 6px 14px 6px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
            z-index: 3;
        }

        .service-media {
            width: 58%;
            min-width: 58%;
            height: 100%;
            min-height: 100%;
            overflow: hidden;
            position: relative;
            border-radius: 28px 28px 28px 110px;
            background: rgba(255, 255, 255, 0.92);
            box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.55);
            align-self: flex-end;
            justify-self: end;
        }

        .service-media img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center bottom;
            display: block;
            transform: scale(1.01);
            transition: transform 0.35s ease;
        }

        .service-card:hover .service-media img {
            transform: scale(1.06);
        }

        .service-icon {
            width: 92px;
            height: 92px;
            border-radius: 50%;
            display: grid;
            place-items: center;
            font-size: 36px;
            margin-bottom: 22px;
            box-shadow: 0 12px 28px rgba(26, 47, 67, 0.08);
        }

        .provider-card .service-icon {
            background: rgba(22, 154, 162, 0.1);
            color: #169aa2;
        }

        .vet-card .service-icon {
            background: rgba(255, 140, 76, 0.12);
            color: #ff7c27;
        }

        .service-card h3 {
            margin: 0;
            font-size: clamp(30px, 3vw, 40px);
            line-height: 1.12;
            letter-spacing: -0.03em;
        }

        .provider-card h3 {
            color: #14858d;
        }

        .vet-card h3 {
            color: #ff741d;
        }

        .service-divider {
            width: 54px;
            height: 3px;
            border-radius: 999px;
            margin: 18px 0 20px;
        }

        .provider-card .service-divider {
            background: #179aa1;
        }

        .vet-card .service-divider {
            background: #ff8d39;
        }

        .service-card p {
            margin: 0 0 24px;
            color: #394b5c;
            font-size: 18px;
            line-height: 1.7;
        }

        .service-points {
            display: grid;
            gap: 14px;
            margin: 0 0 28px;
            padding: 0;
            list-style: none;
        }

        .service-points li {
            display: flex;
            align-items: center;
            gap: 12px;
            color: #223548;
            font-size: 17px;
        }

        .service-points i {
            font-size: 18px;
        }

        .provider-card .service-points i {
            color: #169aa2;
        }

        .vet-card .service-points i {
            color: #ff7c27;
        }

        .service-cta {
            min-height: 56px;
            padding: 0 28px;
            border-radius: 999px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            color: #ffffff;
            font-size: 18px;
            font-weight: 700;
            text-decoration: none;
            box-shadow: 0 18px 34px rgba(23, 50, 77, 0.12);
            transition: transform 0.22s ease, box-shadow 0.22s ease;
            align-self: flex-start;
        }

        .service-cta:hover {
            transform: scale(1.03);
            box-shadow: 0 22px 38px rgba(23, 50, 77, 0.16);
        }

        .provider-card .service-cta {
            background: linear-gradient(135deg, #1299a1 0%, #1fb2a1 100%);
        }

        .vet-card .service-cta {
            background: linear-gradient(135deg, #ff8d34 0%, #ff6b1b 100%);
        }

        /* Bottom feature row */
        .services-benefits {
            margin-top: 26px;
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 14px;
            position: relative;
            z-index: 1;
        }

        .benefit-item {
            display: grid;
            grid-template-columns: 64px 1fr;
            gap: 14px;
            align-items: start;
            padding: 18px 12px;
            border-radius: 24px;
        }

        .benefit-icon {
            width: 58px;
            height: 58px;
            border-radius: 50%;
            display: grid;
            place-items: center;
            font-size: 23px;
        }

        .benefit-item h4 {
            margin: 0 0 6px;
            font-size: 18px;
            color: #1e3247;
        }

        .benefit-item p {
            margin: 0;
            color: #6f7d8d;
            font-size: 14px;
            line-height: 1.6;
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
            .features-band,
            .services-benefits {
                grid-template-columns: repeat(2, 1fr);
            }

            .content-grid,
            .hero {
                grid-template-columns: 1fr;
            }

            .hero-art {
                min-height: 230px;
            }

            .service-card {
                min-height: 100%;
            }

            .service-card-inner {
                gap: 16px;
            }

            .service-copy,
            .service-media {
                min-width: 0;
            }

            .service-copy {
                width: 44%;
            }

            .service-media {
                width: 56%;
                min-width: 56%;
            }

            .marketplace-hero {
                grid-template-columns: 1fr;
            }

            .marketplace-grid {
                grid-template-columns: repeat(3, minmax(0, 1fr));
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
            .pets-grid,
            .services-layout,
            .services-benefits {
                grid-template-columns: 1fr;
            }

            .marketplace-features {
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

            .services-showcase {
                padding: 38px 18px 24px;
            }

            .marketplace-section {
                padding: 24px 16px;
            }

            .services-header h2 {
                font-size: 30px;
            }

            .services-header p {
                font-size: 16px;
            }

            .marketplace-copy h2 {
                font-size: 30px;
            }

            .marketplace-copy > p {
                font-size: 16px;
            }

            .marketplace-card {
                border-radius: 28px;
            }

            .marketplace-image-wrapper {
                min-height: 380px;
                height: 380px;
                border-radius: 28px 28px 28px 72px;
            }

            .marketplace-float {
                top: 16px;
                right: 16px;
                min-width: 160px;
                padding: 14px;
            }

            .marketplace-products-head {
                align-items: flex-start;
                flex-direction: column;
            }

            .marketplace-grid {
                display: flex;
                gap: 14px;
                overflow-x: auto;
                padding-bottom: 6px;
                scroll-snap-type: x mandatory;
            }

            .market-card {
                min-width: 260px;
                scroll-snap-align: start;
            }

            .service-card {
                min-height: auto;
                border-radius: 28px;
                padding: 16px;
            }

            .service-card-inner {
                flex-direction: column;
                gap: 18px;
            }

            .service-copy,
            .service-media {
                width: 100%;
                min-width: 100%;
            }

            .service-media {
                min-height: 240px;
                height: 240px;
                border-radius: 28px 28px 28px 72px;
                order: 2;
            }

            .service-copy {
                padding: 4px 6px 0;
                order: 1;
            }

            .service-card p,
            .service-points li,
            .service-cta {
                font-size: 16px;
            }

            .service-cta {
                max-width: 100%;
            }

            .benefit-item {
                padding: 14px 6px;
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

    <section class="content-grid single-panel">
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
    </section>

    <!-- Marketplace section -->
    <section class="panel marketplace-section" aria-labelledby="marketplace-title">
        <div class="marketplace-hero">
            <div class="marketplace-copy">
                <div class="marketplace-label"><i class="fas fa-paw"></i> Pet Marketplace</div>
                <h2 id="marketplace-title">Everything Your Pet Needs, All in One Place</h2>
                <p>Shop food, toys, accessories, and more from trusted sellers. Quality products for happy, healthy pets.</p>

                <div class="marketplace-features">
                    <article class="marketplace-feature">
                        <div class="marketplace-feature-icon tone-teal"><i class="fas fa-shield-heart"></i></div>
                        <div>
                            <h3>Trusted Sellers</h3>
                            <p>Verified &amp; reliable pet product sellers</p>
                        </div>
                    </article>
                    <article class="marketplace-feature">
                        <div class="marketplace-feature-icon" style="background: #eef8ff; color: #5f92d8;"><i class="fas fa-truck-fast"></i></div>
                        <div>
                            <h3>Fast Delivery</h3>
                            <p>Quick &amp; safe delivery to you</p>
                        </div>
                    </article>
                    <article class="marketplace-feature">
                        <div class="marketplace-feature-icon" style="background: #fff4ea; color: #ff8b57;"><i class="fas fa-credit-card"></i></div>
                        <div>
                            <h3>Secure Payments</h3>
                            <p>Safe &amp; secure checkout</p>
                        </div>
                    </article>
                    <article class="marketplace-feature">
                        <div class="marketplace-feature-icon" style="background: #fff1f4; color: #ef6e8d;"><i class="fas fa-heart"></i></div>
                        <div>
                            <h3>Pet Happiness</h3>
                            <p>Curated for your pet's happiness</p>
                        </div>
                    </article>
                </div>

                <a href="#" class="marketplace-cta">Explore Marketplace <i class="fas fa-arrow-right"></i></a>
            </div>

            <div class="marketplace-card">
                <div class="marketplace-image-wrapper">
                    <img src="images/Pet Marketplace.png" alt="Premium pet marketplace hero">
                    <div class="marketplace-float">
                        <i class="fas fa-heart"></i>
                        <strong>Happy pets,<br>happy life!</strong>
                    </div>
                </div>
            </div>
        </div>

        <div class="marketplace-products">
            <div class="marketplace-products-head">
                <h3>Recommended for Your Pet ✨</h3>
                <a href="#" class="marketplace-view-all">View All</a>
            </div>

            <div class="marketplace-grid">
                <?php foreach ($recommendedProducts as $product): ?>
                    <article class="market-card">
                        <?php $productImage = !empty($product['image']) ? trim($product['image']) : 'default-product.png'; ?>
                        <div class="product-image-wrapper">
                            <button class="market-wishlist" type="button" aria-label="Add <?= htmlspecialchars($product['name']) ?> to wishlist">
                                <i class="fas fa-heart"></i>
                            </button>
                            <img
                                src="uploads/marketplace/<?= htmlspecialchars($productImage) ?>"
                                alt="<?= htmlspecialchars($product['name']) ?>"
                                class="product-image"
                                onerror="this.onerror=null;this.src='uploads/marketplace/default-product.png';"
                            >
                        </div>

                        <div class="market-card-body">
                            <h4><?= htmlspecialchars($product['name']) ?></h4>
                            <p><?= htmlspecialchars($product['meta']) ?></p>
                            <p class="market-image-debug"><?= htmlspecialchars('uploads/marketplace/' . $productImage) ?></p>
                            <div class="market-rating">
                                <i class="fas fa-star"></i>
                                <?= htmlspecialchars($product['rating'] ?? '4.8') ?>
                                <span>Top rated</span>
                            </div>
                            <div class="market-card-footer">
                                <div class="market-price"><?= htmlspecialchars($product['price']) ?></div>
                                <button class="market-add" type="button" aria-label="Add <?= htmlspecialchars($product['name']) ?> to cart">
                                    <i class="fas fa-cart-shopping"></i>
                                </button>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Services section -->
    <section class="panel services-showcase" aria-labelledby="services-showcase-title">
        <span class="services-orb" aria-hidden="true"></span>
        <span class="services-heart" aria-hidden="true"><i class="fas fa-heart"></i></span>
        <span class="services-heart right" aria-hidden="true"><i class="fas fa-heart"></i></span>

        <!-- Section header -->
        <div class="services-header">
            <div class="services-badge"><i class="fas fa-paw"></i></div>
            <span class="services-eyebrow">Our Services</span>
            <h2 id="services-showcase-title">Care for Your Pet, Your Way</h2>
            <p>Professional care. Trusted people. Happy pets. Choose the service that fits your pet's needs.</p>
        </div>

        <!-- Main service cards -->
        <div class="services-layout">
            <article class="service-card provider-card">
                <div class="service-card-inner">
                    <div class="service-copy">
                        <div class="service-icon"><i class="fas fa-user-group"></i></div>
                        <h3>Service Providers<br>(Sitters &amp; Walkers)</h3>
                        <div class="service-divider" aria-hidden="true"></div>
                        <p>Book trusted pet sitters and dog walkers who will treat your pet like family, whether you need daily help or flexible support.</p>
                        <ul class="service-points">
                            <li><i class="far fa-circle-check"></i> Pet Sitting at Home</li>
                            <li><i class="far fa-circle-check"></i> Dog Walking</li>
                            <li><i class="far fa-circle-check"></i> Play &amp; Companionship</li>
                            <li><i class="far fa-circle-check"></i> Flexible Scheduling</li>
                        </ul>
                        <a href="index.php?url=appointments/index" class="service-cta">Find a Service Provider <i class="fas fa-angle-right"></i></a>
                    </div>

                    <div class="service-media">
                        <img src="images/Service Provider.png" alt="Smiling pet care provider with a dog">
                    </div>
                </div>
            </article>

            <article class="service-card vet-card">
                <div class="service-card-inner">
                    <div class="service-copy">
                        <div class="service-icon"><i class="fas fa-stethoscope"></i></div>
                        <h3>Veterinarians</h3>
                        <div class="service-divider" aria-hidden="true"></div>
                        <p>Connect with licensed veterinarians for consultations, guidance, reminders, and dependable support for your pet's health needs.</p>
                        <ul class="service-points">
                            <li><i class="far fa-circle-check"></i> Online Consultations</li>
                            <li><i class="far fa-circle-check"></i> Health Advice</li>
                            <li><i class="far fa-circle-check"></i> Vaccination Reminders</li>
                            <li><i class="far fa-circle-check"></i> Pet Health Support</li>
                        </ul>
                        <a href="index.php?url=clinical/labHub" class="service-cta">Consult a Veterinarian <i class="fas fa-angle-right"></i></a>
                    </div>

                    <div class="service-media">
                        <img src="images/Veterinarian.png" alt="Veterinarian caring for a cat">
                    </div>
                </div>
            </article>
        </div>

        <!-- Bottom feature row -->
        <div class="services-benefits">
            <article class="benefit-item">
                <div class="benefit-icon tone-teal"><i class="fas fa-shield-heart"></i></div>
                <div>
                    <h4>Trusted &amp; Verified</h4>
                    <p>Providers are reviewed carefully with your pet's safety in mind.</p>
                </div>
            </article>
            <article class="benefit-item">
                <div class="benefit-icon" style="background: #fff1ea; color: #ff8b57;"><i class="fas fa-heart"></i></div>
                <div>
                    <h4>Loving Care</h4>
                    <p>Support that keeps pets comfortable, active, and well cared for.</p>
                </div>
            </article>
            <article class="benefit-item">
                <div class="benefit-icon" style="background: #ecfbf6; color: #1f9f8f;"><i class="far fa-calendar-check"></i></div>
                <div>
                    <h4>Easy Booking</h4>
                    <p>Schedule services and consultations in only a few clicks.</p>
                </div>
            </article>
            <article class="benefit-item">
                <div class="benefit-icon" style="background: #fff3e6; color: #f08a2b;"><i class="fas fa-headset"></i></div>
                <div>
                    <h4>24/7 Support</h4>
                    <p>Helpful guidance whenever you or your pet need it most.</p>
                </div>
            </article>
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
