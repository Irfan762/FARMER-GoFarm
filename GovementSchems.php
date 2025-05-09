<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Future Demand</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
    
    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #e6fffa 0%, #ebf4ff 100%);
      min-height: 100vh;
    }
    
    .glass-card {
      background: rgba(255, 255, 255, 0.9);
      backdrop-filter: blur(10px);
      border-radius: 1rem;
      border: 1px solid rgba(255, 255, 255, 0.2);
      box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
      transition: all 0.3s ease;
    }
    
    .glass-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
    }
    
    .btn-primary {
      background: linear-gradient(45deg, #22c55e, #10b981);
      color: white;
      border-radius: 0.5rem;
      padding: 0.5rem 1.5rem;
      box-shadow: 0 4px 14px rgba(34, 197, 94, 0.4);
      transition: all 0.3s ease;
    }
    
    .btn-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(34, 197, 94, 0.6);
    }
    
    .custom-select {
      background-image: linear-gradient(45deg, #f0fdf4, #dcfce7);
      border: 2px solid #22c55e;
      border-radius: 0.75rem;
      padding: 0.75rem 1rem;
      transition: all 0.3s ease;
    }
    
    .custom-select:focus {
      outline: none;
      box-shadow: 0 0 0 3px rgba(34, 197, 94, 0.3);
    }
    
    .scheme-card {
      border-radius: 1rem;
      overflow: hidden;
      transition: all 0.3s ease;
      position: relative;
      border-left: 4px solid #22c55e;
    }
    
    .scheme-card:hover {
      transform: translateY(-5px);
    }
    
    .scheme-card:before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: linear-gradient(45deg, rgba(16, 185, 129, 0.05), rgba(52, 211, 153, 0.1));
      z-index: -1;
    }
    
    .page-title {
      background: linear-gradient(45deg, #22c55e, #10b981);
      -webkit-background-clip: text;
      background-clip: text;
      color: transparent;
      text-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    }
    
    .header-wave {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      overflow: hidden;
      line-height: 0;
      z-index: -1;
    }
    
    .header-wave svg {
      position: relative;
      display: block;
      width: calc(100% + 1.3px);
      height: 150px;
    }
    
    .header-wave .shape-fill {
      fill: rgba(16, 185, 129, 0.1);
    }
  </style>
</head>
<body>
      <a href="./farmerWeb.html">
            <button class="w-10 h-10 transition-all duration-300 hover:scale-110">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="black"> 
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
            </button>
        </a>
  <div class="header-wave">
    <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
      <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z" class="shape-fill"></path>
    </svg>
  </div>

  
  

  <div class="container mx-auto py-10 px-4">
    <!-- Header Section -->
    <header class="text-center mb-12 animate__animated animate__fadeIn">
      <h1 class="text-4xl md:text-5xl font-bold mb-4 page-title">Future Demand</h1>
      <p class="text-lg text-gray-600 max-w-2xl mx-auto">Discover government schemes and resources for agricultural advancement across India</p>
    </header>

    <!-- Govt Schemes Section -->
    <div class="glass-card p-8 animate__animated animate__fadeIn animate__slower">
      <div class="flex items-center justify-between mb-8">
        <h2 class="text-2xl font-bold text-green-600 flex items-center">
          <i class="fas fa-landmark mr-3"></i> Government Schemes
        </h2>
        <div class="relative">
          <select id="stateSelect" class="custom-select pr-10 pl-4 appearance-none" onchange="filterSchemes()">
            <option value="all">All States</option>
            <option value="maharashtra">Maharashtra</option>
            <option value="gujarat">Gujarat</option>
            <option value="punjab">Punjab</option>
            <option value="tamilnadu">Tamil Nadu</option>
          </select>
          <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-green-600">
            <i class="fas fa-chevron-down"></i>
          </div>
        </div>
      </div>
      
      <div id="schemeCards" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6"></div>
    </div>
    
    <!-- Stats Section -->
    <div class="glass-card p-8 mt-12 animate__animated animate__fadeIn animate__slower">
      <h2 class="text-2xl font-bold text-green-600 mb-8 flex items-center">
        <i class="fas fa-chart-line mr-3"></i> Agricultural Statistics
      </h2>
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div>
          <canvas id="cropProductionChart"></canvas>
        </div>
        <div>
          <canvas id="irrigationChart"></canvas>
        </div>
      </div>
    </div>
    
    <!-- Footer -->
    <footer class="mt-12 text-center text-gray-600">
      <p>&copy; 2025 Future Demand. All rights reserved.</p>
    </footer>
  </div>

<script>
  const schemes = {
    maharashtra: [
      { name: 'PM Kisan Yojana', description: 'Income support for farmers with direct benefit transfer', link: 'https://pmkisan.gov.in/', icon: 'fa-hand-holding-dollar' },
      { name: 'Soil Health Card Scheme', description: 'Soil testing and nutrient recommendations for improved yields', link: 'https://www.soilhealth.dac.gov.in/', icon: 'fa-seedling' },
      { name: 'Drip Irrigation Subsidy', description: 'Financial assistance for water-efficient irrigation systems', link: 'https://www.mahaagri.gov.in/', icon: 'fa-faucet-drip' }
    ],
    gujarat: [
      { name: 'Mukhyamantri Kisan Yojana', description: 'State-level financial assistance for farmers', link: 'https://ikhedut.gujarat.gov.in/', icon: 'fa-indian-rupee-sign' },
      { name: 'Krishi Input Subsidy', description: 'Subsidies on agricultural inputs like seeds and fertilizers', link: 'https://ikhedut.gujarat.gov.in/', icon: 'fa-wheat-awn' },
      { name: 'Organic Farming Subsidy', description: 'Support for transition to organic farming methods', link: 'https://ikhedut.gujarat.gov.in/', icon: 'fa-leaf' }
    ],
    punjab: [
      { name: 'Punjab Pani Bachao', description: 'Water conservation initiative with incentives', link: 'https://agripb.gov.in/', icon: 'fa-droplet' },
      { name: 'Crop Insurance Scheme', description: 'Risk management and financial protection for farmers', link: 'https://pmfby.gov.in/', icon: 'fa-shield' },
      { name: 'Agri Export Promotion', description: 'Support for farmers to export their produce globally', link: 'https://agriexport.gov.in/', icon: 'fa-ship' }
    ],
    tamilnadu: [
      { name: 'Tamil Nadu Agri Insurance', description: 'State-specific crop insurance plans', link: 'https://www.tnagrisnet.tn.gov.in/', icon: 'fa-umbrella' },
      { name: 'Drip Irrigation Scheme', description: 'Water conservation technology subsidies', link: 'https://www.tnagrisnet.tn.gov.in/', icon: 'fa-faucet' },
      { name: 'Soil Health Card', description: 'Soil testing and nutrient recommendations', link: 'https://www.soilhealth.dac.gov.in/', icon: 'fa-microscope' }
    ]
  };

  // Render scheme cards
  Object.keys(schemes).forEach(state => {
    schemes[state].forEach(({ name, description, link, icon }) => {
      document.getElementById('schemeCards').innerHTML += `
        <div class="scheme-card glass-card p-6 animate__animated animate__zoomIn" data-state="${state}">
          <div class="flex items-start mb-4">
            <div class="bg-green-100 p-3 rounded-full mr-4">
              <i class="fas ${icon} text-green-600 text-xl"></i>
            </div>
            <div>
              <h3 class="text-xl font-bold text-gray-800">${name}</h3>
              <p class="text-gray-600 mt-1 text-sm">${description}</p>
            </div>
          </div>
          <a href="${link}" target="_blank" class="btn-primary inline-flex items-center mt-4">
            <span>Apply Now</span>
            <i class="fas fa-arrow-right ml-2"></i>
          </a>
        </div>`;
    });
  });

  function filterSchemes() {
    const selectedState = document.getElementById('stateSelect').value;
    const schemes = document.querySelectorAll('.scheme-card');
    
    schemes.forEach(scheme => {
      const state = scheme.getAttribute('data-state');
      if (selectedState === 'all' || selectedState === state) {
        scheme.classList.remove('animate__fadeOut');
        scheme.classList.add('animate__fadeIn');
        setTimeout(() => {
          scheme.style.display = "block";
        }, 300);
      } else {
        scheme.classList.remove('animate__fadeIn');
        scheme.classList.add('animate__fadeOut');
        setTimeout(() => {
          scheme.style.display = "none";
        }, 300);
      }
    });
  }

  // Crop Production Chart
  const cropCtx = document.getElementById('cropProductionChart').getContext('2d');
  new Chart(cropCtx, {
    type: 'bar',
    data: {
      labels: ['Wheat', 'Rice', 'Maize', 'Pulses', 'Oilseeds'],
      datasets: [{
        label: 'Production (Million Tonnes)',
        data: [105, 120, 30, 25, 35],
        backgroundColor: [
          'rgba(34, 197, 94, 0.8)',
          'rgba(16, 185, 129, 0.8)',
          'rgba(5, 150, 105, 0.8)',
          'rgba(4, 120, 87, 0.8)',
          'rgba(6, 95, 70, 0.8)'
        ],
        borderColor: [
          'rgba(34, 197, 94, 1)',
          'rgba(16, 185, 129, 1)',
          'rgba(5, 150, 105, 1)',
          'rgba(4, 120, 87, 1)',
          'rgba(6, 95, 70, 1)'
        ],
        borderWidth: 1
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: {
          position: 'top',
        },
        title: {
          display: true,
          text: 'Crop Production Statistics'
        }
      }
    }
  });

  // Irrigation Chart
  const irrigationCtx = document.getElementById('irrigationChart').getContext('2d');
  new Chart(irrigationCtx, {
    type: 'doughnut',
    data: {
      labels: ['Canal Irrigation', 'Drip Irrigation', 'Sprinkler Systems', 'Wells & Tube Wells', 'Rainfed'],
      datasets: [{
        data: [30, 15, 20, 25, 10],
        backgroundColor: [
          'rgba(34, 197, 94, 0.8)',
          'rgba(16, 185, 129, 0.8)',
          'rgba(5, 150, 105, 0.8)',
          'rgba(4, 120, 87, 0.8)',
          'rgba(6, 95, 70, 0.8)'
        ],
        borderColor: [
          'rgba(255, 255, 255, 1)',
          'rgba(255, 255, 255, 1)',
          'rgba(255, 255, 255, 1)',
          'rgba(255, 255, 255, 1)',
          'rgba(255, 255, 255, 1)'
        ],
        borderWidth: 2
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: {
          position: 'top',
        },
        title: {
          display: true,
          text: 'Irrigation Methods Distribution (%)'
        }
      }
    }
  });

  // Add some scroll animation
  window.addEventListener('scroll', function() {
    const elements = document.querySelectorAll('.glass-card');
    elements.forEach(el => {
      const position = el.getBoundingClientRect();
      
      // If element is in viewport
      if(position.top < window.innerHeight && position.bottom >= 0) {
        el.classList.add('animate__animated', 'animate__fadeIn');
      }
    });
  });
</script>

</body>
</html>