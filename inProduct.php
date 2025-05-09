<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FarmFresh - Categories</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                    },
                    colors: {
                        'farm-green': {
                            100: '#ecfdf5',
                            200: '#d1fae5',
                            300: '#6ee7b7',
                            400: '#34d399',
                            500: '#10b981',
                            600: '#059669',
                            700: '#047857',
                        }
                    },
                    animation: {
                        'float': 'floating 3s ease-in-out infinite',
                    },
                    keyframes: {
                        floating: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-10px)' },
                        }
                    }
                }
            }
        }
    </script>
    <style>
        .category-card:hover .emoji {
            transform: scale(1.2) rotate(5deg);
        }
        .category-card {
            transition: all 0.3s ease;
            background-size: 200% 200%;
            background-position: 0 0;
        }
        .category-card:hover {
            background-position: 100% 100%;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-farm-green-100 to-farm-green-200 min-h-screen flex flex-col font-sans">

    <!-- Header -->
    <div class="w-full flex items-center justify-between px-4 py-3 bg-white shadow-lg animate__animated animate__fadeInDown sticky top-0 z-50">
        <a href="javascript:void(0)" onclick="goBack()" class="flex items-center space-x-2">
            <button class="w-10 h-10 hover:scale-110 transition-transform duration-300 bg-farm-green-200 rounded-full flex items-center justify-center shadow-md">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-farm-green-700"> 
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
            </button>
        </a>
        <div class="flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-farm-green-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
            </svg>
            <span class="text-xl font-bold text-farm-green-700 tracking-wide">Categories</span>
        </div>
        <div class="w-10"></div> <!-- Spacer to keep header balanced -->
    </div>


    <!-- Categories Grid -->
    <div class="flex p-3 grid grid-cols-2 md:grid-cols-3 gap-3 animate__animated animate__fadeInUp">
        <!-- Vegetables -->
        <a href="vegitable.php" class="block">
            <div class="category-card bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-4 flex flex-col items-center shadow-md hover:shadow-xl transform hover:scale-105 transition-all duration-300 cursor-pointer border border-green-200">
                <span class="emoji text-5xl transition-transform duration-300">🥬</span>
                <p class="mt-2 text-base font-semibold text-gray-700">Vegetables</p>
                <p class="text-xs text-gray-500">Fresh & Organic</p>
            </div>
        </a>
        
        <!-- Fruits -->
        <a href="fruits.php" class="block">
            <div class="category-card bg-gradient-to-br from-red-50 to-red-100 rounded-xl p-4 flex flex-col items-center shadow-md hover:shadow-xl transform hover:scale-105 transition-all duration-300 cursor-pointer border border-red-200">
                <span class="emoji text-5xl transition-transform duration-300">🍎</span>
                <p class="mt-2 text-base font-semibold text-gray-700">Fruits</p>
                <p class="text-xs text-gray-500">Seasonal & Sweet</p>
            </div>
        </a>
        
        <!-- Edible Oil -->
        <a href="edibleOil.html" class="block">
            <div class="category-card bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-xl p-4 flex flex-col items-center shadow-md hover:shadow-xl transform hover:scale-105 transition-all duration-300 cursor-pointer border border-yellow-200">
                <span class="emoji text-5xl transition-transform duration-300">🫒</span>
                <p class="mt-2 text-base font-semibold text-gray-700">Edible Oil</p>
                <p class="text-xs text-gray-500">Pure & Natural</p>
            </div>
        </a>
        
        <!-- Cereals -->
        <a href="cereals.html" class="block">
            <div class="category-card bg-gradient-to-br from-amber-50 to-amber-100 rounded-xl p-4 flex flex-col items-center shadow-md hover:shadow-xl transform hover:scale-105 transition-all duration-300 cursor-pointer border border-amber-200">
                <span class="emoji text-5xl transition-transform duration-300">🌾</span>
                <p class="mt-2 text-base font-semibold text-gray-700">Cereals</p>
                <p class="text-xs text-gray-500">Whole & Nutritious</p>
            </div>
        </a>
        
        <!-- Dairy Products -->
        <a href="dairy.html" class="block">
            <div class="category-card bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-4 flex flex-col items-center shadow-md hover:shadow-xl transform hover:scale-105 transition-all duration-300 cursor-pointer border border-blue-200">
                <span class="emoji text-5xl transition-transform duration-300">🥛</span>
                <p class="mt-2 text-base font-semibold text-gray-700">Dairy</p>
                <p class="text-xs text-gray-500">Farm Fresh</p>
            </div>
        </a>
        
        <!-- Spices -->
        <a href="spices.html" class="block">
            <div class="category-card bg-gradient-to-br from-orange-50 to-orange-100 rounded-xl p-4 flex flex-col items-center shadow-md hover:shadow-xl transform hover:scale-105 transition-all duration-300 cursor-pointer border border-orange-200">
                <span class="emoji text-5xl transition-transform duration-300">🌶️</span>
                <p class="mt-2 text-base font-semibold text-gray-700">Spices</p>
                <p class="text-xs text-gray-500">Aromatic & Flavorful</p>
            </div>
        </a>
        
        <!-- Dry Fruits -->
        <a href="dryfruits.html" class="block">
            <div class="category-card bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-4 flex flex-col items-center shadow-md hover:shadow-xl transform hover:scale-105 transition-all duration-300 cursor-pointer border border-purple-200">
                <span class="emoji text-5xl transition-transform duration-300">🥜</span>
                <p class="mt-2 text-base font-semibold text-gray-700">Dry Fruits</p>
                <p class="text-xs text-gray-500">Premium Quality</p>
            </div>
        </a>
        
        <!-- Beans and Nuts -->
        <a href="beans.html" class="block">
            <div class="category-card bg-gradient-to-br from-teal-50 to-teal-100 rounded-xl p-4 flex flex-col items-center shadow-md hover:shadow-xl transform hover:scale-105 transition-all duration-300 cursor-pointer border border-teal-200">
                <span class="emoji text-5xl transition-transform duration-300">🌰</span>
                <p class="mt-2 text-base font-semibold text-gray-700">Beans & Nuts</p>
                <p class="text-xs text-gray-500">Protein Rich</p>
            </div>
        </a>
    </div>

    <!-- Floating Action Button -->
    <a href="addProduct.html" class="fixed bottom-20 right-6 bg-farm-green-600 text-white rounded-full w-14 h-14 flex items-center justify-center shadow-xl hover:bg-farm-green-700 transition-all duration-300 animate-float">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
    </a>

    <!-- Bottom Navbar -->
    <div class="fixed bottom-0 w-full bg-white shadow-lg flex justify-around py-2 border-t animate__animated animate__fadeInUp">
        <a href="index.html" class="text-farm-green-600 flex flex-col items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            <span class="text-xs font-semibold mt-1">Home</span>
        </a>
        <a href="post.html" class="text-gray-600 flex flex-col items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
            <span class="text-xs font-semibold mt-1">Post</span>
        </a>
        <a href="farmerChat.html" class="text-gray-600 flex flex-col items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
            </svg>
            <span class="text-xs font-semibold mt-1">Chat</span>
        </a>
        <a href="farmerAccount.html" class="text-gray-600 flex flex-col items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            <span class="text-xs font-semibold mt-1">Account</span>
        </a>
    </div>

    <script>
        function goBack() {
            window.history.back();
        }
    </script>
</body>
</html>