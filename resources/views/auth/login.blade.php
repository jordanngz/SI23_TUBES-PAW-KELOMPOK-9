<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fine Dining Experience - Login</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600;700&family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
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

                {{-- Notifikasi sukses/gagal --}}
                @if(session('status'))
                    <p style="color: green; text-align: center; margin-bottom: 1rem;">
                        {{ session('status') }}
                    </p>
                @endif
                
                {{-- Form login --}}
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
