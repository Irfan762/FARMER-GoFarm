<?php
// Database configuration
$servername = "localhost";
$username = "root"; // Change to your MySQL username
$password = ""; // Change to your MySQL password
$dbname = "farmer";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle AJAX requests for product data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (isset($data['action'])) {
        switch ($data['action']) {
            case 'getProducts':
                $category = $data['category'] ?? '';
                getProducts($conn, $category);
                break;
                
            case 'searchProducts':
                $query = $data['query'] ?? '';
                searchProducts($conn, $query);
                break;
                
            default:
                echo json_encode(['error' => 'Invalid action']);
        }
        exit;
    }
}

// Function to get products by category
function getProducts($conn, $category) {
    if (!empty($category)) {
        $stmt = $conn->prepare("SELECT * FROM productss WHERE category = ?");
        $stmt->bind_param("s", $category);
    } else {
        $stmt = $conn->prepare("SELECT * FROM productss");
    }
    
    $stmt->execute();
    $result = $stmt->get_result();
    
    $products = [];
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
    
    echo json_encode(['products' => $products]);
    $stmt->close();
}

// Function to search products
function searchProducts($conn, $query) {
    $search = "%$query%";
    $stmt = $conn->prepare("SELECT * FROM productss WHERE name LIKE ?");
    $stmt->bind_param("s", $search);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $products = [];
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
    
    echo json_encode(['products' => $products]);
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farmer Connect</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        html {
            scroll-behavior: smooth;
            font-family: 'Poppins', sans-serif;
        }
        
        .hero-section {
            background-image: url('https://images.unsplash.com/photo-1550989460-0adf9ea622e2?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            background-position: center;
        }
        
        .active-category {
            background-color: #f0fdf4;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            color: #16a34a;
            font-weight: 600;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .product-card {
            animation: fadeIn 0.3s ease-out;
        }
        
        .toast {
            position: fixed;
            bottom: 20px;
            right: 20px;
            padding: 12px 24px;
            color: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            animation: slideIn 0.3s ease forwards, fadeOut 0.3s ease 2s forwards;
        }
        
        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        
        @keyframes fadeOut {
            from { opacity: 1; }
            to { opacity: 0; visibility: hidden; }
        }
        
        .product-img {
            transition: transform 0.3s ease;
        }
        
        .product-card:hover .product-img {
            transform: scale(1.05);
        }
        
        .category-btn {
            transition: all 0.3s ease;
        }
        
        .category-btn:hover {
            transform: translateY(-5px);
        }
        
        .skeleton {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: loading 1.5s infinite;
        }
        
        @keyframes loading {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }
    </style>
</head>
<body class="bg-gradient-to-br from-green-50 to-green-100 min-h-screen">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg sticky top-0 z-50 px-6 py-4 flex justify-between items-center">
        <h2 class="text-3xl font-bold">
            <span class="text-green-600">🌾 GO</span>
            <span class="text-yellow-600">FaRm</span>
        </h2>
        <div class="relative w-1/3">
            <input type="text" id="searchBar" class="w-full pl-10 pr-4 py-2 rounded-full border-2 border-green-300 focus:border-green-500 focus:outline-none" placeholder="Search fresh products...">
            <i class="fas fa-search absolute left-3 top-3 text-green-500"></i>
        </div>
        <button id="cartBtn" class="bg-green-600 hover:bg-green-700 transition-colors text-white px-6 py-2 rounded-full flex items-center space-x-2">
            <i class="fas fa-shopping-basket"></i>
            <span>Cart (<span id="cartCount">0</span>)</span>
        </button>
    </nav>

    <!-- Hero Section -->
    <div class="hero-section relative">
        <div class="absolute inset-0 bg-black bg-opacity-40"></div>
        <div class="relative z-10 text-center py-28 px-4">
            <h1 class="text-5xl md:text-6xl font-extrabold text-white drop-shadow-lg">
                Fresh from <span class="text-yellow-400">Farm</span> to <span class="text-green-300">Table</span>
            </h1>
            <p class="mt-4 text-xl text-white max-w-2xl mx-auto drop-shadow-lg">
                Support local farmers and enjoy the freshest produce delivered to your doorstep!
            </p>
            <button class="mt-8 bg-yellow-500 hover:bg-yellow-600 transition-colors text-white px-8 py-3 rounded-full font-bold text-lg">
                Shop Now <i class="fas fa-arrow-right ml-2"></i>
            </button>
        </div>
    </div>

    <!-- Categories and Products -->
    <div class="container mx-auto px-4 py-12">
        <div class="flex gap-4 justify-center mb-12 flex-wrap">
            <button data-category="Vegetables" class="category-btn bg-white p-4 rounded-lg text-center shadow hover:shadow-lg flex flex-col items-center active-category">
                <div class="text-3xl text-green-600 mb-2"><i class="fas fa-carrot"></i></div>
                <span>Vegetables</span>
            </button>
            <button data-category="Fruits" class="category-btn bg-white p-4 px-6 rounded-lg text-center shadow hover:shadow-lg flex flex-col items-center">
                <div class="text-3xl text-red-500 mb-2"><i class="fas fa-apple-alt"></i></div>
                <span>Fruits</span>
            </button>
            <button data-category="Spices" class="category-btn bg-white p-4 rounded-lg text-center shadow hover:shadow-lg flex flex-col items-center">
                <div class="text-3xl text-yellow-600 mb-2"><i class="fas fa-pepper-hot"></i></div>
                <span>Spices</span>
            </button>
            <button data-category="Dry Fruits" class="category-btn bg-white p-4 rounded-lg text-center shadow hover:shadow-lg flex flex-col items-center">
                <div class="text-3xl text-amber-700 mb-2"><i class="fas fa-seedling"></i></div>
                <span>Dry Fruits</span>
            </button>
        </div>

        <!-- Products Grid -->
        <div id="productsGrid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
            <!-- Initial products are loaded here -->
            <?php
            // Load initial vegetable products for page load
            $stmt = $conn->prepare("SELECT * FROM productss WHERE category = 'Vegetables'");
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                while ($product = $result->fetch_assoc()) {
                    $isOrganic = rand(0, 1) > 0.5; // Random organic flag
                    echo "
                    <div class='product-card bg-white rounded-lg shadow-lg overflow-hidden transition-all hover:shadow-xl'>
                        <div class='overflow-hidden h-48'>
                            <img src='{$product['image']}' alt='{$product['name']}' class='product-img w-full h-full object-cover' onerror=\"this.src='image/default.jpeg'\">
                            <div class='absolute top-2 left-2 " . ($isOrganic ? 'bg-yellow-500' : 'bg-green-600') . " text-white text-xs px-2 py-1 rounded-full'>
                                " . ($isOrganic ? 'Organic' : 'Fresh') . "
                            </div>
                        </div>
                        <div class='p-4'>
                            <div class='flex justify-between items-start'>
                                <h3 class='text-lg font-semibold'>{$product['name']}</h3>
                                <span class='text-green-700 font-bold'>₹{$product['price']}</span>
                            </div>
                            <p class='text-gray-500 text-sm mt-1'>Per Kg</p>
                            <div class='flex justify-between items-center mt-4'>
                                <div class='text-yellow-500'>
                                    " . generateRatingStars(4 + (rand(0, 10) / 10)) . "
                                </div>
                                <button class='add-to-cart-btn bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded-lg transition-colors flex items-center' 
                                    onclick='addToCart(\"{$product['name']}\", {$product['price']}, \"{$product['image']}\")'>
                                    <i class='fas fa-plus mr-1'></i> Add
                                </button>
                            </div>
                        </div>
                    </div>";
                }
            } else {
                echo "
                <div class='col-span-full text-center py-16'>
                    <i class='fas fa-leaf text-green-200 text-6xl'></i>
                    <p class='text-xl text-gray-600 mt-4'>No products found</p>
                </div>";
            }
            $stmt->close();
            
            // Helper function to generate star ratings
            function generateRatingStars($rating) {
                $rating = round($rating * 2) / 2; // Round to nearest 0.5
                $starsHTML = '';
                
                for ($i = 1; $i <= 5; $i++) {
                    if ($i <= $rating && $rating % 1 === 0) {
                        // Full star
                        $starsHTML .= '<i class="fas fa-star"></i>';
                    } else if ($i - 0.5 <= $rating && $rating % 1 !== 0) {
                        // Half star
                        $starsHTML .= '<i class="fas fa-star-half-alt"></i>';
                    } else {
                        // Empty star
                        $starsHTML .= '<i class="far fa-star"></i>';
                    }
                }
                
                return $starsHTML;
            }
            ?>
        </div>
    </div>

    <!-- Features Section -->
    <div class="bg-white py-16">
        <div class="container mx-auto px-4">
            <h2 class="text-4xl font-bold text-center text-gray-800 mb-12">Why Choose GOFaRm?</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center p-6">
                    <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-leaf text-2xl text-green-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">100% Fresh</h3>
                    <p class="text-gray-600">All products are harvested fresh from local farms and delivered to your door within 24 hours.</p>
                </div>
                <div class="text-center p-6">
                    <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-hand-holding-usd text-2xl text-green-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Fair Prices</h3>
                    <p class="text-gray-600">By cutting out middlemen, we ensure farmers get better income and you pay less.</p>
                </div>
                <div class="text-center p-6">
                    <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-truck text-2xl text-green-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Fast Delivery</h3>
                    <p class="text-gray-600">Order before noon to get your fresh produce delivered the same day.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Cart Sidebar -->
    <div id="cartSidebar" class="fixed top-0 right-0 w-full z-50 md:w-1/3 bg-white h-full shadow-2xl p-6 transform translate-x-full transition-transform duration-300">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-3xl font-bold text-green-700">
                <i class="fas fa-shopping-basket mr-2"></i> Your Cart
            </h2>
            <button onclick="toggleCart()" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times text-2xl"></i>
            </button>
        </div>
        
        <div id="cartItems" class="text-gray-700 max-h-[60vh] overflow-y-auto">
            <!-- Cart items will be loaded here -->
        </div>
        
        <div class="bg-gray-50 p-4 rounded-lg mt-6">
            <div class="flex justify-between text-lg">
                <span>Subtotal:</span>
                <span id="subtotalAmount" class="font-semibold">₹0</span>
            </div>
            <div class="flex justify-between text-lg">
                <span>Delivery:</span>
                <span class="font-semibold">₹40</span>
            </div>
            <div class="flex justify-between text-xl mt-2 pt-2 border-t border-gray-300">
                <span class="font-bold">Total:</span>
                <span id="totalAmount" class="font-bold text-green-700">₹0</span>
            </div>
        </div>
        
        <button id="checkoutBtn" class="bg-green-600 hover:bg-green-700 transition-colors text-white px-6 py-3 rounded-lg mt-6 w-full flex items-center justify-center space-x-2">
            <i class="fas fa-credit-card"></i>
            <span>Proceed to Checkout</span>
        </button>
    </div>

    <!-- Success Modal -->
    <div id="successModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-lg p-8 max-w-md w-full">
            <div class="text-center">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto">
                    <i class="fas fa-check text-3xl text-green-600"></i>
                </div>
                <h3 class="text-2xl font-bold mt-4">Payment Successful!</h3>
                <p class="mt-2 text-gray-600">Thank you for shopping with GOFaRm!</p>
                <button id="closeModalBtn" class="mt-6 bg-green-600 hover:bg-green-700 transition-colors text-white px-6 py-2 rounded-lg">
                    Continue Shopping
                </button>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-12 mt-16">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h3 class="text-2xl font-bold mb-4">
                        <span class="text-green-400">🌾 GO</span>
                        <span class="text-yellow-400">FaRm</span>
                    </h3>
                    <p class="text-gray-300">
                        Connecting farmers directly with consumers for fresher produce and fair prices.
                    </p>
                </div>
                <div>
                    <h4 class="text-xl font-semibold mb-4">Quick Links</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-300 hover:text-white">About Us</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white">How It Works</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white">Become a Partner</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white">FAQ</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-xl font-semibold mb-4">Contact Us</h4>
                    <ul class="space-y-2 text-gray-300">
                        <li><i class="fas fa-envelope mr-2"></i> support@gofarm.com</li>
                        <li><i class="fas fa-phone mr-2"></i> +91 9876543210</li>
                        <li><i class="fas fa-map-marker-alt mr-2"></i> Farm Valley, Green City</li>
                    </ul>
                </div>
            </div>
            <div class="mt-8 pt-8 border-t border-gray-700 text-center text-gray-400">
                &copy; 2025 GOFaRm. All rights reserved.
            </div>
        </div>
    </footer>

    <script>
        // Global cart state
        let cart = {};
        const deliveryFee = 40;

        // Initialize the application
        document.addEventListener('DOMContentLoaded', () => {
            setupEventListeners();
            loadCartFromStorage();
        });

        // Setup event listeners
        function setupEventListeners() {
            // Category buttons
            document.querySelectorAll('.category-btn').forEach(btn => {
                btn.addEventListener('click', (e) => {
                    const category = e.currentTarget.dataset.category;
                    setActiveCategory(category);
                    loadProducts(category);
                });
            });

            // Search functionality
            const searchBar = document.getElementById('searchBar');
            searchBar.addEventListener('keyup', debounce((e) => {
                if (e.key === 'Enter' || e.target.value.length > 2 || e.target.value.length === 0) {
                    searchProducts(e.target.value);
                }
            }, 300));

            // Cart toggle
            document.getElementById('cartBtn').addEventListener('click', toggleCart);
            
            // Checkout
            document.getElementById('checkoutBtn').addEventListener('click', processPayment);
            
            // Close modal
            document.getElementById('closeModalBtn').addEventListener('click', () => {
                document.getElementById('successModal').classList.add('hidden');
            });
        }

        // Debounce function for search
        function debounce(func, wait) {
            let timeout;
            return function(...args) {
                clearTimeout(timeout);
                timeout = setTimeout(() => func.apply(this, args), wait);
            };
        }

        // Load products using AJAX
        async function loadProducts(category) {
            const productsGrid = document.getElementById('productsGrid');
            productsGrid.innerHTML = ''; // Clear existing products
            
            // Add loading skeletons
            for (let i = 0; i < 4; i++) {
                productsGrid.innerHTML += `
                    <div class="bg-white p-6 rounded-lg shadow-lg">
                        <div class="h-40 w-full rounded-lg skeleton mb-4"></div>
                        <div class="h-6 w-3/4 skeleton mb-2"></div>
                        <div class="h-4 w-1/2 skeleton"></div>
                    </div>
                `;
            }
            
            try {
                const response = await fetch(window.location.href, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ 
                        action: 'getProducts',
                        category: category
                    }),
                });
                
                const data = await response.json();
                
                // Clear loading skeletons
                productsGrid.innerHTML = '';
                
                if (data.products && data.products.length > 0) {
                    data.products.forEach(product => {
                        const isOrganic = Math.random() > 0.5; // Random organic flag
                        const productCard = document.createElement('div');
                        productCard.className = 'product-card bg-white rounded-lg shadow-lg overflow-hidden transition-all hover:shadow-xl';
                        
                        // Generate random rating
                        const rating = 4 + Math.random();
                        let starsHTML = '';
                        const roundedRating = Math.round(rating * 2) / 2; // Round to nearest 0.5
                        
                        for (let i = 1; i <= 5; i++) {
                            if (i <= roundedRating && roundedRating % 1 === 0) {
                                // Full star
                                starsHTML += '<i class="fas fa-star"></i>';
                            } else if (i - 0.5 <= roundedRating && roundedRating % 1 !== 0) {
                                // Half star
                                starsHTML += '<i class="fas fa-star-half-alt"></i>';
                            } else {
                                // Empty star
                                starsHTML += '<i class="far fa-star"></i>';
                            }
                        }
                        
                        productCard.innerHTML = `
                            <div class="overflow-hidden h-48">
                                <img src="${product.image}" alt="${product.name}" class="product-img w-full h-full object-cover" onerror="this.src='image/default.jpeg'">
                                <div class="absolute top-2 left-2 ${isOrganic ? 'bg-yellow-500' : 'bg-green-600'} text-white text-xs px-2 py-1 rounded-full">
                                    ${isOrganic ? 'Organic' : 'Fresh'}
                                </div>
                            </div>
                            <div class="p-4">
                                <div class="flex justify-between items-start">
                                    <h3 class="text-lg font-semibold">${product.name}</h3>
                                    <span class="text-green-700 font-bold">₹${product.price}</span>
                                </div>
                                <p class="text-gray-500 text-sm mt-1">Per Kg</p>
                                <div class="flex justify-between items-center mt-4">
                                    <div class="text-yellow-500">
                                        ${starsHTML}
                                    </div>
                                    <button class="add-to-cart-btn bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded-lg transition-colors flex items-center">
                                        <i class="fas fa-plus mr-1"></i> Add
                                    </button>
                                </div>
                            </div>
                        `;
                        
                        productsGrid.appendChild(productCard);
                        
                        // Add event listener to the button
                        productCard.querySelector('.add-to-cart-btn').addEventListener('click', () => {
                            addToCart(product.name, product.price, product.image);
                        });
                    });
                } else {
                    productsGrid.innerHTML = `
                        <div class="col-span-full text-center py-16">
                            <i class="fas fa-leaf text-green-200 text-6xl"></i>
                            <p class="text-xl text-gray-600 mt-4">No products found in this category</p>
                        </div>
                    `;
                }
            } catch (error) {
                console.error('Error:', error);
                productsGrid.innerHTML = `
                    <div class="col-span-full text-center py-16">
                        <i class="fas fa-exclamation-triangle text-red-400 text-6xl"></i>
                        <p class="text-xl text-gray-600 mt-4">Error loading products. Please try again.</p>
                    </div>
                `;
            }
        }

        // Search products
        async function searchProducts(query) {
            if (!query) {
                return loadProducts('Vegetables');
            }
            
            const productsGrid = document.getElementById('productsGrid');
            productsGrid.innerHTML = ''; // Clear existing products
            
            // Add loading skeletons
            for (let i = 0; i < 4; i++) {
                productsGrid.innerHTML += `
                    <div class="bg-white p-6 rounded-lg shadow-lg">
                        <div class="h-40 w-full rounded-lg skeleton mb-4"></div>
                        <div class="h-6 w-3/4 skeleton mb-2"></div>
                        <div class="h-4 w-1/2 skeleton"></div>
                    </div>
                `;
            }
            
            try {
                const response = await fetch(window.location.href, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ 
                        action: 'searchProducts',
                        query: query
                    }),
                });
                
                const data = await response.json();
                
                // Clear loading skeletons
                productsGrid.innerHTML = '';
                
                if (data.products && data.products.length > 0) {
                    data.products.forEach(product => {
                        const isOrganic = Math.random() > 0.5; // Random organic flag
                        const productCard = document.createElement('div');
                        productCard.className = 'product-card bg-white rounded-lg shadow-lg overflow-hidden transition-all hover:shadow-xl';
                        
                        // Generate random rating
                        const rating = 4 + Math.random();
                        let starsHTML = '';
                        const roundedRating = Math.round(rating * 2) / 2; // Round to nearest 0.5
                        
                        for (let i = 1; i <= 5; i++) {
                            if (i <= roundedRating && roundedRating % 1 === 0) {
                                // Full star
                                starsHTML += '<i class="fas fa-star"></i>';
                            } else if (i - 0.5 <= roundedRating && roundedRating % 1 !== 0) {
                                // Half star
                                starsHTML += '<i class="fas fa-star-half-alt"></i>';
                            } else {
                                // Empty star
                                starsHTML += '<i class="far fa-star"></i>';
                            }
                        }
                        
                       /* Continuation of the GOFaRm website code */

// The code was cut off in the middle of product card HTML. Here's the completion:
productCard.innerHTML = `
                            <div class="overflow-hidden h-48">
                                <img src="${product.image}" alt="${product.name}" class="product-img w-full h-full object-cover" onerror="this.src='image/default.jpeg'">
                                <div class="absolute top-2 left-2 ${isOrganic ? 'bg-yellow-500' : 'bg-green-600'} text-white text-xs px-2 py-1 rounded-full">
                                    ${isOrganic ? 'Organic' : 'Fresh'}
                                </div>
                            </div>
                            <div class="p-4">
                                <div class="flex justify-between items-start">
                                    <h3 class="text-lg font-semibold">${product.name}</h3>
                                    <span class="text-green-700 font-bold">₹${product.price}</span>
                                </div>
                                <p class="text-gray-500 text-sm mt-1">Per Kg</p>
                                <div class="flex justify-between items-center mt-4">
                                    <div class="text-yellow-500">
                                        ${starsHTML}
                                    </div>
                                    <button class="add-to-cart-btn bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded-lg transition-colors flex items-center">
                                        <i class="fas fa-plus mr-1"></i> Add
                                    </button>
                                </div>
                            </div>
                        `;
                        
                        productsGrid.appendChild(productCard);
                        
                        // Add event listener to the button
                        productCard.querySelector('.add-to-cart-btn').addEventListener('click', () => {
                            addToCart(product.name, product.price, product.image);
                        });
                    });
                } else {
                    productsGrid.innerHTML = `
                        <div class="col-span-full text-center py-16">
                            <i class="fas fa-search text-green-200 text-6xl"></i>
                            <p class="text-xl text-gray-600 mt-4">No products found matching "${query}"</p>
                        </div>
                    `;
                }
            } catch (error) {
                console.error('Error:', error);
                productsGrid.innerHTML = `
                    <div class="col-span-full text-center py-16">
                        <i class="fas fa-exclamation-triangle text-red-400 text-6xl"></i>
                        <p class="text-xl text-gray-600 mt-4">Error searching products. Please try again.</p>
                    </div>
                `;
            }
        }

        // Set active category
        function setActiveCategory(category) {
            document.querySelectorAll('.category-btn').forEach(btn => {
                if (btn.dataset.category === category) {
                    btn.classList.add('active-category');
                } else {
                    btn.classList.remove('active-category');
                }
            });
        }

        // Add to cart
        function addToCart(name, price, image) {
            if (cart[name]) {
                cart[name].quantity += 1;
            } else {
                cart[name] = {
                    price: price,
                    image: image,
                    quantity: 1
                };
            }
            
            // Update cart storage & UI
            saveCartToStorage();
            updateCartUI();
            
            // Show toast notification
            showToast(`Added ${name} to cart!`, 'bg-green-600');
        }

        // Show toast notification
        function showToast(message, bgClass) {
            // Remove existing toast if any
            const existingToast = document.querySelector('.toast');
            if (existingToast) {
                existingToast.remove();
            }
            
            const toast = document.createElement('div');
            toast.className = `toast ${bgClass}`;
            toast.innerText = message;
            document.body.appendChild(toast);
            
            // Auto remove after animation completes
            setTimeout(() => {
                toast.remove();
            }, 3000);
        }

        // Update cart UI
        function updateCartUI() {
            const cartCount = document.getElementById('cartCount');
            const cartItems = document.getElementById('cartItems');
            const subtotalAmount = document.getElementById('subtotalAmount');
            const totalAmount = document.getElementById('totalAmount');
            
            // Calculate total quantity and amount
            let totalQuantity = 0;
            let subtotal = 0;
            
            for (const item in cart) {
                totalQuantity += cart[item].quantity;
                subtotal += cart[item].price * cart[item].quantity;
            }
            
            // Update cart count
            cartCount.textContent = totalQuantity;
            
            // Update cart items
            cartItems.innerHTML = '';
            
            if (totalQuantity === 0) {
                cartItems.innerHTML = `
                    <div class="text-center py-12">
                        <i class="fas fa-shopping-basket text-gray-300 text-5xl"></i>
                        <p class="text-gray-500 mt-4">Your cart is empty</p>
                    </div>
                `;
            } else {
                for (const item in cart) {
                    const cartItem = document.createElement('div');
                    cartItem.className = 'flex items-center mb-4 pb-4 border-b border-gray-200';
                    cartItem.innerHTML = `
                        <img src="${cart[item].image}" alt="${item}" class="w-16 h-16 object-cover rounded-lg" onerror="this.src='image/default.jpeg'">
                        <div class="ml-4 flex-grow">
                            <h4 class="font-semibold">${item}</h4>
                            <p class="text-green-700">₹${cart[item].price} x ${cart[item].quantity}</p>
                        </div>
                        <div class="flex flex-col items-center">
                            <button class="text-green-700 hover:text-green-800" onclick="updateQuantity('${item}', 1)">
                                <i class="fas fa-plus-circle"></i>
                            </button>
                            <span class="my-1">${cart[item].quantity}</span>
                            <button class="text-red-500 hover:text-red-600" onclick="updateQuantity('${item}', -1)">
                                <i class="fas fa-minus-circle"></i>
                            </button>
                        </div>
                    `;
                    cartItems.appendChild(cartItem);
                }
            }
            
            // Update totals
            subtotalAmount.textContent = `₹${subtotal}`;
            totalAmount.textContent = `₹${subtotal + deliveryFee}`;
        }

        // Update item quantity
        function updateQuantity(item, change) {
            if (cart[item]) {
                cart[item].quantity += change;
                
                if (cart[item].quantity <= 0) {
                    delete cart[item];
                }
                
                saveCartToStorage();
                updateCartUI();
            }
        }

        // Toggle cart sidebar
        function toggleCart() {
            const cartSidebar = document.getElementById('cartSidebar');
            cartSidebar.classList.toggle('translate-x-full');
        }

        // Save cart to localStorage
        function saveCartToStorage() {
            localStorage.setItem('gofarmCart', JSON.stringify(cart));
        }

        // Load cart from localStorage
        function loadCartFromStorage() {
            const savedCart = localStorage.getItem('gofarmCart');
            if (savedCart) {
                cart = JSON.parse(savedCart);
                updateCartUI();
            }
        }

        // Process payment
        function processPayment() {
            // Check if cart has items
            let hasItems = false;
            for (const item in cart) {
                hasItems = true;
                break;
            }
            
            if (!hasItems) {
                showToast('Your cart is empty!', 'bg-red-500');
                return;
            }
            
            // Simulate payment processing
            const checkoutBtn = document.getElementById('checkoutBtn');
            checkoutBtn.disabled = true;
            checkoutBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
            
            setTimeout(() => {
                // Show success modal
                document.getElementById('successModal').classList.remove('hidden');
                
                // Reset cart
                cart = {};
                saveCartToStorage();
                updateCartUI();
                
                // Reset button
                checkoutBtn.disabled = false;
                checkoutBtn.innerHTML = '<i class="fas fa-credit-card"></i> <span>Proceed to Checkout</span>';
                
                // Close cart sidebar
                toggleCart();
            }, 2000);
        }
    </script>
</body>
</html>