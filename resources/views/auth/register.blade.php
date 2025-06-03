<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fine Dining Experience - Register</title>
    <link rel="stylesheet" href="{{ asset('css/styleregister.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600;700&family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
</head>
<style>
    /* Reset & Global */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Poppins', sans-serif;
    background-color: #f9f9f9;
    color: #333;
    line-height: 1.6;
    background-image: linear-gradient(45deg, #f9f9f9 25%, #f5f5f5 25%, #f5f5f5 50%, #f9f9f9 50%, #f9f9f9 75%, #f5f5f5 75%, #f5f5f5 100%);
    background-size: 20px 20px;
}

/* Layout container */
.container {
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 100vh;
    padding: 15px;
    position: relative;
}

.container::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: radial-gradient(circle at center, transparent 0%, rgba(0,0,0,0.03) 100%);
    pointer-events: none;
}

/* Centered form box */
.right-side {
    background: linear-gradient(135deg, #f5c754 0%, #f8d980 100%);
    padding: 2.5rem;
    border-radius: 16px;
    max-width: 500px;
    width: 100%;
    box-shadow: 
        0 20px 40px rgba(0, 0, 0, 0.1),
        0 0 0 1px rgba(0, 0, 0, 0.05),
        0 10px 15px -3px rgba(0, 0, 0, 0.1);
    position: relative;
    overflow: hidden;
}

.right-side::before {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(255,255,255,0.2) 0%, transparent 60%);
    transform: rotate(30deg);
    pointer-events: none;
}

/* Login/Register content */
.login-container {
    width: 100%;
    position: relative;
    z-index: 1;
}

.login-container h2 {
    font-family: 'Playfair Display', serif;
    font-size: 2.2rem;
    text-align: center;
    margin-bottom: 0.8rem;
    color: #333;
    letter-spacing: -0.5px;
    font-weight: 700;
    text-shadow: 1px 1px 0 rgba(255,255,255,0.3);
}

.subtitle {
    text-align: center;
    margin-bottom: 2.5rem;
    color: #444;
    font-size: 0.95rem;
    max-width: 90%;
    margin-left: auto;
    margin-right: auto;
}

.form-group {
    margin-bottom: 1.8rem;
    position: relative;
}

.form-group label {
    display: block;
    margin-bottom: 0.6rem;
    font-weight: 500;
    color: #333;
    font-size: 0.95rem;
    transition: all 0.3s ease;
}

.form-group input {
    width: 100%;
    padding: 1rem 1.2rem;
    border: 2px solid rgba(0,0,0,0.08);
    border-radius: 8px;
    font-size: 1rem;
    background-color: white;
    transition: all 0.3s ease;
    box-shadow: 0 2px 5px rgba(0,0,0,0.05);
}

.form-group input:focus {
    outline: none;
    border-color: #333;
    box-shadow: 0 3px 8px rgba(0,0,0,0.1);
    transform: translateY(-1px);
}

.form-group input::placeholder {
    color: #aaa;
    opacity: 1;
}

.login-btn {
    width: 100%;
    padding: 1rem;
    background-color: #333;
    border: none;
    border-radius: 8px;
    color: #fff;
    font-weight: 600;
    font-size: 1rem;
    cursor: pointer;
    transition: all 0.3s ease;
    margin-top: 1.5rem;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    position: relative;
    overflow: hidden;
}

.login-btn::after {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.7s ease;
}

.login-btn:hover {
    background-color: #222;
    transform: translateY(-2px);
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
}

.login-btn:hover::after {
    left: 100%;
}

.login-btn:active {
    transform: translateY(0);
}

.signup-text {
    text-align: center;
    margin-top: 2rem;
    color: #444;
    font-size: 0.95rem;
}

.create-account {
    display: block;
    text-align: center;
    color: #333;
    text-decoration: none;
    font-weight: 600;
    margin-top: 0.7rem;
    padding: 0.8rem;
    border: 2px solid #333;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.create-account:hover {
    background-color: #333;
    color: #f5c754;
    transform: translateY(-1px);
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

/* Status messages */
p[style*="color: green"] {
    background-color: rgba(0, 128, 0, 0.1);
    color: #006400 !important;
    padding: 0.8rem;
    border-radius: 8px;
    text-align: center;
    margin-bottom: 1.5rem;
    border: 1px solid rgba(0, 128, 0, 0.2);
}

/* Decorative elements */
.login-container::before {
    content: '✦';
    position: absolute;
    top: -15px;
    left: 20px;
    font-size: 2rem;
    color: rgba(51, 51, 51, 0.1);
    transform: rotate(-15deg);
}

.login-container::after {
    content: '✦';
    position: absolute;
    bottom: -15px;
    right: 20px;
    font-size: 2rem;
    color: rgba(51, 51, 51, 0.1);
    transform: rotate(15deg);
}

/* Form validation styling */
.form-group input:valid {
    border-color: rgba(0,0,0,0.1);
}

.form-group input:invalid:not(:placeholder-shown) {
    border-color: #e74c3c;
}

.form-group input:invalid:not(:placeholder-shown) + .error-message {
    display: block;
}

.error-message {
    display: none;
    color: #e74c3c;
    font-size: 0.8rem;
    margin-top: 0.5rem;
}

/* Focus styles for accessibility */
input:focus,
button:focus,
a:focus {
    outline: 2px solid #333;
    outline-offset: 2px;
}

/* Responsive */
@media (max-width: 768px) {
    .right-side {
        padding: 2rem 1.5rem;
    }

    .login-container h2 {
        font-size: 1.8rem;
    }
    
    .form-group input {
        padding: 0.9rem 1rem;
    }
}

@media (max-width: 480px) {
    .right-side {
        padding: 1.8rem 1.2rem;
        border-radius: 12px;
    }
    
    .login-container h2 {
        font-size: 1.6rem;
    }
    
    .subtitle {
        font-size: 0.9rem;
        margin-bottom: 2rem;
    }
    
    .form-group {
        margin-bottom: 1.5rem;
    }
    
    .form-group label {
        font-size: 0.9rem;
    }
    
    .login-btn {
        padding: 0.9rem;
    }
}

/* Loading state */
.login-btn.loading {
    pointer-events: none;
    opacity: 0.8;
}

.login-btn.loading::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 20px;
    height: 20px;
    margin: -10px 0 0 -10px;
    border: 2px solid transparent;
    border-top: 2px solid #fff;
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
</style>
<body>
    <div class="container">
        <!-- Right side register form -->
        <div class="right-side">
            <div class="login-container">
                <h2>Create Your Account</h2>
                <p class="subtitle">Join our exclusive dining experience today.</p>

                @if ($errors->any())
                    <ul style="color:red; margin-bottom: 1rem;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif

                @if(session('status'))
                    <p style="color: green;">{{ session('status') }}</p>
                @endif

                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="form-group">
                        <label for="name">Full Name</label>
                        <input type="text" name="name" id="name" placeholder="Enter your full name" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" name="email" id="email" placeholder="Enter your email" required>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" placeholder="Enter your password" required>
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Confirm Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Repeat your password" required>
                        <button type="submit" class="login-btn">Register</button>
                    </div>


                <center><a href="{{route('login')}}"> Already have Account? Login now</a></center>
                <a href="{{ route('login') }}" class="create-account">Login here</a>
            </div>
        </div>
    </div>

    <!-- Toggle Password Script -->
    <script>
        function togglePassword() {
            const pw = document.getElementById("password");
            const pwc = document.getElementById("password_confirmation");
            const type = pw.type === "password" ? "text" : "password";
            pw.type = type;
            pwc.type = type;
        }
    </script>
</body>
</html>
