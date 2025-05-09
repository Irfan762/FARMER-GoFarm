<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GOFaRm - Select Your Role</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'pulse-slow': 'pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                        'bounce-slow': 'bounce 3s infinite',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-20px)' },
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gradient-to-br from-green-100 via-green-200 to-emerald-300 min-h-screen flex items-center justify-center p-6 md:p-10">
    
    <!-- Main Container with improved margin -->
    <div class="bg-white bg-opacity-90 rounded-3xl shadow-2xl p-8 md:p-12 w-full max-w-5xl mx-auto transform transition-all duration-500 hover:-translate-y-2 relative overflow-hidden">
        
        <!-- Background Decorations -->
        <div class="absolute text-6xl text-green-500 opacity-10 top-10 left-10 animate-float">🌾</div>
        <div class="absolute text-6xl text-yellow-500 opacity-10 bottom-10 right-10 animate-bounce-slow">🛒</div>
        <div class="absolute text-5xl text-blue-500 opacity-10 top-1/3 right-10 animate-pulse-slow">🥕</div>
        
        <!-- Logo Section -->
        <div class="text-center mb-10">
            <h2 class="inline-block text-5xl font-extrabold">
                <span class="bg-clip-text text-transparent bg-gradient-to-r from-red-500 to-amber-500">GO</span>
                <span class="bg-clip-text text-transparent bg-gradient-to-r from-blue-500 to-teal-400">FaRm</span>
            </h2>
            <p class="text-gray-500 mt-2">Digital Farming Marketplace</p>
        </div>
        
        <!-- Heading Section with improved spacing -->
        <div class="text-center mb-14">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4">Choose Your Path</h1>
            <p class="text-lg text-green-600 font-medium">Select your role to get started</p>
        </div>
        
        <!-- Cards Container with improved spacing -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-10 mb-8 max-w-4xl mx-auto">
            
            <!-- Farmer Card -->
            <a href="./loginpagefarmer.php" class="group">
                <div class="bg-white rounded-2xl shadow-lg p-8 h-full flex flex-col items-center justify-between border-b-4 border-green-500 transition-all duration-500 hover:shadow-xl hover:bg-green-50 transform hover:-translate-y-2">
                    <div class="text-6xl mb-6 group-hover:scale-110 transition-transform duration-300">👨‍🌾</div>
                    <div class="text-center">
                        <h3 class="text-2xl font-bold text-gray-800 mb-3">Farmer</h3>
                        <p class="text-gray-600 mb-6">Sell your produce directly and get fair prices for your hard work</p>
                        <button class="bg-gradient-to-r from-green-500 to-green-600 text-white font-medium py-2 px-6 rounded-full shadow-md hover:shadow-lg transform transition-all duration-300 hover:-translate-y-1">
                            Start Selling
                        </button>
                    </div>
                </div>
            </a>
            
            <!-- Retailer Card -->
            <a href="./loginpageRetailer.php" class="group">
                <div class="bg-white rounded-2xl shadow-lg p-8 h-full flex flex-col items-center justify-between border-b-4 border-yellow-500 transition-all duration-500 hover:shadow-xl hover:bg-yellow-50 transform hover:-translate-y-2">
                    <div class="text-6xl mb-6 group-hover:scale-110 transition-transform duration-300">🏪</div>
                    <div class="text-center">
                        <h3 class="text-2xl font-bold text-gray-800 mb-3">Retailer</h3>
                        <p class="text-gray-600 mb-6">Source quality products at wholesale prices for your business</p>
                        <button class="bg-gradient-to-r from-yellow-500 to-amber-600 text-white font-medium py-2 px-6 rounded-full shadow-md hover:shadow-lg transform transition-all duration-300 hover:-translate-y-1">
                            Start Sourcing
                        </button>
                    </div>
                </div>
            </a>
            
            <!-- Consumer Card -->
            <a href="./loginpagecustomer.php" class="group">
                <div class="bg-white rounded-2xl shadow-lg p-8 h-full flex flex-col items-center justify-between border-b-4 border-blue-500 transition-all duration-500 hover:shadow-xl hover:bg-blue-50 transform hover:-translate-y-2">
                    <div class="text-6xl mb-6 group-hover:scale-110 transition-transform duration-300">🛒</div>
                    <div class="text-center">
                        <h3 class="text-2xl font-bold text-gray-800 mb-3">Consumer</h3>
                        <p class="text-gray-600 mb-6">Buy fresh, quality produce directly from local farmers</p>
                        <button class="bg-gradient-to-r from-blue-500 to-blue-600 text-white font-medium py-2 px-6 rounded-full shadow-md hover:shadow-lg transform transition-all duration-300 hover:-translate-y-1">
                            Start Shopping
                        </button>
                    </div>
                </div>
            </a>
        </div>
        
        <!-- Footer -->
        <div class="text-center text-gray-500 text-sm mt-10">
            <p>Choose a role to continue your farming journey</p>
        </div>
    </div>
</body>
</html>