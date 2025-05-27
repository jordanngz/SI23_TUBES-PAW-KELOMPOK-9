<!DOCTYPE html>

<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Kerapu Fine Dining - Choose Mode</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

```
* {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
}

body {
  font-family: 'Poppins', sans-serif;
  background: 
    linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)),
    url('{{ asset('images/bgmode.jpg') }}') no-repeat center center fixed;
  background-size: cover;
  color: #fffbd6;
  display: flex;
  flex-direction: column;
  min-height: 100vh;
  justify-content: center;
  align-items: center;
  padding: 20px;
}

.logo {
  width: 100px;
  margin-bottom: 10px;
}

header {
  background-color: rgba(0, 51, 102, 0.85);
  color: #fffbd6;
  padding: 24px 30px;
  text-align: center;
  font-weight: 700;
  font-size: 2rem;
  border-radius: 12px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.6);
  width: 100%;
  max-width: 500px;
  user-select: none;
  margin-bottom: 20px;
}

.description {
  font-size: 1rem;
  text-align: center;
  color: #ddd7ac;
  margin-bottom: 30px;
  max-width: 600px;
}

.welcome-message {
  text-align: center;
  margin-bottom: 30px;
  font-size: 1.2rem;
  color: #fffbd6;
}

.mode-selection {
  display: flex;
  gap: 30px;
  flex-wrap: wrap;
  justify-content: center;
  width: 100%;
  max-width: 500px;
}

.mode-button {
  background-color: rgba(0, 51, 102, 0.75);
  border: 2px solid #ffd700;
  color: #fffbd6;
  width: 180px;
  padding: 24px 18px;
  border-radius: 20px;
  text-decoration: none;
  text-align: center;
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.4);
  transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 10px;
  cursor: pointer;
  user-select: none;
}

.mode-icon {
  font-size: 1.8rem;
  margin-bottom: 4px;
}

.mode-title {
  font-size: 1.15rem;
  font-weight: 700;
}

.mode-subtext {
  font-size: 0.85rem;
  color: #f9f1c2;
}

.mode-button:hover,
.mode-button:focus {
  background-color: #004080;
  color: #fffacd;
  border-color: #f5d76e;
  outline: none;
}

footer {
  margin-top: 50px;
  font-size: 0.9rem;
  color: #d4caa8;
  text-align: center;
}

@media (max-width: 480px) {
  .mode-selection {
    flex-direction: column;
    gap: 20px;
  }

  .mode-button {
    width: 100%;
    font-size: 1rem;
    padding: 20px;
  }
}
```

  </style>
</head>
<body>
  <!-- Logo -->
  <img src="https://img.icons8.com/ios-filled/100/FFD700/restaurant.png" alt="Logo" class="logo" />

  <!-- Judul -->

  <header>
    Kerapu Fine Dining Restaurant
  </header>

  <!-- Deskripsi -->

  <p class="description">
    🍽️ Experience fine dining with a touch of elegance. Whether you're here for the moment or booking ahead, Siren Restaurant welcomes you with warm flavors and blue-gold charm.
  </p>

  <!-- Sapaan -->

  <div class="welcome-message">
    Welcome, <strong>{{ Auth::user()->name }}</strong>! Please choose an option:
  </div>

  <!-- Tombol Pilihan -->

  <div class="mode-selection">
    <a href="{{ url('/offline') }}" class="mode-button" role="button" aria-label="Choose offline dining">
      <span class="mode-icon">🏠</span>
      <span class="mode-title">Offline Dining</span>
      <span class="mode-subtext">(Eat at the restaurant now)</span>
    </a>
    <a href="{{ route('home') }}" class="mode-button" role="button" aria-label="Go to home page">
      <span class="mode-icon">📅</span>
      <span class="mode-title">Online Reservation</span>
      <span class="mode-subtext">(Reserve your seat in advance)</span>
    </a>
  </div>

  <!-- Footer -->

  <footer>
    &copy; {{ date('Y') }} Kerapu Fine Dining Restaurant. Fine Dining. Fine Moments.
  </footer>
</body>
</html>
