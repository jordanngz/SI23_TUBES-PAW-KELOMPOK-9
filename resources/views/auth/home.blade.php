<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
  <title>Kerapu Fine Dining - Home</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600;700&family=Poppins:wght@300;400;500&display=swap');

    /* Reset */
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    html, body {
      height: 100%;
      width: 100%;
      font-family: 'Poppins', sans-serif;
      background-color: #2c3e50;
      color: white;
      display: flex;
      flex-direction: column;
    }

    body {
      min-height: 100vh;
    }

    header {
      position: relative;
      background-color: #f5c754;
      color: black;
      padding: 24px 30px 16px;
      text-align: center; /* Menjaga title dan welcome-msg tetap di tengah */
      box-shadow: 0 4px 10px #4a6572;
      font-family: 'Playfair Display', serif;
    }

    .title {
      font-size: 2rem;
      font-weight: 700;
      margin: 0;
    }

    #welcome-msg {
      font-size: 1.2rem;
      font-family: 'Poppins', sans-serif;
      margin-top: 8px;
    }

    .logout-btn {
      position: absolute;
      top: 30px;
      right: 30px;
      padding: 10px 20px;
      background-color: #2c3e50;
      color: white; /* Menjadikan teks berwarna putih */
      font-size: 1rem;
      font-weight: 600;
      font-family: 'Poppins', sans-serif; /* Menambahkan font Poppins */
      border: none;
      border-radius: 12px;
      cursor: pointer;
      transition: background-color 0.3s ease, color 0.3s ease;
      text-decoration: none; /* Pastikan tidak ada underline */
    }

    .logout-btn:hover {
      background-color: #ffe066;
      color: #222; /* Mengubah teks menjadi gelap saat hover */
    }


    main {
      flex: 1;
      padding: 24px 30px;
      background-color: #102E50;
      border-radius: 0 0 24px 24px;
      box-shadow: inset 0 0 20px rgba(255 255 255 / 0.15);
    }

    .hero-image {
      width: 100%;
      max-height: 320px;
      object-fit: cover;
      border-radius: 16px;
      margin-bottom: 24px;
      box-shadow: 0 8px 20px rgba(0 85 170 / 0.5);
    }

    .resto-info {
      margin-bottom: 36px;
      text-align: center;
    }

    .resto-info h2 {
      font-size: 2rem;
      color: white;
      margin-bottom: 12px;
      font-weight: 700;
    }

    .resto-info p {
      font-size: 1.2rem;
      line-height: 1.5;
      color: #eee;
      max-width: 600px;
      margin-left: auto;
      margin-right: auto;
    }

    nav {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
      justify-content: center;
    }

    nav button {
      flex: 1 1 140px;
      max-width: 180px;
      background-color: #e6ba4a;
      border: none;
      border-radius: 12px;
      color: black;
      font-weight: 700;
      font-size: 1.1rem;
      padding: 18px 0;
      cursor: pointer;
      box-shadow: 0 5px 15px #4a6572;
      transition: background-color 0.3s ease, color 0.3s ease;
    }

    nav button:hover,
    nav button:focus {
      background-color: #ffe066;
      color: #222;
    }

    footer {
      background-color: #222;
      color: #f5c754;
      padding: 16px 30px;
      font-size: 0.9rem;
      text-align: center;
      user-select: none;
      text-shadow: 0 0 3px rgba(255 204 0 / 0.8); /* Tetap menggunakan ukuran dan efek footer sebelumnya */
    }

    main::-webkit-scrollbar {
      width: 8px;
    }

    main::-webkit-scrollbar-track {
      background: #004080;
    }

    main::-webkit-scrollbar-thumb {
      background-color: rgb(255, 225, 0);
      border-radius: 4px;
    }
  </style>
</head>

<body>
  <header>
    <a href="{{ route('logout') }}" class="logout-btn">Logout</a>
    <h1 class="title">Kerapu Fine Dining Restaurant</h1>
    <div id="welcome-msg">Welcome, <span id="name">{{ Auth::check() ? Auth::user()->name : 'Guest' }}</span></div>
  </header>

  <main>
    <img class="hero-image" src="{{ asset('images/image.jpg') }}" alt="Restaurant ambiance" loading="lazy" />

    <section class="resto-info">
      <h2>Delicious Food & Cozy Atmosphere</h2>
      <p>
        Enjoy handcrafted dishes made from fresh ingredients with friendly service in a warm and inviting space — your perfect place for meals and memories.
      </p>
    </section>
    
    <nav>
      <button onclick="navigateTo('menu')">Menu</button>
      <button onclick="navigateTo('seat')">Seat Info</button>
      <button onclick="navigateTo('reserve')">Reserve</button>
      <button onclick="navigateTo('contact')">Contact Person</button>
      <button onclick="navigateTo('payment')">Payment</button>
    </nav>
  </main>

  <footer>
    &copy; 2025 Kerapu Fine Dining. All rights reserved.
  </footer>

  <script>
    // Placeholder for navigation actions
    function navigateTo(page) {
      alert('Navigate to ' + page + ' page (feature coming soon)');
    }
  </script>
</body>

</html>