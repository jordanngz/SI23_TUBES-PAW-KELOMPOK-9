<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Kerapu Fine Dining - Home</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Poppins:wght@300;400;500;600&display=swap');
    
    /* Reset and Base Styles */
    * { 
      margin: 0; 
      padding: 0; 
      box-sizing: border-box; 
    }
    
    :root {
      --gold: #f5c754;
      --gold-light: #ffe27a;
      --dark: #111;
      --darker: #0a0a0a;
      --light: #fff;
      --gray: #eee;
      --gray-dark: #aaa;
    }
    
    body { 
      font-family: 'Poppins', sans-serif; 
      background-color: var(--dark); 
      color: var(--light); 
      line-height: 1.6;
      overflow-x: hidden;
    }
    
    /* Navbar Styles */
    .navbar {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      padding: 1.5rem 2rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
      z-index: 1000;
      transition: background-color 0.3s ease, padding 0.3s ease;
    }
    
    .navbar.scrolled {
      background-color: rgba(10, 10, 10, 0.95);
      padding: 1rem 2rem;
      box-shadow: 0 5px 20px rgba(0, 0, 0, 0.3);
    }
    
    .navbar-brand {
      font-family: 'Playfair Display', serif;
      font-weight: 700;
      font-size: 1.8rem;
      color: var(--gold);
      text-decoration: none;
      letter-spacing: 1px;
    }
    
    .navbar-auth {
      display: flex;
      gap: 1rem;
    }
    
    /* Header Styles */
    header {
      background-color: var(--dark);
      height: 100vh; 
      position: relative; 
      display: flex; 
      flex-direction: column;
      justify-content: center; 
      align-items: center; 
      text-align: center; 
      padding: 2rem;
      background-repeat: no-repeat;
      background-size: cover;
      background-position: center;
    }
    
    header::before {
      content: ''; 
      position: absolute; 
      top: 0; 
      left: 0; 
      width: 100%; 
      height: 100%;
      background: linear-gradient(to bottom, rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.6));
      z-index: 1;
    }
    
    .header-content {
      position: relative;
      z-index: 2;
      max-width: 800px;
      animation: fadeIn 1.5s ease-out;
    }
    
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }
    
    header h1 { 
      font-family: 'Playfair Display', serif; 
      font-size: clamp(2.5rem, 5vw, 4rem); 
      font-weight: 700;
      color: var(--gold); 
      margin-bottom: 1.5rem;
      letter-spacing: 1px;
      text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
    }
    
    header p { 
      font-size: clamp(1rem, 2vw, 1.3rem);
      font-weight: 300;
      color: var(--gray); 
      max-width: 700px;
      margin: 0 auto;
      text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.5);
    }
    
    /* Section Styles */
    .section { 
      padding: 5rem 2rem; 
      max-width: 1200px; 
      margin: auto;
      position: relative;
    }
    
    .section h2 { 
      font-family: 'Playfair Display', serif; 
      font-size: clamp(1.8rem, 3vw, 2.5rem);
      font-weight: 600;
      margin-bottom: 2.5rem; 
      color: var(--gold); 
      text-align: center;
      position: relative;
      padding-bottom: 1rem;
    }
    
    .section h2::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 50%;
      transform: translateX(-50%);
      width: 80px;
      height: 3px;
      background-color: var(--gold);
    }
    
    /* About Section */
    .restaurant-info { 
      display: flex; 
      flex-wrap: wrap; 
      gap: 3rem; 
      align-items: center; 
      justify-content: space-between; 
      margin-top: 2rem;
    }
    
    .slider { 
      flex: 1 1 500px; 
      min-width: 300px;
      position: relative; 
      height: 400px; 
      overflow: hidden; 
      border-radius: 12px;
      box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
    }
    
    .slider img { 
      position: absolute; 
      width: 100%; 
      height: 100%; 
      object-fit: cover; 
      opacity: 0; 
      transition: opacity 1s ease-in-out, transform 1.2s ease; 
      border-radius: 12px;
      transform: scale(1.05);
    }
    
    .slider img.active { 
      opacity: 1;
      transform: scale(1);
    }
    
    .description { 
      flex: 1 1 500px; 
      min-width: 300px;
      color: var(--gray); 
      font-size: 1.05rem; 
      line-height: 1.8; 
      text-align: justify;
    }
    
    .description p {
      margin-bottom: 1.5rem;
    }
    
    .description p:first-of-type::first-letter {
      font-size: 3.5rem;
      font-family: 'Playfair Display', serif;
      float: left;
      line-height: 0.8;
      margin-right: 0.5rem;
      color: var(--gold);
    }
    
    /* Menu Section */
    .menu-list { 
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
      gap: 2rem;
      margin-top: 1rem;
    }
    
    .menu-item { 
      background-color: rgba(28, 28, 28, 0.7); 
      border: 1px solid #333; 
      border-radius: 12px; 
      padding: 1.5rem; 
      text-align: center;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      overflow: hidden;
    }
    
    .menu-item:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
    }
    
    .menu-item img { 
      width: 100%; 
      height: 180px; 
      object-fit: cover; 
      border-radius: 8px; 
      margin-bottom: 1rem;
      transition: transform 0.5s ease;
    }
    
    .menu-item:hover img {
      transform: scale(1.05);
    }
    
    .menu-item h4 { 
      margin-bottom: 0.8rem; 
      color: var(--gold);
      font-family: 'Playfair Display', serif;
      font-size: 1.3rem;
    }
    
    .menu-item p {
      color: var(--gray-dark);
      font-size: 0.95rem;
    }
    
    /* Button Styles */
    .btn {
      display: inline-block;
      padding: 0.8rem 2rem;
      border: none;
      border-radius: 50px;
      font-weight: 500;
      font-size: 1rem;
      text-decoration: none;
      cursor: pointer;
      transition: all 0.3s ease;
      text-align: center;
    }
    
    .btn-primary {
      background-color: var(--gold);
      color: var(--darker);
    }
    
    .btn-primary:hover {
      background-color: var(--gold-light);
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(245, 199, 84, 0.3);
    }
    
    .btn-secondary {
      background-color: #333;
      color: var(--gray);
    }
    
    .btn-secondary:hover {
      background-color: #444;
      transform: translateY(-2px);
    }
    
    .reserve-btn {
      display: block;
      margin: 3rem auto 0;
      padding: 1rem 2.5rem;
      font-size: 1.1rem;
      font-weight: 600;
      width: max-content;
    }
    
    /* Contact Info */
    .contact-info { 
      margin-top: 4rem; 
      text-align: center; 
      color: var(--gray-dark);
      padding: 2rem;
      border-top: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .contact-info p { 
      margin: 0.8rem 0;
      transition: color 0.3s ease;
    }
    
    .contact-info p:hover {
      color: var(--gold);
    }
    
    /* Footer */
    footer { 
      background-color: var(--darker); 
      color: var(--gray-dark); 
      text-align: center; 
      padding: 2rem; 
      font-size: 0.9rem;
      border-top: 1px solid rgba(255, 255, 255, 0.05);
    }
    
    /* Responsive Design */
    @media (max-width: 768px) {
      .navbar {
        padding: 1rem;
      }
      
      .navbar.scrolled {
        padding: 0.8rem 1rem;
      }
      
      .section {
        padding: 4rem 1.5rem;
      }
      
      .restaurant-info {
        gap: 2rem;
      }
      
      .slider {
        height: 300px;
      }
      
      .reserve-btn {
        padding: 0.9rem 2rem;
      }
    }
    
    @media (max-width: 480px) {
      header h1 {
        margin-bottom: 1rem;
      }
      
      .section h2 {
        margin-bottom: 1.5rem;
      }
      
      .slider {
        height: 250px;
      }
      
      .menu-item {
        padding: 1rem;
      }
      
      .menu-item img {
        height: 150px;
      }
      
      .contact-info {
        margin-top: 2.5rem;
        padding: 1.5rem;
      }
    }
  </style>
</head>
<body>
  <!-- Navbar -->
  <nav class="navbar">
    <a href="#" class="navbar-brand">Kerapu Fine Dining</a>
    <div class="navbar-auth">
      @auth
        <form action="{{ route('logout') }}" method="POST">
          @csrf
          <button type="submit" class="btn btn-primary">Logout</button>
        </form>
      @else
        <a href="{{ route('login') }}" class="btn btn-secondary">Login</a>
      @endauth
    </div>
  </nav>

  <!-- Header -->
  <header style="background-image: url('{{ asset('images/background.jpg') }}'); background-size: cover; background-position: center;">
    <div class="header-content">
      <h1>Kerapu Fine Dining</h1>
      <p>Where luxury meets flavor — enjoy an exquisite fine dining experience with a serene ambiance and curated dishes just for you.</p>
    </div>
  </header>

  <!-- About Section -->
  <section class="section">
    <h2>About Our Restaurant</h2>
    <div class="restaurant-info">
      <div class="slider">
        <img src="{{ asset('images/interior_rest.jpg') }}" class="slide active" alt="Restaurant Interior">
        <img src="{{ asset('images/interior_rest2.jpg') }}" class="slide" alt="Dining Area">
        <img src="{{ asset('images/interior_rest3.jpg') }}" class="slide" alt="Private Dining">
      </div>
      <div class="description">
        <p>Founded in 2012, Kerapu Fine Dining takes its name from the grouper fish, a beloved seafood delicacy in Indonesia, symbolizing our dedication to fresh, high-quality ingredients.</p>
        <p>Combining modern elegance with rich local flavors, the restaurant offers a refined dining experience where tradition meets innovation, creating memorable moments through exquisite dishes, serene ambiance, and impeccable service.</p>
      </div>
    </div>
  </section>

  <!-- Menu Section -->
  <section class="section">
    <h2>Latest Menu Highlights</h2>
    <div class="menu-list">
      @foreach($products as $product)
        <div class="menu-item">
          @if($product->image)
            <img src="{{ asset('images/' . $product->image) }}" alt="{{ $product->name }}">
          @else
            <img src="https://via.placeholder.com/280x180" alt="{{ $product->name }}">
          @endif
          <h4>{{ $product->name }}</h4>
          <p>{{ $product->description }}</p>
        </div>
      @endforeach
    </div>

    @guest
      <a href="{{ route('login') }}" class="btn btn-secondary reserve-btn">Login to Reserve</a>
    @else
      <a href="{{ route('reserve') }}" class="btn btn-primary reserve-btn">Reserve Now</a>
    @endguest

    <div class="contact-info">
      <p>📍 Jl. Sejahtera No.88, Jakarta Selatan, Indonesia</p>
      <p>📞 +62 812-3456-7890</p>
      <p>✉️ info@kerapufinedining.com</p>
    </div>
  </section>

  <!-- Footer -->
  <footer>
    <p>&copy; {{ date('Y') }} Kerapu Fine Dining. All rights reserved.</p>
  </footer>

  <script>
    // Image Slider
    const slides = document.querySelectorAll('.slide');
    let index = 0;
    
    function changeSlide() {
      slides[index].classList.remove('active');
      index = (index + 1) % slides.length;
      slides[index].classList.add('active');
    }
    
    setInterval(changeSlide, 4000);
    
    // Navbar scroll effect
    const navbar = document.querySelector('.navbar');
    
    window.addEventListener('scroll', () => {
      if (window.scrollY > 50) {
        navbar.classList.add('scrolled');
      } else {
        navbar.classList.remove('scrolled');
      }
    });
  </script>
</body>
</html>
