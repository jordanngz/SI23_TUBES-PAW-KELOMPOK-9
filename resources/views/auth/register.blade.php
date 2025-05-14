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
