<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Kerapu Fine Dining - Home</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=Poppins:wght@400;500&display=swap');
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: 'Poppins', sans-serif; background-color: #111; color: #fff; line-height: 1.6; }
    header {
      background: url('{{ asset('images/image.jpg') }}') no-repeat center center/cover;
      height: 100vh; position: relative; display: flex; flex-direction: column;
      justify-content: center; align-items: center; text-align: center; padding: 20px;
    }
    header::before {
      content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 100%;
      background-color: rgba(0, 0, 0, 0.6); z-index: 1;
    }
    header h1, header p { position: relative; z-index: 2; }
    header h1 { font-family: 'Playfair Display', serif; font-size: 3rem; color: #f5c754; margin-bottom: 20px; }
    header p { font-size: 1.2rem; color: #eee; max-width: 600px; }
    .section { padding: 60px 20px; max-width: 1200px; margin: auto; }
    .section h2 { font-family: 'Playfair Display', serif; font-size: 2rem; margin-bottom: 20px; color: #f5c754; text-align: center; }
    .restaurant-info { display: flex; flex-wrap: wrap; gap: 40px; align-items: center; justify-content: space-between; margin-top: 30px; }
    .slider { flex: 1 1 500px; max-width: 48%; position: relative; height: 300px; overflow: hidden; border-radius: 12px; }
    .slider img { position: absolute; width: 100%; height: 100%; object-fit: cover; opacity: 0; transition: opacity 1s ease-in-out; border-radius: 12px; }
    .slider img.active { opacity: 1; }
    .description { flex: 1 1 500px; max-width: 48%; color: #eee; font-size: 1.05rem; line-height: 1.7; text-align: justify; }
    .menu-list { display: flex; flex-wrap: wrap; gap: 20px; justify-content: center; }
    .menu-item { background-color: #1c1c1c; border: 1px solid #333; border-radius: 12px; padding: 20px; width: 250px; text-align: center; }
    .menu-item img { width: 100%; height: 150px; object-fit: cover; border-radius: 8px; margin-bottom: 10px; }
    .menu-item h4 { margin-bottom: 10px; color: #f5c754; }
    .reserve-btn {
      display: block; margin: 40px auto 0; background-color: #f5c754; color: #000; font-weight: bold;
      padding: 16px 30px; border: none; border-radius: 50px; font-size: 1.1rem; text-decoration: none;
      transition: background-color 0.3s ease; text-align: center; width: max-content;
    }
    .reserve-btn:hover { background-color: #ffe27a; }
    .contact-info { margin-top: 40px; text-align: center; color: #ccc; }
    .contact-info p { margin: 8px 0; }
    footer { background-color: #000; color: #aaa; text-align: center; padding: 20px; font-size: 0.9rem; }
    /* Logout button pojok kanan atas */
    .logout-topright {
      position: absolute; top: 30px; right: 40px; z-index: 10;
    }
    .logout-btn {
      background: #f5c754; color: #000; border: none; border-radius: 30px; padding: 10px 24px;
      font-weight: bold; font-size: 1rem; cursor: pointer; text-decoration: none;
      transition: background 0.2s;
    }
    .logout-btn:hover { background: #ffe27a; }
  </style>
</head>
<body>
  <header>
    @auth
      <form action="{{ route('logout') }}" method="POST" class="logout-topright">
        @csrf
        <button type="submit" class="logout-btn">Logout</button>
      </form>
    @endauth
    <h1>Kerapu Fine Dining</h1>
    <p>Where luxury meets flavor — enjoy an exquisite fine dining experience with a serene ambiance and curated dishes just for you.</p>
  </header>

  <section class="section">
    <h2>About Our Restaurant</h2>
    <div class="restaurant-info">
      <div class="slider">
        <img src="{{ asset('images/interior_rest.jpg') }}" class="slide active" alt="Slide 1">
        <img src="{{ asset('images/interior_rest2.jpg') }}" class="slide" alt="Slide 2">
        <img src="{{ asset('images/interior_rest3.jpg') }}" class="slide" alt="Slide 3">
      </div>
      <div class="description">
        <p>Founded in 2012, Kerapu Fine Dining takes its name from the grouper fish, a beloved seafood delicacy in Indonesia, symbolizing our dedication to fresh, high-quality ingredients. Combining modern elegance with rich local flavors, the restaurant offers a refined dining experience where tradition meets innovation, creating memorable moments through exquisite dishes, serene ambiance, and impeccable service.</p>
      </div>
    </div>
  </section>

  <section class="section">
    <h2>Latest Menu Highlights</h2>
    <div class="menu-list">
      @foreach($products as $product)
        <div class="menu-item">
          @if($product->image)
            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
          @else
            <img src="https://via.placeholder.com/250x150" alt="{{ $product->name }}">
          @endif
          <h4>{{ $product->name }}</h4>
          <p>{{ $product->description }}</p>
        </div>
      @endforeach
    </div>

    @guest
      <a href="{{ route('login') }}" class="reserve-btn" style="background:#333;color:#fff;margin-top:10px;">Login</a>
    @endguest

    @auth
      <a href="{{ route('reserve') }}" class="reserve-btn">Reserve Now</a>
    @endauth

    <div class="contact-info">
      <p>📍 Jl. Sejahtera No.88, Jakarta Selatan, Indonesia</p>
      <p>📞 +62 812-3456-7890</p>
      <p>✉️ info@kerapufinedining.com</p>
    </div>
  </section>

  <footer>
    <p>&copy; {{ date('Y') }} Kerapu Fine Dining. All rights reserved.</p>
  </footer>

  <script>
    const slides = document.querySelectorAll('.slide');
    let index = 0;
    setInterval(() => {
      slides[index].classList.remove('active');
      index = (index + 1) % slides.length;
      slides[index].classList.add('active');
    }, 3000);
  </script>
</body>
</html>