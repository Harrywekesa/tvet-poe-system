<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CBET POE System | Competency Based Education</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #2563eb;
            --primary-dark: #1e40af;
            --secondary: #64748b;
            --bg-light: #f8fafc;
            --text-dark: #0f172a;
            --white: #ffffff;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Outfit', sans-serif;
        }

        body {
            background: var(--white);
            color: var(--text-dark);
            line-height: 1.6;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 5%;
            position: fixed;
            width: 100%;
            top: 0;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            z-index: 1000;
            border-bottom: 1px solid #e2e8f0;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary);
            text-decoration: none;
        }

        .nav-link {
            color: var(--secondary);
            text-decoration: none;
            margin-left: 30px;
            font-weight: 500;
            transition: color 0.2s;
        }

        .nav-link:hover {
            color: var(--primary);
        }

        .btn-cta {
            background: var(--primary);
            color: white;
            padding: 10px 24px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: transform 0.2s;
            display: inline-block;
        }

        .btn-cta:hover {
            transform: translateY(-2px);
            background: var(--primary-dark);
        }

        .hero {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 160px 5% 100px;
            min-height: 100vh;
            background: radial-gradient(circle at 10% 20%, rgb(239, 246, 255) 0%, rgb(255, 255, 255) 90%);
        }

        .hero-text {
            max-width: 600px;
        }

        .hero h1 {
            font-size: 3.5rem;
            line-height: 1.1;
            margin-bottom: 20px;
            letter-spacing: -1px;
        }

        .hero p {
            font-size: 1.1rem;
            color: var(--secondary);
            margin-bottom: 30px;
            max-width: 480px;
        }

        .hero-stats {
            display: flex;
            gap: 40px;
            margin-top: 40px;
        }

        .stat-item h3 {
            font-size: 2rem;
            color: var(--text-dark);
        }

        .stat-item p {
            font-size: 0.9rem;
            color: var(--secondary);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .hero-image {
            width: 45%;
            height: 500px;
            background: #e0f2fe;
            border-radius: 20px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 20px 50px -10px rgba(37, 99, 235, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .mockup-card {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            width: 80%;
        }

        .mockup-line {
            height: 10px;
            background: #f1f5f9;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        .mockup-line.short {
            width: 60%;
        }

        @media (max-width: 900px) {
            .hero {
                flex-direction: column;
                text-align: center;
                padding-top: 120px;
            }

            .hero-image {
                width: 100%;
                margin-top: 50px;
                height: 300px;
            }

            .hero-text {
                margin: 0 auto;
            }

            .hero-stats {
                justify-content: center;
            }

            .hero h1 {
                font-size: 2.5rem;
            }
        }
    </style>
</head>

<body>
    <nav class="navbar">
        <a href="<?= APP_URL ?>" class="logo">CBET POE</a>
        <div>
            <a href="<?= APP_URL ?>/login" class="nav-link">Login</a>
            <a href="<?= APP_URL ?>/login" class="btn-cta" style="margin-left: 20px;">Get Started</a>
        </div>
    </nav>

    <header class="hero">
        <div class="hero-text">
            <h1>Evidence-Based <br><span style="color: var(--primary);">Competency Assessement</span></h1>
            <p>Streamline your TVET institution's Portfolio of Evidence (POE) management. Secure, digital, and compliant
                with CBET standards.</p>

            <a href="<?= APP_URL ?>/login" class="btn-cta" style="padding: 14px 32px; font-size: 1.1rem;">Access Portal
                &rarr;</a>

            <div class="hero-stats">
                <div class="stat-item">
                    <h3>100%</h3>
                    <p>Digital</p>
                </div>
                <div class="stat-item">
                    <h3>Secure</h3>
                    <p>Storage</p>
                </div>
                <div class="stat-item">
                    <h3>Real-time</h3>
                    <p>Verification</p>
                </div>
            </div>
        </div>

        <div class="hero-image">
            <div class="mockup-card">
                <div style="display: flex; gap: 10px; margin-bottom: 20px;">
                    <div style="width: 30px; height: 30px; background: #eff6ff; border-radius: 50%;"></div>
                    <div>
                        <div class="mockup-line" style="width: 100px;"></div>
                        <div class="mockup-line short" style="width: 60px;"></div>
                    </div>
                </div>
                <div class="mockup-line" style="height: 100px;"></div>
                <div style="display: flex; justify-content: space-between; margin-top: 15px;">
                    <div class="mockup-line short" style="width: 80px; background: #22c55e;"></div>
                    <div class="mockup-line short" style="width: 40px;"></div>
                </div>
            </div>
        </div>
    </header>
</body>

</html>