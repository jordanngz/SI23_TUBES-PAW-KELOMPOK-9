<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fine Dining Experience - Login</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600;700&family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        /* Reset and base styles */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Poppins', sans-serif;
        line-height: 1.6;
        color: #1a1a1a;
        overflow-x: hidden;
    }

    .container {
        display: flex;
        min-height: 100vh;
        position: relative;
    }

    /* Left side styles */
    .left-side {
        flex: 1;
        background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 50%, #1a1a1a 100%);
        color: #f5c754;
        padding: 3rem;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        position: relative;
        overflow: hidden;
    }

    .left-side::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(245,199,84,0.1) 0%, transparent 70%);
        animation: float 20s ease-in-out infinite;
    }

    .left-side::after {
        content: '';
        position: absolute;
        bottom: -30%;
        left: -30%;
        width: 150%;
        height: 150%;
        background: radial-gradient(circle, rgba(245,199,84,0.05) 0%, transparent 60%);
        animation: float 25s ease-in-out infinite reverse;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-20px) rotate(5deg); }
    }

    .logo {
        position: relative;
        z-index: 2;
        margin-bottom: 2rem;
    }

    .logo h3 {
        font-family: 'Playfair Display', serif;
        font-size: 1.8rem;
        font-weight: 700;
        letter-spacing: -0.5px;
        background: linear-gradient(45deg, #f5c754, #ffd700);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        text-shadow: 0 2px 4px rgba(245,199,84,0.3);
    }

    .left-content {
        position: relative;
        z-index: 2;
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .left-content h1 {
        font-family: 'Playfair Display', serif;
        font-size: 3.5rem;
        font-weight: 700;
        line-height: 1.2;
        margin-bottom: 1.5rem;
        background: linear-gradient(45deg, #f5c754, #ffd700, #f5c754);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        text-shadow: 0 4px 8px rgba(245,199,84,0.3);
    }

    .left-content > p {
        font-size: 1.1rem;
        margin-bottom: 3rem;
        color: #000000;
        line-height: 1.7;
    }

    .features {
        margin-bottom: 3rem;
    }

    .feature {
        display: flex;
        align-items: flex-start;
        margin-bottom: 2rem;
        padding: 1rem;
        background: rgba(245, 199, 84, 0.1);
        border-radius: 12px;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(245, 199, 84, 0.2);
        transition: all 0.3s ease;
    }

    .feature:hover {
        transform: translateX(10px);
        background: rgba(245, 199, 84, 0.15);
        border-color: rgba(245, 199, 84, 0.3);
        box-shadow: 0 4px 15px rgba(245, 199, 84, 0.2);
    }

    .feature-icon {
        font-size: 2rem;
        margin-right: 1rem;
        flex-shrink: 0;
        /* filter: sepia(1) hue-rotate(25deg) saturate(2); */
    }

    .feature-text h4 {
        font-family: 'Playfair Display', serif;
        font-size: 1.2rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: #000000;
    }

    .feature-text p {
        font-size: 0.9rem;
        color: #000000;
    }

    .testimonial {
        background: rgba(245, 199, 84, 0.1);
        padding: 2rem;
        border-radius: 16px;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(245, 199, 84, 0.2);
        position: relative;
        z-index: 2;
    }

    .quote {
        font-family: 'Playfair Display', serif;
        font-size: 1.3rem;
        font-style: italic;
        margin-bottom: 1rem;
        line-height: 1.6;
        color: #000000;
    }

    .author {
        font-weight: 500;
        color: #000000;
    }

    /* Right side styles */
    .right-side {
        flex: 1;
        background: linear-gradient(135deg, #fafafa 0%, #ffffff 50%, #f8f8f8 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 3rem;
        position: relative;
    }

    .right-side::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="%23f5c754" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="%23f5c754" opacity="0.05"/><circle cx="50" cy="10" r="0.5" fill="%23f5c754" opacity="0.08"/><circle cx="10" cy="60" r="0.5" fill="%23f5c754" opacity="0.06"/><circle cx="90" cy="40" r="0.5" fill="%23f5c754" opacity="0.04"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
        opacity: 0.5;
    }

    .login-container {
        background: white;
        padding: 3rem;
        border-radius: 24px;
        box-shadow: 
            0 20px 60px rgba(245, 199, 84, 0.15),
            0 8px 32px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 450px;
        position: relative;
        z-index: 2;
        border: 1px solid rgba(245, 199, 84, 0.2);
    }

    .login-container::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #f5c754, #ffd700, #f5c754);
        border-radius: 24px 24px 0 0;
    }

    .login-container h2 {
        font-family: 'Playfair Display', serif;
        font-size: 2.2rem;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 0.5rem;
        text-align: center;
        line-height: 1.3;
    }

    .subtitle {
        color: #666;
        text-align: center;
        margin-bottom: 2.5rem;
        font-size: 1rem;
        line-height: 1.6;
    }

    .login-form {
        margin-bottom: 2rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 500;
        color: #1a1a1a;
        font-size: 0.95rem;
    }

    .form-group input {
        width: 100%;
        padding: 1rem 1.25rem;
        border: 2px solid #e5e5e5;
        border-radius: 12px;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: #fafafa;
        color: #1a1a1a;
    }

    .form-group input:focus {
        outline: none;
        border-color: #f5c754;
        background: white;
        box-shadow: 0 0 0 3px rgba(245, 199, 84, 0.1);
        transform: translateY(-1px);
    }

    .form-group input::placeholder {
        color: #999;
    }

    .login-btn {
        width: 100%;
        background: linear-gradient(135deg, #f5c754 0%, #ffd700 100%);
        color: #1a1a1a;
        border: none;
        padding: 1rem 2rem;
        border-radius: 12px;
        font-size: 1.1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(245, 199, 84, 0.3);
    }

    .login-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
        transition: left 0.5s ease;
    }

    .login-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(245, 199, 84, 0.4);
        background: linear-gradient(135deg, #ffd700 0%, #f5c754 100%);
    }

    .login-btn:hover::before {
        left: 100%;
    }

    .login-btn:active {
        transform: translateY(0);
    }

    .signup-text {
        text-align: center;
        color: #666;
        margin-bottom: 1rem;
        font-size: 0.95rem;
    }

    .create-account {
        display: block;
        text-align: center;
        color: #1a1a1a;
        text-decoration: none;
        font-weight: 600;
        padding: 0.75rem;
        border: 2px solid #f5c754;
        border-radius: 12px;
        transition: all 0.3s ease;
        background: transparent;
    }

    .create-account:hover {
        background: #f5c754;
        color: #1a1a1a;
        transform: translateY(-1px);
        box-shadow: 0 4px 15px rgba(245, 199, 84, 0.3);
    }

    /* Success/Error messages */
    .alert {
        padding: 1rem;
        border-radius: 12px;
        margin-bottom: 1.5rem;
        text-align: center;
        font-weight: 500;
    }

    .alert-success {
        background: linear-gradient(135deg, #f0f9e8, #e8f5e8);
        color: #166534;
        border: 1px solid #86efac;
    }

    .alert-error {
        background: linear-gradient(135deg, #fef2f2, #fecaca);
        color: #dc2626;
        border: 1px solid #fca5a5;
    }

    /* Responsive design */
    @media (max-width: 1024px) {
        .left-content h1 {
            font-size: 3rem;
        }
        
        .login-container {
            padding: 2.5rem;
        }
    }

    @media (max-width: 768px) {
        .container {
            flex-direction: column;
        }
        
        .left-side {
            padding: 2rem;
            min-height: 40vh;
        }
        
        .left-content {
            justify-content: flex-start;
        }
        
        .left-content h1 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }
        
        .left-content > p {
            margin-bottom: 2rem;
        }
        
        .features {
            margin-bottom: 2rem;
        }
        
        .feature {
            margin-bottom: 1rem;
            padding: 0.75rem;
        }
        
        .testimonial {
            padding: 1.5rem;
        }
        
        .right-side {
            padding: 2rem 1rem;
        }
        
        .login-container {
            padding: 2rem;
            margin: 0;
            border-radius: 16px;
        }
        
        .login-container h2 {
            font-size: 1.8rem;
        }
    }

    @media (max-width: 480px) {
        .left-side {
            padding: 1.5rem;
        }
        
        .logo h3 {
            font-size: 1.5rem;
        }
        
        .left-content h1 {
            font-size: 2rem;
        }
        
        .feature {
            flex-direction: column;
            text-align: center;
        }
        
        .feature-icon {
            margin-right: 0;
            margin-bottom: 0.5rem;
        }
        
        .right-side {
            padding: 1rem;
        }
        
        .login-container {
            padding: 1.5rem;
        }
        
        .login-container h2 {
            font-size: 1.6rem;
        }
    }

    /* Loading animation for form submission */
    .login-btn.loading {
        pointer-events: none;
        opacity: 0.8;
    }

    .login-btn.loading::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 20px;
        height: 20px;
        margin: -10px 0 0 -10px;
        border: 2px solid transparent;
        border-top: 2px solid #1a1a1a;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* Smooth transitions */
    * {
        transition: color 0.3s ease, background-color 0.3s ease, border-color 0.3s ease, transform 0.3s ease, box-shadow 0.3s ease;
    }

    /* Focus styles for accessibility */
    input:focus,
    button:focus,
    a:focus {
        outline: 2px solid #f5c754;
        outline-offset: 2px;
    }

    /* Print styles */
    @media print {
        .left-side {
            display: none;
        }
        
        .right-side {
            flex: none;
            width: 100%;
        }
    }

    /* Additional luxury touches */
    .left-side {
        background-image: 
            radial-gradient(circle at 20% 80%, rgba(245, 199, 84, 0.1) 0%, transparent 50%),
            radial-gradient(circle at 80% 20%, rgba(245, 199, 84, 0.08) 0%, transparent 50%);
    }

    .feature::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, transparent, rgba(245, 199, 84, 0.05), transparent);
        opacity: 0;
        transition: opacity 0.3s ease;
        border-radius: 12px;
    }

    .feature:hover::before {
        opacity: 1;
    }

    .testimonial::before {
        content: '"';
        position: absolute;
        top: -10px;
        left: 15px;
        font-size: 4rem;
        color: #f5c754;
        font-family: 'Playfair Display', serif;
        opacity: 0.3;
    }
    </style>
</head>
<body>
    <div class="container">
        <!-- Left side content -->
        <div class="left-side">
            <div class="logo">
                <h3>Kerapu Fine Dining Restaurant</h3>
            </div>
            <div class="left-content">
                <h1>Exquisite Culinary Journey</h1>
                <p>Experience the art of fine dining with our award-winning chefs and carefully curated menu. Join us to elevate your dining experience.</p>
                <div class="features">
                    <div class="feature">
                        <div class="feature-icon">🍽️</div>
                        <div class="feature-text">
                            <h4>Gourmet Selection</h4>
                            <p>Handcrafted dishes using premium ingredients</p>
                        </div>
                    </div>
                    <div class="feature">
                        <div class="feature-icon">🥂</div>
                        <div class="feature-text">
                            <h4>Exclusive Reservations</h4>
                            <p>Priority booking and special event access</p>
                        </div>
                    </div>
                    <div class="feature">
                        <div class="feature-icon">🌟</div>
                        <div class="feature-text">
                            <h4>Personalized Experience</h4>
                            <p>Tailored recommendations based on your preferences</p>
                        </div>
                    </div>
                </div>
                <div class="testimonial">
                    <p class="quote">"Dimana lagi selain di Mekdi"</p>
                    <div class="author">— Mekdi</div>
                </div>
            </div>
        </div>

        <!-- Right side login form -->
        <div class="right-side">
            <div class="login-container">
                <h2>Welcome to Our Fine Dining Experience</h2>
                <p class="subtitle">Indulge in the epitome of luxury and taste, crafted to perfection for you.</p>
<!-- 
                {{-- Notifikasi sukses/gagal --}} -->
                @if(session('status'))
                    <p style="color: green; text-align: center; margin-bottom: 1rem;">
                        {{ session('status') }}
                    </p>
                @endif
                
                <!-- {{-- Form login --}} -->
                <form method="POST" action="{{ route('login.process') }}" class="login-form">
                    @csrf
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" placeholder="Enter your email" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" placeholder="Enter your password" required>
                    </div>
                    
                    <button type="submit" class="login-btn">Login</button>
                </form>

                <p class="signup-text">Don't have an account? Signup Now!</p>
                <a href="{{ route('register') }}" class="create-account">Create an account</a>
            </div>
        </div>
    </div>
</body>
</html>
