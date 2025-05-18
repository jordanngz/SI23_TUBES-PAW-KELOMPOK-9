<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kerapu Fine Dining Restaurant - Menu</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600;700&family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/stylemenu.css') }}">

</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="logo">
                <h3>Kerapu Fine Dining</h3>
            </div>
            <div class="menu-categories">
                <h4>Menu Categories</h4>
                <ul>
                    <li class="active"><a href="#">All Menu</a></li>
                    <li><a href="#">À La Carte</a></li>
                    <li><a href="#">Appetizers</a></li>
                    <li><a href="#">Main Course</a></li>
                    <li><a href="#">Desserts</a></li>
                    <li><a href="#">Beverages</a></li>
                    <li><a href="#">Chef's Special</a></li>
                </ul>
            </div>
            <div class="cart-summary">
                <h4>Your Selection</h4>
                <div class="cart-items">
                    <p class="empty-cart">Your cart is empty</p>
                    <!-- Example of cart item (hidden by default) -->
                    <div class="cart-item" style="display: none;">
                        <div class="cart-item-details">
                            <div class="cart-item-name">Grilled Salmon</div>
                            <div class="cart-item-price">$42.00</div>
                        </div>
                        <div class="cart-item-quantity">
                            <button class="quantity-btn decrease">-</button>
                            <span class="quantity-value">1</span>
                            <button class="quantity-btn increase">+</button>
                        </div>
                    </div>
                </div>
                <div class="cart-total">
                    <p>Total: <span id="cart-total-amount">$0.00</span></p>
                    <button class="checkout-btn">Proceed to Checkout</button>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="header">
                <div class="menu-toggle">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
                <h1>Our Exquisite Menu</h1>
                <div class="cart-icon">
                    <span class="cart-count">0</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="9" cy="21" r="1"></circle>
                        <circle cx="20" cy="21" r="1"></circle>
                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                    </svg>
                </div>
            </div>

            <div class="category-title">
                <h2>All Menu</h2>
                <p>Discover our carefully curated selection of culinary masterpieces</p>
            </div>

            <div class="menu-grid">
                <!-- Menu Item 1 -->
                <div class="menu-item">
                    <div class="menu-image">
                        <img src="https://images.unsplash.com/photo-1544025162-d76694265947?q=80&w=2069&auto=format&fit=crop" alt="Grilled Salmon">
                    </div>
                    <div class="menu-details">
                        <h3>Grilled Salmon</h3>
                        <p>Norwegian salmon, lemon butter sauce, seasonal vegetables</p>
                        <div class="menu-price-action">
                            <span class="price">$42.00</span>
                            <button class="add-to-cart">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Menu Item 2 -->
                <div class="menu-item">
                    <div class="menu-image">
                        <img src="https://images.unsplash.com/photo-1546833998-877b37c2e4c6?q=80&w=2070&auto=format&fit=crop" alt="Filet Mignon">
                    </div>
                    <div class="menu-details">
                        <h3>Filet Mignon</h3>
                        <p>Prime beef tenderloin, truffle mashed potatoes, red wine reduction</p>
                        <div class="menu-price-action">
                            <span class="price">$58.00</span>
                            <button class="add-to-cart">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Menu Item 3 -->
                <div class="menu-item">
                    <div class="menu-image">
                        <img src="https://images.unsplash.com/photo-1625944525533-473f1a3d54e7?q=80&w=2070&auto=format&fit=crop" alt="Tuna Tartare">
                    </div>
                    <div class="menu-details">
                        <h3>Tuna Tartare</h3>
                        <p>Fresh yellowfin tuna, avocado, citrus dressing, micro greens</p>
                        <div class="menu-price-action">
                            <span class="price">$24.00</span>
                            <button class="add-to-cart">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Menu Item 4 -->
                <div class="menu-item">
                    <div class="menu-image">
                        <img src="https://images.unsplash.com/photo-1551024506-0bccd828d307?q=80&w=1964&auto=format&fit=crop" alt="Chocolate Soufflé">
                    </div>
                    <div class="menu-details">
                        <h3>Chocolate Soufflé</h3>
                        <p>Dark chocolate, vanilla bean ice cream, raspberry coulis</p>
                        <div class="menu-price-action">
                            <span class="price">$18.00</span>
                            <button class="add-to-cart">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Menu Item 5 -->
                <div class="menu-item">
                    <div class="menu-image">
                        <img src="https://images.unsplash.com/photo-1544145945-f90425340c7e?q=80&w=1974&auto=format&fit=crop" alt="Signature Cocktail">
                    </div>
                    <div class="menu-details">
                        <h3>Signature Cocktail</h3>
                        <p>Aged rum, fresh lime, house-made bitters, demerara sugar</p>
                        <div class="menu-price-action">
                            <span class="price">$16.00</span>
                            <button class="add-to-cart">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Menu Item 6 -->
                <div class="menu-item">
                    <div class="menu-image">
                        <img src="https://images.unsplash.com/photo-1626082927389-6cd097cdc6ec?q=80&w=2070&auto=format&fit=crop" alt="Truffle Arancini">
                    </div>
                    <div class="menu-details">
                        <h3>Truffle Arancini</h3>
                        <p>Arborio rice, black truffle, parmesan, wild mushrooms</p>
                        <div class="menu-price-action">
                            <span class="price">$22.00</span>
                            <button class="add-to-cart">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Menu Item 7 -->
                <div class="menu-item">
                    <div class="menu-image">
                        <img src="https://images.unsplash.com/photo-1611519685019-6799cb33d0b7?q=80&w=2070&auto=format&fit=crop" alt="Lobster Risotto">
                    </div>
                    <div class="menu-details">
                        <h3>Lobster Risotto</h3>
                        <p>Maine lobster, saffron, mascarpone, lemon zest</p>
                        <div class="menu-price-action">
                            <span class="price">$48.00</span>
                            <button class="add-to-cart">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Menu Item 8 -->
                <div class="menu-item">
                    <div class="menu-image">
                        <img src="https://images.unsplash.com/photo-1587314168485-3236d6710814?q=80&w=2070&auto=format&fit=crop" alt="Crème Brûlée">
                    </div>
                    <div class="menu-details">
                        <h3>Crème Brûlée</h3>
                        <p>Tahitian vanilla bean, caramelized sugar, seasonal berries</p>
                        <div class="menu-price-action">
                            <span class="price">$16.00</span>
                            <button class="add-to-cart">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>